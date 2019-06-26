<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CommentRelationResources extends JsonResource
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
          'id' => $this->recipe_id,
          'recipe_id' => new RecipeRelationResources($this->recipe),              
          'comment' => $this->comment
        ];
    }
}
