<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
	 protected $fillable = [
        'image', 'recipe_id'
    ];

     public function recipe(){

        return $this->belongsTo(Recipe::class);
    }
}
