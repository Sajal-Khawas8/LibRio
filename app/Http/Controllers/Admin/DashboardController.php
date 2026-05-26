<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Category;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Quantity;
use App\Models\User;

class DashboardController extends Controller
{
    public function __invoke()
    {
        $data = [
            'books' => Book::count(),
            'categories' => Category::count(),
            'quantity' => Quantity::sum("copies"),
            'orders' => Order::count(),
            'users' => (object) User::with('roles')->get()->countBy(fn($user) => $user->getRoleNames()->first())->toArray(),
            'transactions' => Payment::count(),
            'income' => (object) Payment::all()->groupBy('type')->map(fn($group) => $group->sum('amount'))->toArray(),
        ];
        $data['income']->total = array_sum((array)$data['income']);
        $data = (object) $data;

        return view("pages.admin.index", compact('data'));
    }
}
