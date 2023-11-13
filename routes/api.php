<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Requests\ImageUploadRequest;

use Illuminate\Support\Facades\Storage;


use App\Http\Controllers\PaystackWebhookController;
use App\Http\Controllers\IMGController;
use App\Http\Controllers\OrdersController;
/**
 * ******************************************
 * Available Public Routes
 * ******************************************
 */

Route::get('/payment/initiate', [PaystackController::class, 'initiatePayment'])->name('payment.initiate');
Route::get('/payment/callback', [PaystackController::class, 'handlePaymentCallback'])->name('payment.callback');


Route::get('/paystack/webhook/success', [PaystackWebhookController::class, 'handleSuccess']);


Route::post('/upload', function (Request $request) {
    // images shouldn't exceed 2MB or it'll throw oan error.Will work on this in future
    if ($request->hasFile('image')) {
        $image = $request->file('image');
        $imageName = time() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('uploads'), $imageName);

        return response()->json(['success' => true, 'image_url' => '/uploads/' . $imageName]);
    }

    return response()->json(['success' => false, 'message' => 'No image uploaded.'], 400);


});



Route::post('image',[ImageController::class, 'imageStore']);
Route::post('upload_image', [IMGController::class, 'uploadImage']);

// Route::get('send-mail',function(){
//     dd("Hi");
// });
Route::get('send-mail', function () {

    $details = [
        'title' => 'Mail from ItSolutionStuff.com',
        'body' => 'This is for testing email using smtp'
    ];

    \Mail::to('vctroseji@gmail.com')->send(new \App\Mail\CreateShopMail($details));

    dd("Email is Sent.");
});

Route::get('orders',[OrdersController::class, 'allOrders']);
Route::get('myorders',[OrdersController::class, 'myOrders']);