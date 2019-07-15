<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Like;
use Auth;
use App\User;
use App\Http\Resources\LikeResources;
use App\Http\Resources\MyLikeResources;

class LikeController extends Controller
{

	public function index($recipe){

		 
		$like = Like::where('recipe_id', $recipe)->count();

		return Response($like);

    } 

    public function create(Request $request){
      
      $like = Like::find( $request->like);    
     
      if(!empty($like)){

      	$like->delete();

      	
      }else{
             
         $like = Like::create([
            'user_id' => $request->user_id,
            'recipe_id' => $request->recipe_id,
            'like' => $request->value
         ]);

        
        }

      return Response($like);
    }
   

   public function single($recipe, $user){
   	 $like = Like::where('recipe_id', $recipe )->where('user_id',$user)->pluck('id');

   	  return Response($like);
   }

   public function user_likes($user){
      
     $like = Like::where('user_id',$user)->latest()->paginate(2);

      return MyLikeResources::collection($like);
   
   }
    
}
