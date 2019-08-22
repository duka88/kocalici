<?php

namespace App\Http\Resources;
use App\Score;

use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResources extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
       
       $admin_count = Score::where('admin_notification', 1)->count();

        return [
          'id' => $this->id,
          'score' => $this->score,         
          'recipe' => $this->recipe->only('title', 'slug'),         
          'user' => new UserResources($this->user),
          'excerpt' => substr(strip_tags($this->comment),40),        
          'time' => date("d-m-Y", strtotime($this->created_at)),
          'admin_count' => $admin_count
        ];
    }
}
