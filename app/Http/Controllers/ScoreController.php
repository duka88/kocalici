<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Score;
use Session;

class ScoreController extends Controller
{
   public function create(Request $request){
      
       $score = Score::create([
          'recipe_id' => $request->recipe_id,
          'user_id' => $request->user_id,
          'score' =>$request->score          
        ]);

       

        session()->flash('success', 'Score created');

        return redirect()->back();
   }
}
