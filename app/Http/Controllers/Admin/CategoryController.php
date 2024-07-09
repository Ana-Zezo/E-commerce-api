<?php

namespace App\Http\Controllers\Admin;
use App\Models\Category;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function getCats(){

        if( auth()->guard('admin')->check()){
        $categories=Category::select('id','name','image')->paginate(6);
         return response()->json([
        'categories'=>$categories,
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

    public function storeCategory(Request $request){
        if( auth()->guard('admin')->check()){

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'image' => 'required|image|mimes:jpg,png,jpeg',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ]);
        }
        
        else{
            if($request->has('image')){
                $file = $request->file('image');
                $name = time();
                $extension = $file->extension();
                 $fileName = $name.'.'.$extension;
                $file->move('ImagesCategories',$fileName);
                
                $NewCategory=Category::create([
                'name' => $request->input('name'),
                'desc' => $request->input('desc'),
                'image' => $fileName,
            ]);

            };
            if($NewCategory){
                return response()->json([
                    'message'=>' Category Added Successfully',
                    'status'=> 1 ,
                ]);
            
            }
            
        }

       

    }
    else{
      return response()->json([
        "status" => 0,
        "message" => "You Arenot Authenticated",
        
    ]);
    }
    }


    public function updateCategory(Request $request,$id){

        if( auth()->guard('admin')->check()){

        $Category=Category::find($id);

        if(!$Category){
            return response()->json([
                'message'=>' Category Not Found',
                'status'=> 0 ,
            ]);
        }
        $Category->update($request->all());

        if($Category){
            
            return response()->json([
                'message'=>' Category  updated successfully',
                'status'=> 1 ,
            ]);

        }
        if($request->all() == null){
            
            return response()->json([
                'message'=>' You Must Edit a One Value at Least',
                'status'=> 0 ,
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


    public function desoryCategory($id){
        if( auth()->guard('admin')->check()){

        $Category=Category::find($id);
        if(!$Category){
            return response()->json([
                'message'=>' Category Not Found',
                'status'=> 0 ,
            ]);
        }
        $Category->delete($id);

        if($Category){
            
            return response()->json([
                'message'=>' Category Deleted',
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
