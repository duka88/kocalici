<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tag;
use App\Recipe;

class FridgeController extends Controller
{
    public function index(Request $request){
   
    if(isset($request->submit)){
    	    
  
     
        $results = $request->tag;
       $recipeId = Recipe::whereHas('tags', function($q) use ( $results)
					{
				    $q->whereIn('tag_id', $results);
				}, '=',2)->get();
       
		return view('recipes.fridge')->with('tags', Tag::all())->with('recipes', $recipeId);
      
}

    	return view('recipes.fridge')->with('tags', Tag::all());
    
}
}