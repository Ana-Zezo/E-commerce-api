<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Validator;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
class ProductController extends Controller
{
    public function getProducts(){
        if(auth()->guard('admin')->check()){ 
        $products=Product::paginate(6);
         return response()->json([
        'products'=>$products, 
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

    public function storetProduct(Request $request){
        if( auth()->guard('admin')->check()){ 
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'desc' => 'required',
            'price' => 'required',
            'category_id' => 'required',
            'image' => 'required|image|mimes:jpg,png,jpeg',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ]);
        }else{
           
            if($request->has('image')){
                $file = $request->file('image');
                $name = time();
                $extension = $file->extension();
                 $fileName = $name.'.'.$extension;
                $file->move('ImagesProducts',$fileName);
            };

            Product::create([
                'name' =>$request->input('name'),
                'desc' =>$request->input('desc'),
                 'price' =>  $request->input('price'),
                 'category_id' =>$request->input('category_id'),
                'image' => $fileName,
            ]);
        }
        
        return response()->json([
            'message' => 'Product Added Successfully',
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


    public function updatetProduct(Request $request,$id){
        if( auth()->guard('admin')->check()){ 

        $Product=Product::find($id);

        if(!$Product){
            return response()->json([
            'message' => 'Product not found',
            'status'=>0
            ]);
        }

        $Product->update($request->all());

        if($Product){
            return response()->json([
                'message' => 'Product  updated successfully',
                'status'=>1

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


    public function desorytProduct($id){
        if( auth()->guard('admin')->check()){ 
        $Product=Product::find($id);

        if(!$Product){
            return response()->json([
                'message' => 'Product not found',
                'status'=>0
            ]);
            
        }
        $Product->delete($id);

        if($Product){
            return response()->json([
                'message' => 'Product Delted',
                'status'=>1
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
