<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\ProfileResources;
use App\Http\Requests\Users\UserUpdateRequest;
use Illuminate\Support\Facades\Hash;
use App\User;
use Auth;
use Helper;

class ProfileController extends Controller
{
    public function index($id){
       
       $profile = User::findOrFail($id);

    return new ProfileResources($profile);

    }

    public function update(UserUpdateRequest $request){
         
       $user = User::findOrFail(auth()->id());

       if(isset($request->imageUpload['name'])){  
             $imageName = Helper::uploadImageSize($request->imageUpload['image'], $request->imageUpload['name']);
            }else{
            	$imageName = $request->image;
            }

         $user->update([
            'name' => $request->name,
            'email' => $request->email,
           
             
         ]);

         $user->profile()->update([
           'image' => $imageName,  
           'about' => $request->about,
           'full_name' => $request->full_name,
         ]);

         return new ProfileResources($user);

    }
}
