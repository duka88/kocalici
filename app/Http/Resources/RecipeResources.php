<?php

namespace App\Http\Resources;

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
        return [
          'id' => $this->id,
          'title' => $this->title,
          'content' => $this->content,
          'image' => $this->image,
          'published_at' => $this->published_at,
          'description' => $this->description,
          'category_id' => $this->category_id,
          'user_id' => $this->user_id
        ];
    }
}

