<?php

namespace App\Http\Controllers;
use App\Models\Comment;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{
    public function addStars(Request $request){
        if(auth()->check()){

        $validator = Validator::make($request->all(), [
            'star' => 'required|min:1|max:5',
        ]);

        $user=auth()->user()->id;
        $star = $request->input('star');
        $product_id = $request->input('product_id');

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ]);
        }else{
            Comment::create([
                'star' =>$star,
                'user_id' => $user,
                'product_id' =>$product_id,
                'total_rate' =>$request->total_rate, 
            ]);
        }

        return response()->json([
         'message'=>'Commented Added Successfully',
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




public function myComments(){

    if(auth()->check()){
    $user_id=auth()->user()->id;
    $myComments=Comment::where('user_id',$user_id)->paginate(6);
 
    return response()->json([
        'myComments'=>$myComments,
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
   

   public function deletemyComment($id){

    if(auth()->check()){
        $user_id = auth()->guard('user')->user()->id;
        Comment::where('user_id',$user_id)->delete($id);
            return response()->json([
                'message'=>'the Comment DELETED successfully',
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
