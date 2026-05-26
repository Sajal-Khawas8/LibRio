<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Order;
use App\Models\Quantity;
use App\Models\RentHistory;
use App\Services\PaymentService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookHistoryController extends Controller
{
    private PaymentService $paymentService;

    public function __construct(PaymentService $paymentService)
    {
        $this->paymentService = $paymentService;
    }

    public function index()
    {
        $currentReads = Order::where("user_id", auth()->id())->with("book")->get();
        $previousReads = RentHistory::where("user_id", auth()->id())->with("book")->latest()->get()->unique('book_id');
        return view("pages.client.my-books", compact("currentReads", "previousReads"));
    }

    public function show(Book $book)
    {
        try {
            $rentData = Order::where("user_id", auth()->id())
                ->where("book_id", $book->id)->firstOrFail()->setAppends(['duration', 'rent', 'overdueDays', 'fine']);
            $orderId = null;
            if ($rentData->fine) {
                $orderId = $this->paymentService->createOrder($rentData->fine);
                session([
                    'orderId' => $orderId,
                    'book' => $book->uuid,
                ]);
            }
            return view("pages.client.return-book", compact("book", "rentData", "orderId"));
        } catch (ModelNotFoundException $ex) {
            abort(400, "No Record Found");
        }
    }

    public function return(Book $book)
    {
        DB::beginTransaction();
        try {
            $this->processReturn($book->id);
            DB::commit();
            return redirect()->route('client.myBooks.index')->with('success', 'Book returned successfully.');
        } catch (Exception $e) {
            DB::rollBack();
            \Log::info($e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong!');
        }
    }

    public function fine(Request $req)
    {
        DB::beginTransaction();
        try {
            // Get payment response
            $paymentResponse = json_decode($req->paymentResponse);

            // Verify the signature
            $generated_signature = hash_hmac('sha256', session()->get('orderId') . '|' . $paymentResponse->razorpay_payment_id, $this->paymentService->getSecret());
            $book = session()->get('book');
            session()->forget(['orderId', 'book']);
            if (!hash_equals($paymentResponse->razorpay_signature, $generated_signature)) {
                return redirect('/')->with('error', 'Something went wrong. Please try again later.');
            }

            $books = Book::where('uuid', $book)->get()->toArray();
            $payment = $this->paymentService->processPayment($paymentResponse, 'fine', $books);
            $this->processReturn($books[0]['id'], $payment->amount);
            DB::commit();
            return redirect()->route("client.myBooks.index")->with('success', "Book returned successfully.");
        } catch (Exception $e) {
            DB::rollBack();
            \Log::info($e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong!');
        }
    }

    public function history(Book $book)
    {
        try {
            $rentData = RentHistory::where("user_id", auth()->id())
                ->where("book_id", $book->id)->firstOrFail()->setAppends(['duration', 'overdueDays']);
            return view("pages.client.book-history", compact("book", "rentData"));
        } catch (ModelNotFoundException $ex) {
            abort(400, "No Record Found");
        }
    }

    private function processReturn($bookId, $fine = 0)
    {
        $order = Order::where("user_id", auth()->id())->where("book_id", $bookId)->first();
        RentHistory::create([
            'user_id' => auth()->id(),
            'book_id' => $bookId,
            'issue_date' => $order->issue_date,
            'due_date' => $order->due_date,
            'return_date' => now()->toDate(),
            'rent_paid' => $order->rent,
            'fine_paid' => $fine,
        ]);
        $order->delete();
        Quantity::where('book_id', $bookId)->increment('available');
    }
}
