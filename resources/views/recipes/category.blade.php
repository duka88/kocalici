@extends('layouts.single')

@section('title')
  Category {{$category->name}}
@endsection

@section('header')
    <!-- Header -->
    <header class="header text-center text-white" style="background-image: linear-gradient(-225deg, #5D9FFF 0%, #B8DCFF 48%, #6BBBFF 100%);">
      <div class="container">

        <div class="row">
          <div class="col-md-8 mx-auto">

            <h1> {{$category->name}}</h1>

          </div>
        </div>

      </div>
    </header><!-- /.header -->
@endsection

@section('content')
   <main class="main-content">
      <div class="section bg-gray">
        <div class="container">
          <div class="row">


            <div class="col-md-8 col-xl-9">
              <div class="row gap-y">
              
             @forelse($recipes as $recipe)
                <div class="col-md-6">
                  <div class="card border hover-shadow-6 mb-6 d-block">
                    <a href="{{route('recipes.show',$recipe->id)}}"><img class="card-img-top" src="{{asset('/storage/' . $recipe->image)}}" alt="Card image cap"></a>
                    <div class="p-6 text-center">
                      <p><a class="small-5 text-lighter text-uppercase ls-2 fw-400" href="">{{$recipe->category->name}}</a></p>
                      <h5 class="mb-0"><a class="text-dark" href="{{route('recipes.show',$recipe->id)}}">{{$recipe->title}}</a></h5>
                    </div>
                  </div>
                </div>
              @empty
              
              <p class="text-center">
                No results for query <strong>{{request()->query('search')}}</strong>
              </p>  

              @endforelse

              </div>
                   {{$recipes->appends(['search'=> request()->query('search')])->links()}}

           
            </div>



             @include('partials.sidebar')

          </div>
        </div>
      </div>
    </main>

@endsection


