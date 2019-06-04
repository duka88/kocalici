<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tag;
use App\Recipe;
use App\Http\Resources\FridgeResources;
use App\Http\Resources\RecipeResources;


class FridgeController extends Controller
{
    public function search(){
   
   
    	    
  
     
        $results = explode(',',\Request::query('tag'));
       $recipes = Recipe::whereHas('tags', function($q) use ( $results)
					{
				    $q->whereIn('tag_id', $results);
				}, '=',2)->get();
       
		        return RecipeResources::collection($recipes);

      


    
    
}
  public function index(Request $request){ 
          
      


      return view('recipes.fridge');
    
}

   public function apitags(){
       
       $tags = Tag::all();

       return FridgeResources::collection($tags);

   }
}