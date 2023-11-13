<?php

namespace Marvel\Http\Controllers;

use Unicodeveloper\Paystack\Facades\Paystack;

class PaystackController extends CoreController
{
    public function initiatePayment()
    {
        $reference = uniqid(); // Generate a unique reference for the transaction

        $request = Paystack::getAuthorizationUrl()->withReference($reference)->withEmail('user@example.com')->withAmount(10000);

        return redirect()->to($request->authorization_url);
    }

    public function handlePaymentCallback()
    {
        $paymentDetails = Paystack::getPaymentData();

        // Handle payment callback and update your application accordingly

        return view('payment.callback', compact('paymentDetails'));
    }
}
