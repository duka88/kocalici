@extends('layouts.single')

@section('title')
  Recipes
@endsection



@section('content')
   <main class="main-content">
   <div class="container-fluid">


     <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
              <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
              <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
              <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
            </ol>
            <div class="carousel-inner">
              <div class="carousel-item active ">
                <div class="row align-items-center">
                  <div class="col-6 ">
                    <h2>Lorem Ipsum is simply </h2>
                    <p>
                    Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem 
                  </p></div>
                  <div class="col-6">
                    <img class="d-block w-100" src="{{asset('img/MD/cake1.jpg')}}"   height="600px" alt="Second slide">
                  </div>
                </div>
              </div>
              <div class="carousel-item  ">

                   <div class="row align-items-center">
                  <div class="col-6 ">
                    <h2>Lorem Ipsum is simply </h2>
                    <p class="">
                    Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem 
                  </p></div>
                  <div class="col-6">
                    <img class="d-block w-100" src="{{asset('img/MD/cake2.jpg')}}"   height="600px" alt="Second slide">
                  </div>
                </div>
                
              </div>
              <div class="carousel-item">
                <div class="row align-items-center">
                  <div class="col-6 ">
                    <h2>Lorem Ipsum is simply </h2>
                    <p>
                    Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem 
                  </p></div>
                  <div class="col-6">
                    <img class="d-block w-100" src="{{asset('img/MD/cake3.jpg')}}"   height="600px" alt="Second slide">
                  </div>
                </div>
              </div>
            </div>
            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
              <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
              <span class="carousel-control-next-icon" aria-hidden="true"></span>
              <span class="sr-only">Next</span>
            </a>


          </div>




   </div>  
        <div class="container-fluid">
          <div class="row" >

              <recipes-component ></recipes-component>  
       
       </div>  
      </div>
  {{session('status')}}

    </main>

@endsection



