<?php

// namespace Marvel\Payments;
namespace Marvel\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction; // Replace with your transaction model

// class PaystackWebhookController extends CoreController
class PaystackWebhookController extends CoreController

{
    public function handleSuccess(Request $request)
    {
        // Retrieve the Paystack webhook data
        $payload = $request->all();
return $payload;
        // Verify the webhook data if necessary
        // ...

        // Store the transaction data in your database
        $transaction = Transaction::create([
            'reference' => $payload['data']['reference'],
            'amount' => $payload['data']['amount'],
            // Add other fields as needed
        ]);

        // Perform any additional logic or send notifications
        // ...

        // Return a response to acknowledge the webhook
        // return response()->json(['message' => 'Webhook received and processed successfully']);
    }
}
