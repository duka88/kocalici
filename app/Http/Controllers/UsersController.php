<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Users\UserCreateRequest;
use App\Http\Requests\Users\UserUpdateRequest;
use App\Http\Resources\UserResources;

use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function index()
    {
       $users = User::paginate(1);

       return UserResources::collection($users);
    }

    public function create(UserCreateRequest $request){
         
         $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request['password']),
            'role' => $request->role

         ]);

         return new UserResources($user);
      
    }

    public function delete($id){
        
         $user = User::findOrFail($id);

         $user->delete();

         return new UserResources($user);
    }

    public function update(UserUpdateRequest $request, $id){
        
        $user = User::findOrFail($id);

       $user->role = $request->role;
       $user->update($request->all());

         return Response($user);
    }

    public function makeAdmin(User $user){

    	$user->role = 'admin';

    	$user->save();

    	session()->flash('success', 'User made amin sussessfully');

    	return redirect(route('users.index'));
    }

    public function edit(){

    	return view('users.edit')->with('user', auth()->user());
    }

    public function updateProfile(UpdateProfileRequest $request){

    	$user = auth()->user();

    	$user->update([
    	'name' => $request->name,
    	'about' => $request->about
    	]);

    	session()->flash('success', 'Profile updated');

        return redirect()->back();

    }
}
