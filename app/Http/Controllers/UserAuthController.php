<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserAuthController extends Controller
{
    // USER REGISTER API - POST
 public function register(Request $request)
 {
     // validation
     $request->validate([
         "name" => "required",
         "email" => "required|email|unique:users",
         "password" => "required"
     ]);
// create user data + save  
    if($request->has('image')){
      $file = $request->file('image');
      $name = time();
      $extension = $file->extension();
      $fileName = $name.'.'.$extension;
      $file->move('ImagesUsers',$fileName);
      $user = new User();
      $user->name = $request->name;
      $user->email = $request->email;
      $user->password = bcrypt($request->password);
      $user->image = $fileName;
     $user->save();
    }else{
      $user = new User();
      $user->name = $request->name;
      $user->email = $request->email;
      $user->password = bcrypt($request->password);
     $user->save();

    }
    
// send response
     return response()->json([
         "status" => 1,
         "message" => "User registered successfully"
     ], 200);
 }
      // User LOGIN API - POST
  public function login(Request $request)
  {
      // validation
      $request->validate([
          "email" => "required|email",
          "password" => "required"
      ]);
// verify user + token
      if (!$token = auth()->guard()->attempt(["email" => $request->email, "password" => $request->password])) {
        return response()->json([
              "status" => 0,
              "message" => "Invalid credentials"
          ]);
      }
// send response
      return response()->json([
          "status" => 1,
          "message" => "Logged in successfully",
          "access_token" => $token
      ]);
  }
// USER PROFILE API - GET
  public function profile()
  {
      $User_data= auth()->guard()->user();
    if( auth()->check()){

     return response()->json([
          "status" => 1,
          "message" => "User profile data",
          "data" => $User_data
      ]);
    }else{
        return response()->json([
            "status" => 0,
            "message" => "User Not Found"
        ]); 
    }
  }
// USER LOGOUT API - GET
  public function logout()
  {
    if( auth()->check()){
      auth()->guard()->logout();
     return response()->json([
          "status" => 1,
          "message" => "User logged out"
      ]);
    }else{
        return response()->json([
            "status" => 0,
            "message" => "User Not Found"
        ]); 
    }
  }
  

  // USER UPDATE API - GET
  public function updateProfile(Request $request)
  {
    if( auth()->check()){
        $user_id=auth()->guard('user')->user()->id;
        $user=user::where('id',$user_id)->first();
      if($request->email == null && $request->password != null ){
        

        $user->update([
         'password'=>$request->password
        ]);
      
     return response()->json([
          "status" => 1,
          "message" => "password Changed"
      ]);
    }
      else if($request->email != null && $request->password == null ){
        $user->update([
         'email'=>$request->email
        ]);
      
        return response()->json([
          "status" => 1,
          "message" => "email Changed"
      ]); 
    }
    else{
        $user->update([
            'name'=>$request->name
           ]);
          return response()->json([
            "status" => 1,
            "message" => "Name Changed"
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



  public function deleteMyAccount()
  {

      if(auth()->check()){
          $user_id = auth()->user()->id;
          User::where('id',$user_id)->delete();
              return response()->json([
                  'message'=>'the Account DELETED successfully',
                  'status'=> 1 ,
  
              ]);
  
          }else{
              return response()->json([
                  'message'=>'you arenot authenticated',
                  'status'=> 0 ,
  
              ]);
          }
  
  }


  public function addMyPhoto(Request $request){
    if(auth()->check()){
      //validate image
      $this->$request->validate([
        'image'=>'mimes:png,jpg,jpeg'
      ]);
      
      $file = $request->file('image');
      $name = time();
      $extension = $file->extension();
      $fileName = $name.'.'.$extension;
      $file->move('ImagesUsers',$fileName);
      
      
      // create image for this user
      $user= User::create([
        'image'=>$fileName,
      ]);
    }else{
      return response()->json([
          'message'=>'you arenot authenticated',
          'status'=> 0 ,

      ]);
  }
  
  }
    public function deleteMyPhoto(){
      if(auth()->check()){

        $user_id= User::where('id',auth()->user()->id)->first();
        // check this user 
        if($user_id) {
        $user_id->image = null;
        $user_id->save();
      }

      }else{
        return response()->json([
            'message'=>'you arenot authenticated',
            'status'=> 0 ,

        ]);
    }
    
  }

  
}
