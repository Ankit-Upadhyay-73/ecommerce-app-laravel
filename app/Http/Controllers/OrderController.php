<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class OrderController extends Controller
{
    //
    
    public function index(Request $request)
    {
       $orders =  Order::where('user_id',$request->user()->id)->get();
       return view('UsersSide.orders')->with("orders",$orders);
    }

    public function store(Request $request)
    {   
        
        $order = new Order();
        $order->user_id=$request->user()->id;
        $order->totalAmount = $request->totalAmount;
        $order->Product = json_encode($request->Product);
        $order->save();

    }


    

}
