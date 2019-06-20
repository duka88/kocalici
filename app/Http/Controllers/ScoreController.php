<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Score;
use Session;
use App\Http\Resources\ScoreResources;
use App\Http\Requests\ScoreCrateRequest;

class ScoreController extends Controller
{
   public function create(ScoreCrateRequest $request){

    $score = Score::where('recipe_id', $request->recipe_id)->where('user_id',$request->user_id)->count();

     if(empty($score)){  
       $score = Score::create([
          'recipe_id' => $request->recipe_id,
          'user_id' => $request->user_id,
          'score' =>$request->score,
          'comment' => $request->comment        
        ]);
        return Response($score);
     }else{
        return Response('Already commented');
     }
     
   }

   public function show($recipe, $user){
       
      $score=[];
        if(isset($user)){
        	$user = Score::where('user_id', $user)->where('recipe_id', $recipe)->count();
           if(empty($user)){
             array_push($score, true);
           }else{
            array_push($score, false);
           }

         $avg = Score::where('recipe_id', $recipe)->avg('score'); 

         array_push($score, $avg); 
      
         return Response($score);

        }
   }

   public function load($recipe){

      $score = Score::where('recipe_id', $recipe)->latest()->get();

      return ScoreResources::collection($score);
   }
}
