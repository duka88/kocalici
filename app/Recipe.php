<?php

namespace App;

use Intervention\Image\Facades\Image;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
class Recipe extends Model

{


	use SoftDeletes;
    
    protected $dates = [
      
      'published_at'
    ];

    protected $fillable = [
        'title', 'content', 'image',  'description', 'category_id', 'user_id', 'slug', 'time', 'servings', 'dificulty'
    ];
    
    public function getRouteKeyName()
    {
    return 'slug';
    }
    public function deleteImage(){
    	Storage::delete($this->image);
    }

    public function category(){

    	return $this->belongsTo(Category::class);
    }

    public function tags(){

        return $this->belongsToMany(Tag::class)->withPivot('amount');
    }

      public function galleries(){

        return $this->hasMany(Gallery::class);
    }

       public function likes(){

        return $this->hasMany(Like::class);
    }

    public function user(){

        return $this->belongsTo(User::class);
    }

    /*public function scopeSearched($query){

        $search = request()->query('search');

        if(!$search){
            return $query->published();
        }

        return $query->published()->where('title', 'LIKE', "%{$search}%");
    }*/

    public function scopePublished($query){

        return $query->where('published_at','<=', now());
    }

     public function scores(){
        return $this->hasMany(Score::class);
    }
   
    public static function search($search, $category, $order, $direction){
            if($category != 0){
          if($order == 'score'){
           $recipes = Recipe::where('title', 'LIKE', "%$search%")
                       ->where('category_id', $category)
                       ->withCount(['scores as average' => function ($q){
                        $q->select(DB::raw('coalesce(avg(score), 0)'));
                      }])->orderBy('average' ,$direction)->paginate(9); 
         }elseif($order == 'likes'){
             $recipes = Recipe::where('title', 'LIKE', "%$search%")
                       ->where('category_id', $category)
                       ->withCount('likes')
                       ->orderBy('likes_count', $direction)->paginate(9);  
          }else{
            $recipes = Recipe::where('title', 'LIKE', "%$search%")
                       ->where('category_id', $category)
                       ->orderBy($order, $direction)->paginate(9);
          }


       }else{
          
           if($order == 'score'){
               $recipes = Recipe::where('title', 'LIKE', "%$search%")
                           
                           ->withCount(['scores as average' => function ($q){
                            $q->select(DB::raw('coalesce(avg(score), 0)'));
                          }])->orderBy('average' ,$direction)->paginate(9); 
             }elseif($order == 'likes'){
                 $recipes = Recipe::where('title', 'LIKE', "%$search%")
                           
                           ->withCount('likes')
                           ->orderBy('likes_count', $direction)->paginate(9);  
              }else{
                $recipes = Recipe::where('title', 'LIKE', "%$search%")
                           
                           ->orderBy($order, $direction)->paginate(9);
              }

           
       }
       
   

              return $recipes;
    }

    public static function searchCategory($category, $order, $direction){
            if($category != 0){
          if($order == 'score'){
           $recipes = Recipe::where('category_id', $category)
                       ->withCount(['scores as average' => function ($q){
                        $q->select(DB::raw('coalesce(avg(score), 0)'));
                      }])->orderBy('average' ,$direction)->paginate(9); 
         }elseif($order == 'likes'){
             $recipes = Recipe::where('category_id', $category)
                       ->withCount('likes')
                       ->orderBy('likes_count', $direction)->paginate(9);  
          }else{
            $recipes = Recipe::where('category_id', $category)
                       ->orderBy($order, $direction)->paginate(9);
          }


       }else{
          
           if($order == 'score'){
               $recipes = Recipe::withCount(['scores as average' => function ($q){
                            $q->select(DB::raw('coalesce(avg(score), 0)'));
                          }])->orderBy('average' ,$direction)->paginate(9); 
             }elseif($order == 'likes'){
                 $recipes = Recipe::withCount('likes')
                           ->orderBy('likes_count', $direction)->paginate(9);  
              }else{
                $recipes = Recipe::orderBy($order, $direction)->paginate(9);
              }

           
       }
       
   

              return $recipes;
    }
}
