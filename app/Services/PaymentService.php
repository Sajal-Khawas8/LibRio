<?php

namespace App\Services;

use App\Models\PaidItem;
use App\Models\Payment;
use Razorpay\Api\Api;

class PaymentService
{
    private function getRazorpayApi()
    {
        return new Api(config("payment.RAZORPAY_KEY"), config("payment.RAZORPAY_SECRET"));
    }

    public function createOrder($amount)
    {
        $order = $this->getRazorpayApi()->order->create(
            [
                'receipt' => str_replace('-', '', uuid_create()),
                'amount' => $amount * 100,
                'currency' => 'INR'
            ]
        );
        return $order->id;
    }

    public function getSecret()
    {
        return $this->getRazorpayApi()->getSecret();
    }

    public function processPayment($paymentResponse, $type, $books)
    {
        $paymentData = $this->getRazorpayApi()->payment->fetch($paymentResponse->razorpay_payment_id)->toArray();
        $payment = Payment::create([
            "transaction_id" => $paymentResponse->razorpay_payment_id,
            "user_id" => auth()->id(),
            "amount" => $paymentData['amount'] / 100,
            "type" => $type,
            "payload" => $paymentData,
        ]);

        // Add payment and book data to paid_items table
        $items = [];
        foreach ($books as $book) {
            $items[] = [
                'payment_id' => $payment->id,
                'book_id' => $book['id'],
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        PaidItem::insert($items);

        return $payment;
    }
}