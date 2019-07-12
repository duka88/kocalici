<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Score;
use Session;
use App\Http\Resources\ScoreResources;
use App\Http\Requests\Comment\ScoreCrateRequest;
use App\Http\Requests\Comment\UpdateCommentRequest;

class ScoreController extends Controller
{
   public function create(ScoreCrateRequest $request){

      $id = auth()->user()->id;

    $score = Score::where('recipe_id', $request->recipe_id)->where('user_id',$id)->count();

         
         if(empty($score)){  
           $score = Score::create([
              'recipe_id' => $request->recipe_id,
              'user_id' => $id,
              'score' =>$request->score,
              'comment' => $request->comment        
            ]);
            return Response($score);
         }elseif(!empty($request->comment_id)){
            $score = Score::create([
              'recipe_id' => $request->recipe_id,
              'user_id' => $id,
              'perent_comment_id' => $request->comment_id,
              'comment' => $request->comment        
            ]);
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

   public function users_comments($id){

       $score = Score::where('user_id', $id)->latest()->paginate(2);

      return ScoreResources::collection($score);
   }

   public function update_comment(UpdateCommentRequest $request, $id){
        
        $comment = Score::findOrFail($id);
        $comment->update($request->all());

        return Response($comment);
   }

   public function delete($id){

      $comment = Score::findOrFail($id);
      $comment->delete();

       return Response($comment);

   }

   public function new_comments(){

       $id = auth()->user()->id;
    
      if(auth()->user()->role == 'admin'){

         $comments = Score::where('admin_notification' , '0')->paginate(5);

      }else{

        $comments = Score::where('user_id', $id)->where('user_notification' , '0')->paginate(5);
       }


       return ScoreResources::collection($comments);
   }
}
