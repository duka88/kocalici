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


   
         return [
          'time' => $this->time,
          'dificulty' => $this->dificulty,
          'servings' => $this->servings, 
          'title' => $this->title,
          'image' => $this->image,         
          'slug' => $this->slug,          
          'likes' =>  LikeResources::collection($this->likes),
          'score' => $this->scores->avg('score'),
          'user' => $this->user->only('id')
         
        ];
    }
}
