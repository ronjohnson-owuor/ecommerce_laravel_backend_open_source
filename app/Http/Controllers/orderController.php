<?php

namespace App\Http\Controllers;

use App\Models\Custom;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Throwable;

class orderController extends Controller
{
    public function customorder (Request $request){
        $user = Auth::user();
        Custom::create([
            'email' => $user->email,
            'phone' => $user->phone,
            'order' => $request->order,
            'location' => $user->location
        ]);
        return response() -> json($user);
    }
    
    public function makeorder (Request $request){
        try{
        $request->validate([
            'data' => 'required|array'
        ]);            
        }catch(ValidationException $exe){
            return response() -> json([
                "message" => "you have an empty cart"
            ]);
        }
        // authenticate the user using the token
        $user = Auth::user();
        // loop through the data array and insert them to the database
        $orders  = $request -> data;
        foreach ($orders as $order) {
            Order::create([
                'product_name' => $order['name'],
                'product_quantity'=> $order['quantity'],
                'product_image' => $order['image_link'],
                'product_price' => $order['price'],
                'product_delivered' => false,
                'customer_name' => $user->name,
                'customer_number'=> $user->phone,
                'customer_email'=> $user->email,
                'customer_location'=> $user->location
            ]);
        }  
        return response() -> json([
            "message" =>"order successfull",
            "clear" => true
        ]); 
    }
    
    
    
    public function getorder(Request $request){
        $order = Order::where('product_delivered',false)->get();
        return response() -> json([
            "message"=>$order,
        ]);
    }
    
    // mark order as delivered
    public function delivered(Request $request){
        $order = Order::where('id',$request->id) ->first();
        $order -> product_delivered = true;
        $order->save();
        return response() ->json([
            "message" => "order marked as delivered"
        ]);
    }
    
}
