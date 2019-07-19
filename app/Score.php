<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Score extends Model{

    protected $fillable = [
        'recipe_id', 'user_id', 'score', 'comment', 'perent_comment_id',
         'admin_notification', 'user_notification'
    ];

     public function recipe(){
        return $this->belongsTo(Recipe::class);
    }

     public function user(){
        return $this->belongsTo(User::class);
    }

     public function  replies(){
        return $this->hasMany(Score::class, 'perent_comment_id');
    }
}
