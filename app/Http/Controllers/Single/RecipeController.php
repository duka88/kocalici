<?php

namespace App\Http\Controllers\Single;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Recipe;
use App\Category;
use App\Tag;

class RecipeController extends Controller
{
    public function show(Recipe $recipe){

    	return view('recipes.show')->with('recipe',$recipe);
    }

    public function category(Category $category){

    	return view('recipes.category')->with('category', $category)->with('recipes', $category->recipes()->searched()->simplePaginate(2))->with('categories',Category::all())->with('tags',Tag::all());;
    }

    public function tag(Tag $tag){

    	return view('recipes.tag')->with('tag', $tag)
    	->with('recipes', $tag->recipes()->searched()->simplePaginate(2))->with('tags',Tag::all())->with('categories',Category::all());
    }
}
