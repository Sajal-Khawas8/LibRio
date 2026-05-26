<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class ReadersController extends Controller
{
    public function index()
    {
        $users = User::role('reader')->filter(request('search'))->with('orders.book')->simplePaginate(6);
        $users->pluck('orders')->flatten()->each->setAppends(['duration', 'rent', 'overdueDays', 'fine']);
        return view("pages.admin.readers", compact("users"));
    }

    public function destroy(Request $req, User $user)
    {
        if ($user->has('orders')) {
            return redirect()->back()->with('error', 'This user has taken some books on rent!');
        }
        $user->delete();
        return redirect()->route('admin.readers.index')->with("success", "User has been blocked!");
    }
}
