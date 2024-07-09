<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;

use App\Models\Order; 
use App\Models\OrderDetails; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
class OrderController extends Controller
{
    public function addOrder(Request $request){
        if(auth()->check()){
        $validator = Validator::make($request->all(), [
            // 'userName' => 'required',
            'address' => 'required',
            'phone' => 'required|numeric',
            'street' => 'required',
            'cart_id' => 'required',
            'payment_type' => 'required',
            'price' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ]);
        }else{
                $order=Order::create([
                 'user_id' =>1,
                 'address' =>$request->input('address'),
                 'phone' =>$request->input('phone'),
                 'street' =>$request->input('street'),
                 'status' =>$request->input('status'),
                 'cart_id' =>$request->input('cart_id'),
                 'payment_type' =>$request->input('payment_type'),
                 'price' =>$request->input('price'),
            ]);
                  
            /*     OrderDetails::create([
                'order_id' =>$this->$order->id,
                'product_id' =>1,
                'user_id' =>1,
                'total_price' =>'200',
                'phone' =>$request->input('phone'),
                'street' =>$request->input('street'),
                'status' =>$request->input('status'),
                'cart_id' =>$request->input('cart_id'),
                'payment_type' =>$request->input('payment_type'),
                'price' =>$request->input('price'),
           ]);
 */
        }

       return response()->json([
                    'message'=>'the Order Added successfully',
                    'status'=> 1 ,

                ]);
    }
    else{
        return response()->json([
            'message'=>'you arenot authenticated',
            'status'=> 0 ,

        ]);
    }

}



    public function myOrders(){

    if(auth()->check()){
    $user_id=auth()->user()->id;
    $myOrders=Order::where('user_id',$user_id)->paginate(6);
 
    return response()->json([
        'myOrders'=>$myOrders,
        'status'=>1,
    ]);

    } else{
        return response()->json([
            'message'=>'you arenot authenticated',
            'status'=> 0 ,

        ]);
    }

   }

   public function deletemyOrder($id){

    if(auth()->check()){
         $user_id=auth()->user()->id;
        Order::where('user_id',$user_id)->delete($id);
            return response()->json([
                'message'=>'the Order DELETED successfully',
                'status'=> 1 ,

            ]);

        }else{
            return response()->json([
                'message'=>'you arenot authenticated',
                'status'=> 0 ,

            ]);
        }

}

}
