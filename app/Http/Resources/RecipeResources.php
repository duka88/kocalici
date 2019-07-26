<?php

namespace App\Http\Resources;

use App\Like;
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
          'time' => $this->time,
          'dificulty' => $this->dificulty,
          'servings' => $this->servings,
          'likes' => LikeResources::collection($this->likes),
          'image' => $this->image, 
           'created_at' => date("d-m-Y", strtotime($this->created_at)),      
          'description' => $this->description,
          'category' => $this->category->only('id', 'name'),
          'user_id' => $this->user_id,
          'avg' => $score,
          'count' => $this->scores->count(),
       
        ];
    }
}

