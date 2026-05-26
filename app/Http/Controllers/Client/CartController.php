<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\ManageCartRequest;
use App\Models\Cart;
use App\Models\Order;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = Cart::where("user_id", auth()->id())->with("book.quantity")->lazy();
        return view("pages.client.cart", compact("cartItems"));
    }

    public function store(ManageCartRequest $req)
    {
        if (Cart::where("user_id", auth()->id())->where("book_id", $req->book)->exists()) {
            return redirect()->route("client.cart.index")->with("success", "This book is already in your cart.");
        }

        if (Order::where("user_id", auth()->id())->where("book_id", $req->book)->exists()) {
            return back()->with("error", "You have alraedy rented this book.");
        }

        Cart::create([
            "user_id" => auth()->id(),
            "book_id" => $req->book
        ]);

        return redirect()->route("client.cart.index")->with("success", "Book added to the cart.");
    }

    public function destroy(ManageCartRequest $req)
    {
        if (!Cart::where("user_id", auth()->id())->where("book_id", $req->book)->exists()) {
            return back()->with("error", "This book is not in your cart.");
        }

        Cart::where("user_id", auth()->id())
            ->where("book_id", $req->book)
            ->delete();

        return back()->with("success", "Book has been removed from the cart.");
    }
}