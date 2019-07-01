<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserRelationResources extends JsonResource
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
           'likes' => LikeResources::collection($this->likes),
          'email' => $this->email,         
          'role' => $this->role,
         
          'created_at' => date("d-m-Y", strtotime($this->created_at))
      ];
    }
}
