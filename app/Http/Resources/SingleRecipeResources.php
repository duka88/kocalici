<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Category;

class SingleRecipeResources extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {

      $categores = Category::all()->pluck('id', 'name'); 

         return [ 
          'id' => $this->id, 
          'content' => $this->content,
          'description' => $this->description,       
          'title' => $this->title, 
          'time' => $this->time,
          'dificulty' => $this->dificulty,
          'servings' => $this->servings,                 
          'slug' => $this->slug, 
          'image' => $this->image,
          'gallery' => $this->galleries,          
          'category' => $this->category->only('id', 'name'),
          'categories' =>  $categores        
        ];
    }
}
