<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Score;

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
         return [
           
          'title' => $this->title,
          'image' => $this->image,         
          'slug' => $this->slug,          
          'likes' => new LikeResources($this),
          'score' => $avg
         
        ];
    }
}
