<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Score;

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
          'replies' => ScoreResources::collection($this->replies),
          'admin_notification' => $this->admin_notification,
          'user_notification' => $this->user_notification,
          'score' => $this->score,
          'recipe' => $this->recipe->only('title', 'slug', 'id'),      
          'user' => new UserResources($this->user),
          'comment' => $this->comment, 
          'time' => date("d-m-Y", strtotime($this->created_at)),
        ];
    }

}
