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
          'score' => $this->score,
          'recipe_id' => $this->recipe_id,
          'user_id' => $this->user_id,
          'user' => $this->user->name,
          'comment' => $this->comment
        ];
    }
}
