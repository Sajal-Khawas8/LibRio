<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreBookRequest;
use App\Models\Book;
use App\Models\Category;
use App\Models\Quantity;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::with('quantity')->active()->filter(request(['search', 'category']))->simplePaginate(10);
        $categories = Category::lazy();
        return view('pages.admin.books.index', compact('books', 'categories'));
    }

    public function create()
    {
        $categories = Category::lazy();
        return view("pages.admin.books.add", compact("categories"));
    }

    public function store(StoreBookRequest $req)
    {
        try {
            DB::transaction(function () use ($req) {
                $validated = $req->validated();
                $book = Book::create([
                    'title' => $validated['title'],
                    'author' => $validated['author'],
                    'description' => $validated['description'],
                    'cover' => $req->file('cover')->store('books'),
                    'category_id' => $validated['category'],
                    'rent' => $validated['rent'],
                    'fine' => $validated['fine'],
                ]);

                Quantity::create([
                    'book_id' => $book->id,
                    'copies' => $validated['copies'],
                    'available' => $validated['copies'],
                ]);
            });
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with("error", "Something went wrong, please try again.");
        }

        return redirect()->route("admin.books.index")
            ->with("success", $validated['title'] . " has been added.");
    }

    public function edit(Book $book)
    {
        $book->load('quantity');
        $categories = Category::lazy();
        return view("pages.admin.books.edit", compact("book", "categories"));
    }

    public function update(StoreBookRequest $req, Book $book)
    {

        try {
            DB::transaction(function () use ($req, $book) {
                $validated = $req->validated();
                $booksOnRent = $book->quantity->copies - $book->quantity->available;
                if (($validated['copies'] ?? $book->quantity->copies) < $booksOnRent) {
                    throw ValidationException::withMessages([
                        "copies" => "Please note: $booksOnRent books have been given on rent"
                    ]);
                }
                Quantity::where('book_id', $book->id)->update([
                    'copies' => $validated['copies'],
                    'available' => $validated['copies'] - $booksOnRent,
                ]);

                if ($validated['cover'] ?? false) {
                    $filePath = $req->file('cover')->store('books');
                    Storage::delete($book->cover);
                }

                $book->update([
                    'title' => $validated['title'],
                    'author' => $validated['author'],
                    'description' => $validated['description'],
                    'cover' => $filePath ?? $book->cover,
                    'category_id' => $validated['category'],
                    'rent' => $validated['rent'],
                    'fine' => $validated['fine'],
                ]);

            });
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with("error", "Something went wrong, please try again.");
        }

        return redirect()->route("admin.books.index")->with("success", "Book data has been updated.");
    }

    public function destroy(Book $book)
    {
        if ($book->quantity->available !== $book->quantity->copies) {
            return back()->with("error", $book->quantity->copies - $book->quantity->available . " copie(s) of this book are given on rent. So it cannot be deleted at the moment!!");
        }

        $book->delete();
        return redirect()->route("admin.books.index")->with("success", "Book has been deleted successfully.");
    }

    public function rentedBooks()
    {
        $books = Book::has('orders')->with(['orders.user', 'quantity'])->filter(request(['search', 'category']))->simplePaginate(10);
        $books->pluck('orders')->flatten()->each->setAppends(['duration', 'rent', 'overdueDays', 'fine']);

        $categories = Category::lazy();
        return view('pages.admin.rented-books', compact('books', 'categories'));
    }
}
