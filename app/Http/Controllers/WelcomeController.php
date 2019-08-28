<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Tag;
use App\Recipe;

class WelcomeController extends Controller
{
    public function index(){
     
     $recipes = Recipe::latest()->take(3)->get();
       return view('welcome')
         ->with('newest', $recipes);
         
          
    }
  
   
}
