<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tag;
use App\Recipe;

class FridgeController extends Controller
{
    public function index(Request $request){
    /*
    if(isset($request->submit)){
    	$recipe = Recipe::whereIn('tag_id', [$request->tag])->get();
    		 dd($recipe->id);
    	}     
   // $recipe = $tags->recipe->where('tag_id', [$request->tag[0]]);
     */
        $results = Tag::whereIn('id', $request->tag)->get();
       

    	return view('recipes.fridge')->with('tags', Tag::all())->with('results', $results);
    }
}
