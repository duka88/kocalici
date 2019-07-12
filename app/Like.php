<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
   protected $fillable = [
        'recipe_id', 'like', 'user_id', 'admin_notification', 'user_notification'
    ];

       public function recipe(){

    	return $this->belongsTo(Recipe::class);
    }

       public function user(){

    	return $this->belongsTo(User::class);
    }
}
