<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Orders;

class OrdersController extends Controller
{
    public function allOrders(){
        $orders = Orders::all();
        return $orders;
    }


    public function myOrders(Request $request){
        $orders = Orders::select('*')->where('customer_id', '=', 7)->get();
        return $orders;
    }
}
