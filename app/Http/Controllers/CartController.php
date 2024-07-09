<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;

use App\Models\Cart;
use App\Models\Product;
use App\Models\User;
use App\Models\ProductTrending;
use Illuminate\Http\Request;
use App\Http\Requests\AddToCartRequest;

class CartController extends Controller
{


    public function addtoCart(AddToCartRequest $request){

        if(auth()->guard('user')->check()){

            $user_id = auth()->guard('user')->user()->id;
            $product_id = $request->input('product_id');
            $quantity = $request->input('quantity');

            //  $quantity = $request->input('adding_number');
    

            Cart::create([
                'user_id'=>$user_id ,
                'quantity'=>$quantity ,
                'product_id'=>$product_id,

                // 'adding_number'=> 1++

            ]);

           /*  if($product_id){
                $product=Cart::where('product_id',$product_id)->first();
                $product->update([
                     'adding_number'=> 1++
                ])
            } */
           
            return response()->json([
                'message'=>'product  added successfully',
                'status'=> 1 ,
            ]); 
        

            if(Cart::where('user_id',$user_id)->where('product_id',$product_id)->exists()){
                return response()->json([
                    'message'=>'the product is exist already',
                    'status'=> 0 ,
                ]);
            }
            } 
           else{
            return response()->json([
                'message'=>'you arenot authenticated',
                'status'=> 0 ,

            ]);
        }

    }


    


    public function checkoutCart(){

        if(auth()->check()){
            $user_id = auth()->user()->id;
            $cart=Cart::select('product_id','quantity')->where('user_id',$user_id)->paginate(6);
            return response()->json([
                'data'=>$cart,
                'status'=> 1 ,

            ]);
        } else{
            return response()->json([
                'message'=>'you arenot authenticated',
                'status'=> 0 ,

            ]);
        }

    }

    public function deletefromCart($id){

        if(auth()->check()){
            $user_id = auth()->guard('user')->user()->id;
            Cart::where('user_id',$user_id)->delete($id);
                return response()->json([
                    'message'=>'the product DELETED successfully',
                    'status'=> 1 ,

                ]);

            }else{
                return response()->json([
                    'message'=>'you arenot authenticated',
                    'status'=> 0 ,
    
                ]);
            }

    }

    public function showMyCart(){

        if(auth()->check()){
    
           $user_id = auth()->user()->id;
           $carts=Cart::where('user_id',$user_id)->paginate(6);
           return response()->json([
           'carts' => $carts,
           ]);
        
        } else{
            return response()->json([
                'message'=>'you arenot authenticated',
                'status'=> 0 ,
    
            ]);
        }
    
       }

    
    public function MyCartCount(){

    if(auth()->check()){

       $user_id = auth()->user()->id;
       $count=Cart::where('user_id',$user_id)->get();
       $total=$count->sum('quantity');
       return response()->json([
       'count' => $total,
       ]);
    
    } else{
        return response()->json([
            'message'=>'you arenot authenticated',
            'status'=> 0 ,

        ]);
    }

   }

    public function updateQuantity($id,$action){
        $user_id=auth()->user()->id;
        $cart=Cart::where('id',$id)->where('user_id',$user_id)->first();

        if(auth()->check()){

         if($action == "inc"){
            $cart->quantity += 1;
        }
        else if($action == "dec"){
            $cart->quantity -= 1;
        }
        $cart->update();
        return response()->json([
            'message'=>'Quantity  Updated Successfully',
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
