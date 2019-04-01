<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    protected $fillable = [
        'title', 'content', 'image', 'published_at', 'description'
    ];
}
