@extends('layouts.single')

@section('title')
   {{$recipe->title}}
@endsection

@section('header')
     <!-- Header -->
    <header class="header text-white h-fullscreen pb-80" style="background-image: url({{asset('/storage/'.$recipe->image)}});" data-overlay="9">
      <div class="container text-center">

        <div class="row h-100">
          <div class="col-lg-8 mx-auto align-self-center">

            <p class="opacity-70 text-uppercase small ls-1">{{$recipe->category->name}}</p>
            <h1 class="display-4 mt-7 mb-8">{{$recipe->title}}</h1>
            <p><span class="opacity-70 mr-1">By</span> <a class="text-white" href="#">{{$recipe->user->name}}</a></p>
            <p><img class="avatar avatar-sm" src="{{Gravatar::src(asset($recipe->user->email))}}" alt="..."></p>

          </div>

          <div class="col-12 align-self-end text-center">
            <a class="scroll-down-1 scroll-down-white" href="#section-content"><span></span></a>
          </div>

        </div>

      </div>
    </header><!-- /.header -->
@endsection

@section('content')
    <!-- Main Content -->
    <main class="main-content">


     
      <div class="section" id="section-content">
        <div class="container">

           {!!$recipe->content!!}
             
                <!-- Go to www.addthis.com/dashboard to customize your tools -->
                <div class="addthis_inline_share_toolbox"></div>
            


          

              <div class="gap-xy-2 mt-6">
             @foreach($recipe->tags as $tag)

                <a class="badge badge-pill badge-secondary" href="{{route('recipe.tag', $tag->id)}}">{{$tag->name}}</a>
               @endforeach
              </div>

            </div>
          </div>
          <!--------Vue Score ------>
         <div id="app">
           <score-component :user_id="{{auth()->user()->id}}" :post_id="{{$recipe->id}}"></score-component>
         </div>

        </div>
      </div>
      @if($score->value('user_id') == $user->id)
          {{$score->avg('score')}}
       @else

          <div class="container">
              @if(session()->has('success'))
               <div class="alert alert-success">
                {{session()->get('success')}}
               </div>
               @elseif(session()->has('error'))
               <div class="alert alert-danger">
                {{session()->get('error')}}
               </div>
               @endif
             </div>
    
      
             <div class="container mb-5">
              <div class="row justify-content-center">
              <form action="{{route('score.create')}}" method="POST" class="form-control">
                @csrf 
                       
                  <input type="range" name ="score" min="1" max="10" value="5" class="form-control" id="score">
                  <input type="hidden" name ="recipe_id" value="{{$recipe->id}}" id="recipe_id">
                  <input type="hidden" name ="user_id" value="{{$user->id}}"  id="user_id">
  
                                            
                 <button class="btn btn-success" type="submit" name="submit" value="submit" />Rate </button>
            
              </form>
            </div>
          </div>
    @endif
     <div class="row mt-5 pt-5">
      <div class="col-lg-8 mx-auto">
       <div id="disqus_thread"></div>
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