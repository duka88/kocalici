<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tag;
use App\Recipe;

class FridgeController extends Controller
{
    public function index(Request $request){
    
    if(isset($request->submit)){
    	
    		 dd($request);
    	}     
   // $recipe = $tags->recipe->where('tag_id', [$request->tag[0]]);
     
    
    	return view('recipes.fridge')->with('tags', Tag::all())->with('recipes', Recipe::all());
    }
}
