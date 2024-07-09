<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function getCarts(){
        if( auth()->guard('admin')->check()){
        $Cart=Cart::paginate(6);
         return response()->json([
        'Cart'=>$Cart,
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

   

    public function desoryCart($id){

        if( auth()->guard('admin')->check()){
        $Cart=Cart::find($id);

        if(!$Cart){
            return response()->json([
                'message' => 'Cart not found',
                'status'=> 0 ,
            ]);
            
        }
        if($Cart){
            $Cart->delete($id);
            return response()->json([
                'message' => 'Cart deleted',
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
