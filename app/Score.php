<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Score extends Model{

    protected $fillable = [
        'recipe_id', 'user_id', 'score', 'comment'
    ];

     public function recipe(){
        return $this->belongsTo(Recipe::class);
    }

     public function user(){
        return $this->belongsTo(User::class);
    }
}
