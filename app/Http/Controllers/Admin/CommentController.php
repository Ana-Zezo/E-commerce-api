<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function getComments(){
         if( auth()->guard('admin')->check()){ 
        $Comments=Comment::paginate(6);
         return response()->json([
        'Comments'=>$Comments,    
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
   

    public function desoryComment($id){
        if( auth()->guard('admin')->check()){
        $Comment=Comment::find($id);

          if(!$Comment){
              return response()->json([
                  'message' => 'Comment not found',
                  'status'=> 0 ,
                
              ]);
            
          }
        $Comment->delete($id);

         if($Comment){
            return response()->json([
                'message' => 'Comment Deleted Successfully',
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