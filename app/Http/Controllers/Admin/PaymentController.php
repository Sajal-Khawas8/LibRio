<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;

class PaymentController extends Controller
{
    public function index()
    {
        $payments=Payment::filter(request('search'))->simplePaginate(10);
        return view("pages.admin.payments", compact("payments"));
    }
}
