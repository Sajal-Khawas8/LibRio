<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Order;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::with("category")->filter(request(['search', 'category']))->lazy()->groupBy(fn($book) => $book->category->name);
        $categories = Category::lazy();
        return view("pages.client.index", compact('books', 'categories'));
    }

    public function show(Book $book)
    {
        $book = $book->load(["category", "quantity"]);
        $showAddToCart = !Cart::where("user_id", auth()->id())
            ->where("book_id", $book->id)
            ->exists() &&
            !Order::where('book_id', $book->id)
                ->where('user_id', auth()->id())
                ->exists();
        $isRentable = !Order::where('book_id', $book->id)
                ->where('user_id', auth()->id())
                ->exists();
        return view("pages.client.book-details", compact("book", "showAddToCart", "isRentable"));
    }
}