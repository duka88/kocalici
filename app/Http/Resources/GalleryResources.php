<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Gallery;
class GalleryResources extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
    
        $gallery = Gallery::where('recipe_id', $this->id)->pluck('image');
         return [          
          'image' => $this->image,
          'gallery' => $gallery

        ];
    }
}
