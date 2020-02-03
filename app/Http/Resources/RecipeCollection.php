<?php

namespace App\Http\Resources;

use App\Http\Resources\RecipeResources;
use App\Recipe;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Resources\Json\ResourceCollection;

class RecipeCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */

    public function toArray($request)
    {
        return ['data' => RecipeResources::collection($this->collection)];
    }


    public function with($request)
    {
        $top_recipes = Recipe::withCount(['scores as average' => function ($q){
                            $q->select(DB::raw('coalesce(avg(score), 0)'));
                          }])->orderBy('average' , 'desc')->take(5)->get();
         $like_recipes = Recipe::withCount('likes')
                           ->orderBy('likes_count', 'desc')->take(5)->get();
        return [
            'top_5' => [
                'top_recipes' => $top_recipes,
                'like_recipes' => $like_recipes,
            ],
        ];
    }
}
