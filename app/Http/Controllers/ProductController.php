<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;

use App\Models\Product;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\QueryBuilder\QueryBuilder;
class ProductController extends Controller
{
    // show products
    public function getProducts(){
        $products=Product::paginate(6);
        return response()->json([
            'products'=>$products,
             'status'=>1
        ]);
    }
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////

        // show getProductsForCategory
    public function getProductsForCategory($id){
        $products=Product::where('category_id',$id)->paginate(6);

        return response()->json([
            'products'=>$products,
             'status'=>1
        ]);
    }
    
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    public function viewDetails($id){
        if(auth()->check()){  
        $product=Product::where('id',$id)->first();
        $review=Comment::where('product_id',$id)->first();
        $average=$review->sum('star') / $review->count();

        return response()->json([
            'products'=>$product,
            'total_rate'=>round($average,1),
             'status'=>1
        ]);
       }

       
        else{
            return response()->json([
                'message'=>'you arenot authenticated',
                'status'=> 0 ,

            ]);
        }


}
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    public function topRatedProducts(){
        $Comments=Comment::select('total_rate')->get();

        foreach($Comments as $Comment){
            $ProductHaveComment=
            $average=$Comment->sum('star') / $Comment->count();
        }


        // sum star products
        $products=Comment::where('category_id',$id)->paginate(6);
        return response()->json([
            'products'=>$products,
             'status'=>1
        ]);
    }
    
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    public function bestSeller(){
        // sum order product
        $products=Cart::groupBy('total_rate')->ordededBy('total_rate','desc')->paginate(6);
        return response()->json([
            'products'=>$products,
             'status'=>1
        ]);
        // PurchasedItem::select(DB::raw('COUNT(id) as cnt', 'voucher_id'))
        // ->groupBy('voucher_id')->orderBy('cnt', 'DESC')->first();
    }



///////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    public function SearchtProducts(){
    if(auth()->check()){  
    $products = QueryBuilder::for(Product::class)
    ->allowedFilters('name')
    ->get();
    return response()->json([
        'products'=>$products,
         'status'=>1
    ]);
    } 
    else{
        return response()->json([
            'message'=>'you arenot authenticated',
            'status'=> 0 ,

        ]);
    }
}


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}



