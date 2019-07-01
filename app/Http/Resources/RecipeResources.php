<?php

namespace App\Http\Resources;

use App\Score;
use Illuminate\Http\Resources\Json\JsonResource;

class RecipeResources extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
         $score = Score::where('recipe_id', $this->id)->avg('score');
       
        return [
          'id' => $this->id,
          'slug'=> $this->slug,
          'title' => $this->title,
          'likes' => LikeResources::collection($this->likes),
          'image' => $this->image,          
          'description' => $this->description,
          'category_id' => $this->category_id,
          'user_id' => $this->user_id,
          'avg' => $score,
          'count' => $this->scores->count(),
       
        ];
    }
}

