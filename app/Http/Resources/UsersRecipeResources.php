<?php

namespace App\Http\Resources;

use App\Category;
use App\Score;
use Illuminate\Http\Resources\Json\JsonResource;

class UsersRecipeResources extends JsonResource
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
        $categories = Category::all();
         return [ 
          'id' => $this->id,        
          'title' => $this->title,                  
          'slug' => $this->slug,          
          'likes' => $this->likes->count(),
          'score' => $avg,
          'created_at' => date("d-m-Y", strtotime($this->created_at)),
          'category' => $this->category->name,
          'gallery' => $this->galleries,
          'time' => $this->time,
          'dificulty' => $this->dificulty,
          'servings' => $this->servings,
          'categories' => $categories,
          'image' => $this->image, 
           'content' => $this->content,  
          'description' => $this->description,
          'tags' => $this->tags
          
               
        ];
    }
}
