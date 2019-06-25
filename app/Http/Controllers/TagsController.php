<?php

namespace App\Http\Controllers;

use App\Http\Requests\Tags\UpdateTagRequest;
use App\Http\Requests\Tags\CreateTagRequest;
use Illuminate\Http\Request;
use App\Tag;
use Session;
use App\Recipe;

class tagsController extends Controller
{
   
 

    public function search(){

        if($search = \Request::get('q')){
            $tags = Tag::where(function($query) use ($search){
              $query->where('name', 'LIKE', "%$search%");   
            })->get();
        }

         return Response($tags);
    }

  
}
