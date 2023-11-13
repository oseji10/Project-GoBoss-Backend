<?php

namespace App\Http\Controllers;
use Marvel\Database\Models\Order;
use Illuminate\Http\Request;
use App\Models\Transaction; // Replace with your transaction model
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class PaystackWebhookController extends Controller
{
    public function handleSuccess(Request $request)
    {
        // Retrieve the Paystack webhook data
        $trxref = $request->input('trxref');
        // $response = Http::get("https://api.paystack.co/transaction/{$trxref}");


        $response = Http::withHeaders([
            "Authorization" => "Bearer " . config('shop.paystack.secret_key'),
            "Cache-Control" => "no-cache",
          ])->get("https://api.paystack.co/transaction/verify/{$trxref}");



        $payload = $request->all();

        // Log::info($response);
        // Verify the webhook data if necessary
        // ...

        // Store the transaction data in your database
        // $transaction = Transaction::create([
        //     'reference' => $payload['data']['reference'],
        //     'amount' => $payload['data']['amount'],
        //     // Add other fields as needed
        // ]);

        // Perform any additional logic or send notifications
        // ...

        // Return a response to acknowledge the webhook

        if ($response->successful()) {
            $transaction = $response->json()['data'];

            // Extract the desired fields from the transaction data
            $email = $transaction['customer']['email'];
            $receiptNumber = $transaction['receipt_number'];
            $amount = $transaction['amount'];

            // Process the extracted data as needed
            // ...

            // if (Order::where('id', $id)->exists()) {
            //     $department = Department::find($id);
            //     $department->department_name = is_null($request->department_name) ? $department->department_name : $request->department_name;
            //     $department->remarks = is_null($request->remarks) ? $department->remarks : $request->remarks;
            //     // $department->department_id = is_null($request->department) ? $unit->department_id : $request->department_id;
            //     $department->save();
            //     return redirect('/departments')->with('success', "ECF has successfuly been updated.");
            // }
            // return $email;
            return redirect('https://shop.goboss.com.ng/order-success')->with('success', "Order successfuly placed.");


        }



        return response()->json(['message' => 'Webhook received and processed successfully']);
    }
}
