<?php

namespace App\Http\Resources;

use App\Tag;
use App\Category;
use App\Recipe;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\CategoryResources;
use App\Http\Resources\TagResources;
use App\Http\Resources\RecipeResources;
use Illuminate\Http\Resources\Json\JsonResource;

class StarterResources extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
         $categores = Category::orderBy('name')->get();
         $tags = Tag::orderBy('name')->get();
         $top_recipes = Recipe::withCount(['scores as average' => function ($q){
                            $q->select(DB::raw('coalesce(avg(score), 0)'));
                          }])->orderBy('average' , 'desc')->take(5)->get();
         $like_recipes = Recipe::withCount('likes')
                           ->orderBy('likes_count', 'desc')->take(5)->get(); 
         $latest_recipes = Recipe::latest()->take(15)->get();                   

         return [           
          'categories' =>  CategoryResources::collection($categores),
          'tags' =>  TagResources::collection($tags),
          'top_recipes' => RecipeResources::collection($top_recipes),
          'like_recipes' => RecipeResources::collection($like_recipes),
          'latest_recipes' => RecipeResources::collection($latest_recipes),        
        ];
    }
}
