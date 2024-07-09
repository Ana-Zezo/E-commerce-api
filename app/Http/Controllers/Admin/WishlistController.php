<?php

namespace App\Http\Controllers\Admin;

use App\Models\Wishlist;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class WishlistController extends Controller
{
    
    public function getWishlists()
    {
        if( auth()->guard('admin')->check()){ 
        $Wishlist=Wishlist::paginate(6);
        return response()->json([
            'Wishlist'=>$Wishlist,
            'status'=>1
        ]);
    }
    else{
       return response()->json([
         "status" => 0,
         "message" => "You Arenot Authenticated",
         
     ]);
     } 
    }



    public function sendNotification()
    {
        //cron job
        
        // send 
    }

    
}
