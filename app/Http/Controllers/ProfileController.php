<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\ProfileResources;
use App\User;

class ProfileController extends Controller
{
    public function index($id){
       
       $profile = User::findOrFail($id);

    return new ProfileResources($profile);

    }
}
