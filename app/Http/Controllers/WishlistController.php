<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;

use App\Models\Wishlist;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function addWishlist(Request $request){
        if(auth()->check()){
        $user=auth()->user()->id;
        $product_id=$request->input('product_id');
        Wishlist::create([
            'user_id'=>$user,
            'product_id'=>$product_id,
        ]);
     
        return response()->json([
            'message'=>'Wishlist Added Syccessfully',
            'status'=>1,
        ]);
    }
    else{
        return response()->json([
            'message'=>'you arenot authenticated',
            'status'=> 0 ,

        ]);
    }
}

public function myWishlists(Request $request){
    if(auth()->check()){
    $user_id=auth()->user()->id;
    $MyWishlists=Wishlist::where('user_id',$user_id)->paginate(6);
 
    return response()->json([
        'MyWishlists'=>$MyWishlists,
        'status'=>1,
    ]);
}
else{
    return response()->json([
        'message'=>'you arenot authenticated',
        'status'=> 0 ,

    ]);
}
}

public function deleteFromWishlists($id){
    if(auth()->check()){
        $Wishlist=Wishlist::find($id);

        if(!$Wishlist){
            return response()->json([
                'message' => 'Wishlist not found',
                'status'=>0
            ]);
            
        }
        $Wishlist->delete($id);

        if($Wishlist){
            return response()->json([
                'message' => 'Wishlist Delted',
                'status'=>1
            ]);
        }
 
    return response()->json([
        'MyWishlists'=>$MyWishlists,
        'status'=>1,
    ]);
}
else{
    return response()->json([
        'message'=>'you arenot authenticated',
        'status'=> 0 ,

    ]);
}

}



}
