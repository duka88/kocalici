<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ScoreResources extends JsonResource
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
          'score' => $this->score,
          'recipe' => $this->recipe->only('title', 'slug'),         
          'user' => new UserResources($this->user),
          'comment' => $this->comment,          
          'time' => date("d-m-Y", strtotime($this->created_at)),
        
        ];
    }

  
}
