<?php

namespace App;

use Intervention\Image\Facades\Image;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
class Recipe extends Model

{


	use SoftDeletes;
    
    protected $dates = [
      
      'published_at'
    ];

    protected $fillable = [
        'title', 'content', 'image', 'published_at', 'description', 'category_id', 'user_id'
    ];

    public function deleteImage(){
    	Storage::delete($this->image);
    }

    public function category(){

    	return $this->belongsTo(Category::class);
    }

    public function tags(){

        return $this->belongsToMany(Tag::class);
    }

      public function galleries(){

        return $this->hasMany(Gallery::class);
    }

    public function user(){

        return $this->belongsTo(User::class);
    }

    public function scopeSearched($query){

        $search = request()->query('search');

        if(!$search){
            return $query->published();
        }

        return $query->published()->where('title', 'LIKE', "%{$search}%");
    }

    public function scopePublished($query){

        return $query->where('published_at','<=', now());
    }

     public function scores(){
        return $this->hasMany(Score::class);
    }

    /*public function uploadImageSize($uploadedImage){

        $imagePathXS = public_path('img/XS/');
           $imagePathMD = public_path('img/MD/');
          
           Image::configure(array('driver'=>'gd'));
           $imageName = $uploadedImage->getClientOriginalName();
           $savePathXS = $imagePathXS . $imageName;
           $image = Image::make($uploadedImage)
                    ->fit(60, 50)->save($savePathXS);

          

           $savePathMD = $imagePathMD . $imageName;
           $image = Image::make($uploadedImage)
                    ->fit(480, 300)->save($savePathMD);

         return $imageName;           
    }*/
}
