@extends('layouts.single')

@section('title')
  Recipes
@endsection



@section('content')
   <main class="main-content">
<div class="container-fluid  mt-5 ">

<div id="carouselExampleIndicators" class="carousel slide py-5 " data-ride="carousel">

  <ol class="carousel-indicators">
   @foreach($newest as $key=>$recipe)

    <li data-target="#carouselExampleIndicators" data-slide-to="{{$key}}" 
        style="background: url('{{asset("img/XS/$recipe->image")}}')" class="@if($key == 0) {{'active'}} @endif"></li>
  
    @endforeach
   

  </ol>

  <div class=" carousel-inner py-5">

   @foreach($newest as $key=>$recipe)
   
    <div class="carousel-item @if($key == 0) {{'active'}} @endif">

      <div class="row col-12 col-md-12 col-lg-10 mx-auto align-items-center flex-wrap">

        <div class="col-12 col-md-12 col-lg-4 text-center px-2 slide-text-height">

          <h1 class="lh-1">{{$recipe->title}}</h1>
              

          <p class="mb-5 m-4">{{$recipe->description}}</p>

          <a  href="{{route('recipes.show', $recipe->slug)}}" class="large_button carusel-button">Procitaj Recept</a>

        </div>

        <div class="col-12 col-md-12 col-lg-8">

          <img src='{{asset("img/MD/$recipe->image")}}' alt="" class="featured-img" width="920px" height="600px">

        </div>

      </div>

    </div>
 @endforeach
    <!-- slide 1 -->

  

   
          <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">

          <span class="carousel-control-prev-icon" aria-hidden="true"></span>

           <i class="fas fa-chevron-left"></i>

        </a>

        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">

          <span class="carousel-control-next-icon" aria-hidden="true"></span>

          
           <i class="fas fa-chevron-right"></i>
        </a>

          <!-- -->

        </div>

      </div>

        

  </div>
        <div  class="container-fluid">
          <div class="row align-items-center" >
            <div class="col-9">
              <recipes-component ></recipes-component>  
            </div>
            <div class="col-3">
               @include('partials.sidebar') 
            </div>
       </div>  
      </div>


    </main>

@endsection



