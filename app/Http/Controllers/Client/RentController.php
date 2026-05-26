<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\BookPaymentRequest;
use App\Models\Book;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Quantity;
use App\Services\PaymentService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class RentController extends Controller
{
    private PaymentService $paymentService;

    public function __construct(PaymentService $paymentService)
    {
        $this->paymentService = $paymentService;
    }

    public function acceptPayment(Request $req)
    {
        DB::beginTransaction();
        try {
            // Get payment response
            $paymentResponse = json_decode($req->paymentResponse);

            // Verify the signature
            $generated_signature = hash_hmac('sha256', session()->get('orderId') . '|' . $paymentResponse->razorpay_payment_id, $this->paymentService->getSecret());
            $books = collect(session()->get('books'));
            session()->forget(['orderId', 'books']);
            if (!hash_equals($paymentResponse->razorpay_signature, $generated_signature)) {
                return redirect('/')->with('error', 'Something went wrong. Please try again later.');
            }

            $bookUuids = $books->map(fn($book) => explode('/', $book)[0]);
            $bookMap = Book::whereIn('uuid', $bookUuids)->pluck('id', 'uuid');
            $books = $books->map(function ($book) use ($bookMap) {
                [$bookUuId, $returnDate] = explode('/', $book);
                $id = $bookMap[$bookUuId] ?? null;
                return compact('id', 'returnDate');
            });

            $payment = $this->paymentService->processPayment($paymentResponse, 'rent', $books);

            $books->each(function ($book) use ($payment) {
                // Remove the book from the cart of user
                Cart::where('user_id', auth()->id())->where('book_id', $book['id'])->delete();

                // Insert book data in orders table to list it on 'myBooks'
                Order::create([
                    'book_id' => $book['id'],
                    'user_id' => auth()->id(),
                    'issue_date' => now()->format('Y-m-d'),
                    'due_date' => $book['returnDate']
                ]);

                // Decrease the quantity of the book
                Quantity::where('book_id', $book['id'])->decrement('available');
            });

            DB::commit();
            return redirect()->route("client.myBooks.index")->with('success', "Payment Successful");
        } catch (Exception $e) {
            DB::rollBack();
            \Log::info($e->getMessage());
            return redirect()->route('client.books.index')->with('error', 'Something went wrong!');
        }
    }

    public function initiatePayment(BookPaymentRequest $req)
    {
        try {
            $books = collect($req->books);

            $booksData = $books->map(function ($item) {
                $book = Book::firstWhere('id', $item['id']);
                $amount = round($book->rent * (now()->startOfDay()->diffInDays(Carbon::parse($item['returnDate'])->startOfDay()) + 1), 2);
                $book->rent_payable = $amount;
                return [
                    'model' => $book,
                    'amount' => $amount,
                    'session' => "{$book->uuid}/{$item['returnDate']}"
                ];
            });

            $totalAmount = $booksData->sum('amount');
            $orderId = $this->paymentService->createOrder($totalAmount);

            session([
                'orderId' => $orderId,
                'books' => $booksData->pluck('session')->toArray()
            ]);

            return view("pages.client.checkout-page", [
                "books" => $booksData->pluck('model'),
                "total_amount" => $totalAmount,
                "orderId" => $orderId
            ]);
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
