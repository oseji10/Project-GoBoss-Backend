<?php

namespace App\Http\Controllers;

use Unicodeveloper\Paystack\Facades\Paystack;

class PaystackController extends Controller
{
    public function initiatePayment()
    {
        $ref2 = "84849rjjidididsasdklwaslzdkqwsaodkewqspaokdxjr94";
        $reference = uniqid(); // Generate a unique reference for the transaction

        $request = Paystack::getAuthorizationUrl()->withReference($reference)->withEmail('user@example.com')->withAmount(1000);

        return redirect()->to($request->authorization_url);
    }

    public function handlePaymentCallback()
    {
        $paymentDetails = Paystack::getPaymentData();

        // Handle payment callback and update your application accordingly

        return view('payment.callback', compact('paymentDetails'));
    }
}
