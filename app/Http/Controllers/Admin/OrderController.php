<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function getOrders(){
        if( auth()->guard('admin')->check()){ 
        $Orders=Order::paginate(6);
         return response()->json([
        'Orders'=>$Orders,
        'status'=> 1 ,
         ]); 
        }
        else{
           return response()->json([
             "status" => 0,
             "message" => "You Arenot Authenticated",
             
         ]);
         } 
    }

   

    public function desoryOrder($id){
        if( auth()->guard('admin')->check()){ 
        $Order=Order::find($id);
        
        if(!$Order){
            return response()->json([
                'message' => 'Order not found',
                'status'=> 0 ,
            ]);
            
        }
        $Order->delete($id);
        
        if($Order){
            return response()->json([
                'message' => 'Order deleted',
                'status'=> 1 ,
            ]);

        }
    }
    else{
       return response()->json([
         "status" => 0,
         "message" => "You Arenot Authenticated",
         
     ]);
     } 

    }   
   
}
