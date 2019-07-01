<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProfileResources extends JsonResource
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
          'name' => $this->name,
          'email' => $this->email,         
          'role' => $this->role,
           'password' => $this->password,
          'created_at' => date("d-m-Y", strtotime($this->created_at)),
          'comments' => $this->scores->count(),
          'likes' => $this->likes->count(),
          'profile' => $this->profile->only('full_name','image','about'),
          'recipes' => $this->recipes->count(),
        ];
    }
}
