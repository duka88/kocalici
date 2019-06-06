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
         $count = Score::where('recipe_id', $this->id)->count();
        return [
          'id' => $this->id,
          'title' => $this->title,
          'content' => $this->content,
          'image' => $this->image,          
          'description' => $this->description,
          'category_id' => $this->category_id,
          'user_id' => $this->user_id,
          'avg' => $score,
          'count' => $count
        ];
    }
}

