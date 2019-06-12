<?php

namespace App\Http\Controllers\Single;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Recipe;
use App\Category;
use App\Tag;
use App\User;
use App\Score;

class RecipeController extends Controller
{
    public function show(Recipe $recipe){

    $avg_score = Score::where('recipe_id', $recipe->id)->avg('score');
    
     
     if(auth()->user()){
        $score_chack = Score::where([['user_id', auth()->user()->id],['recipe_id', $recipe->id]])->get();

        if(count($score_chack) !== 0){
           $score = false;
        }else{
            $score = true;
        }
     
    	return view('recipes.show')->with('recipe',$recipe)->with('user', auth()->user())->with('score', $score)->with('avg_score', $avg_score);
    }else{

        $score = Score::where('recipe_id', $recipe->id)->avg('score');

        return view('recipes.show')->with('recipe',$recipe)->with('avg_score', $avg_score);
    }
 }

    public function category(Category $category){

    	return view('recipes.category')->with('category', $category)->with('recipes', $category->recipes()->searched()->simplePaginate(2))->with('categories',Category::all())->with('tags',Tag::all());;
    }

    public function tag(Tag $tag){

    	return view('recipes.tag')->with('tag', $tag)
    	->with('recipes', $tag->recipes()->searched()->simplePaginate(2))->with('tags',Tag::all())->with('categories',Category::all());
    }

  
}
