@extends('layouts.single')

@section('title')
   {{$recipe->title}}
@endsection


@section('content')
    

   <div class="container mt-5" id="app">
    <div class="row">
      <div class="col-6 single_recipe_info_text px-5 d-flex justify-content-center flex-column"> 
          <div class="row  flex-column">
        <h1 class=" text-left">{{$recipe->title}}</h1>
        
        <span>{{$recipe->user->name}}</span>
        <p class="my-3">   
              {!!Helper::Rating($min, $max, $avg_score)!!}     
          ({{$recipe->scores()->count()}})</p>
        <p class="my-4"><span class="font-weight-bold text-dark">Author </span>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus quis quam ut diam fringilla malesuada. <a href="#comments" class="single_recipe_link" >Read More</a></p>
        </div>
            <div class="row my-4">
              <div class="col-4">
                <p class="count text-center mb-0">
                  {{$recipe->time}}
                </p>
                <p class="text-center">minutes</p>
               </div>
               <div class="col-4 center">
                <p class="count text-center mb-0">                 
                  {{$recipe->dificulty}}
                </p>
                <p class="text-center ">dificulty</p>
               </div>
               <div class="col-4">
                <p class="count text-center mb-0">
                  {{$recipe->servings}}
                </p>
                <p class="text-center">servings</p>
               </div>
              
            </div>
            <div class="row align-items-center mt-4">
               <div class="col-12"> 
                <a href="#recipe" class="large_button" >Read Recipe</a>
               </div>
            </div>
      </div>
      <div class="col-6">
        @foreach($recipe->tags as $tag)
   
       @endforeach
        <gallery-component  @Auth  :user_id={{auth()->user()->id}} @endauth :recipe_id={{$recipe->id}}></gallery-component>             
     
      </div>
    </div>
    <hr class="single_recipe-border" id="recipe">
    <div class="row">
      <ingredients-component :recipe_id={{$recipe->id}}></ingredients-component>
    </div>
    <div class="row" >
      <h2 class="my-4 col-12">Directions</h2>
      <p>{!!$recipe->content!!}</p>
    </div>
        <hr class="single_recipe-border">
        
      <div class="row" id="comments">
        <div class="col-12">
          <score-component @Auth  :user_id={{auth()->user()->id}}  @endauth :recipe_id={{$recipe->id}}></score-component>
        </div>
      </div>
   

  
    <div class="row">
      <div class="col-12">
        <h2 class="mb-5 text-center">Related Recipes</h2>
      </div>           
        

      @foreach($related as $recipe)    
        <div class="col-2">
          <div class="single_recipe_img_container" >
            <a href="{{route('recipes.show', $recipe->id)}}"><img class="single_recipe_img related" src="{{asset('/img/S/' . $recipe->image)}}" width="150px" height="150px">
          </div></a>
        </div>  
     @endforeach
        </div>

      
    </div>
   </div>

      </div>
    </div>    
   



    </main>
@endsection