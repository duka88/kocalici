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
        <p class="my-4"><span class="font-weight-bold text-dark">Author </span>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus quis quam ut diam fringilla malesuada. <a class="single_recipe_link" >Read More</a></p>
        </div>
            <div class="row my-4">
              <div class="col-4">
                <p class="count text-center mb-0">
                  8
                </p>
                <p class="text-center">minutes</p>
               </div>
               <div class="col-4 center">
                <p class="count text-center mb-0">
                  6
                </p>
                <p class="text-center ">dificulty</p>
               </div>
               <div class="col-4">
                <p class="count text-center mb-0">
                  7
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
        {{$tag->pivot->amount}}
   
       @endforeach
        <gallery-component  @Auth  :user_id={{auth()->user()->id}} @endauth :recipe_id={{$recipe->id}}></gallery-component>             
     
      </div>
    </div>
    <hr class="single_recipe-border" id="recipe">
    <div class="row">
      <div class="col-6">
        <h2 class="mb-4">Ingredients</h2>
        <ul class="ingredients_list">
          <li >5 tablespoons <span class="list_bold">butter</span></li>
          <li>5 tablespoons <span class="list_bold">butter</span></li>
          <li>5 tablespoons <span class="list_bold">butter</span></li>
          <li>5 tablespoons <span class="list_bold">butter</span></li>
          <li>5 tablespoons <span class="list_bold">butter</span></li>
          <li>5 tablespoons <span class="list_bold">butter</span></li>
          <li>5 tablespoons <span class="list_bold">butter</span></li>
          <li>5 tablespoons <span class="list_bold">butter</span></li>
          
        </ul>
      </div>
    </div>
    <div class="row" >
      <h2 class="my-4">Directions</h2>
      <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis tristique diam arcu, sed fringilla nulla dignissim quis. Phasellus erat augue, tincidunt non mauris at, congue fermentum leo. Fusce sodales convallis lorem eu consequat. Maecenas non pretium justo. Proin sit amet cursus ipsum, sit amet laoreet eros. Sed malesuada mollis mattis. Nunc lacinia dolor at condimentum fringilla. Aenean a velit lorem. Morbi congue tempor tellus eget feugiat. Morbi non placerat velit. Cras sed nunc aliquet ipsum gravida dictum. Fusce at mollis tortor, quis eleifend lectus. Suspendisse laoreet, magna et mollis volutpat, urna lectus fermentum sapien, a mattis urna ligula sit amet lorem. Donec ut venenatis mauris.

    Etiam et felis in diam convallis varius ut nec nisl. Fusce dui tortor, bibendum interdum sollicitudin ut, vestibulum vitae lorem. Sed feugiat lectus et felis fermentum, vel placerat leo dictum. Nunc auctor, enim non iaculis maximus, lacus eros volutpat neque, eu sollicitudin augue metus ut neque. Donec imperdiet mattis quam mattis molestie. Donec finibus volutpat auctor. Donec mi erat, varius at sagittis ut, fringilla at arcu. Pellentesque rutrum massa a justo ultricies accumsan. Vestibulum venenatis urna vitae mollis efficitur. Pellentesque at neque ipsum. Proin vel porttitor diam.

    Etiam vulputate nisl vel metus lacinia ultricies. Aliquam tempus risus non erat porttitor luctus. Maecenas in purus et erat convallis interdum at id libero. Donec auctor orci eu suscipit sagittis. Fusce urna enim, placerat sed commodo ac, facilisis sit amet sem. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Maecenas molestie dolor quis porttitor lacinia. Nunc sed scelerisque ex. Curabitur vitae mauris ac felis cursus mattis. Aliquam rhoncus fermentum nunc sed gravida. Quisque nec faucibus eros.</p>
    </div>
        <hr class="single_recipe-border">
        
      <div class="row">
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















        <script>

/**
*   RECOMMENDED CONFIGURATION VARIABLES: EDIT AND UNCOMMENT THE SECTION BELOW TO INSERT DYNAMIC VALUES FROM YOUR PLATFORM OR CMS.
*  LEARN WHY DEFINING THESE VARIABLES IS IMPORTANT: https://disqus.com/admin/universalcode/#configuration-variables*/

     var disqus_config = function () {
      this.page.url = "{{config('app.url')}}/recipes/{{$recipe->id}}";  // Replace PAGE_URL with your page's canonical URL variable
      this.page.identifier = "{{$recipe->id}}"; // Replace PAGE_IDENTIFIER with your page's unique identifier variable
       };

      (function() { // DON'T EDIT BELOW THIS LINE
    var d = document, s = d.createElement('script');
    s.src = 'https://recipe-9.disqus.com/embed.js';
     s.setAttribute('data-timestamp', +new Date());
    (d.head || d.body).appendChild(s);
       })();
     </script>
      <noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>

      </div>
    </div>    
   



    </main>
@endsection