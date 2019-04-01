<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
class Recipe extends Model

{
	use SoftDeletes;
    protected $fillable = [
        'title', 'content', 'image', 'published_at', 'description'
    ];

    public function deleteImage(){
    	Storage::delete($this->image);
    }
}
