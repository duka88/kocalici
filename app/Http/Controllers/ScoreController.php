<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Score;
use Session;
use App\Http\Resources\ScoreResources;
use App\Http\Requests\Comment\ScoreCrateRequest;
use App\Http\Requests\Comment\UpdateCommentRequest;
use App\Http\Requests\Comment\ReplyRequest;
use App\Http\Resources\NotificationResources;

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
            return new ScoreResources($score);
         }else{
            return Response('Already commented');
         }
     
   }
   
  public function reply(ReplyRequest $request){
    
     $id = auth()->user()->id;
         if(auth()->user()->role){
            $admin_notification = '1';
         }else{
            $admin_notification = '0';
         }

       
        $score = Score::create([
              'recipe_id' => $request->recipe_id,
              'user_id' => $id,
              'admin_notification' => $admin_notification,
              'perent_comment_id' => $request->perent_comment_id,
              'comment' => $request->comment        
            ]);

        return Response('Replayed successfily');
  }

   public function show($recipe){
      $user = auth()->user()->id;
       
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

      $score = Score::where('recipe_id', $recipe)->where('perent_comment_id', null )->latest()->paginate(1); 
      
      return ScoreResources::collection($score);

      
   }

   public function users_comments($id){

       $score = Score::where('user_id', $id)->latest()->paginate(10);

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

   public function approved(Request $request){
          
        $comment = Score::findOrFail($request->id);

         $comment->update(['admin_notification' => '1']);

         return Response($comment);


   }

   public function allComments(){

         if(auth()->user()->role == 'admin'){

            $comments = Score::orderBy('admin_notification' , 'asc')->latest()->paginate(10);
         }else{
              
            $comments = Score::orderBy('user_notification' , 'asc')->latest()->paginate(10);

         }
         
         return ScoreResources::collection($comments);

   }


   public function notifications(){

       if(auth()->user()->role == 'admin'){

            $comments = Score::where('admin_notification' , 1)->latest()->paginate(5);
         }else{
              
            $comments = Score::where('user_notification' , 1)->latest()->paginate(5);

         }
         
         return NotificationResources::collection($comments);
   }
}
