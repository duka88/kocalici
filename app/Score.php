<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Score extends Model{

    protected $fillable = [
        'recipe_id', 'user_id', 'score', 'comment'
    ];

     public function recipes(){
        return $this->belongsTo(Recipe::class);
    }

     public function users(){
        return $this->belongsTo(User::class);
    }
}
