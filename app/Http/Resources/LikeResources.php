<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Like;
use Auth;
class LikeResources extends JsonResource
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
          'like' => $this->id,
          'count' => Like::where('recipe_id', $this->recipe_id )->count(),         

        ];
    }
}
