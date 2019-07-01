<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Score;
use App\Like;

class RecipeRelationResources extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {

    $avg = Score::where('recipe_id', $this->id)->avg('score');
    $like = Like::where('recipe_id', $this->id)->where('user_id', $this->user->only('id'))->get();
         return [
           
          'title' => $this->title,
          'image' => $this->image,         
          'slug' => $this->slug,          
          'likes' =>  LikeResources::collection($like),
          'score' => $avg,
          'user' => $this->user->only('id')
         
        ];
    }
}
