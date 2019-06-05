<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Score;
use Session;
use App\Http\Resources\ScoreResources;

class ScoreController extends Controller
{
   public function create(Request $request){
      
       $score = Score::create([
          'recipe_id' => $request->input('recipe_id'),
          'user_id' => $request->input('user_id'),
          'score' =>$request->input('score')        
        ]);
     
   }

   public function show($recipe){
       

        if(isset($recipe)){
        	$score = Score::where('recipe_id', $recipe)->avg('score');

         return Response($score);

        }
   }
}
