@extends('layouts.single')

@section('title')
  Recipes
@endsection

@section('header')

      
               

    <!-- Header -->
    <header class="header text-center text-white" style="background-image: linear-gradient(-225deg, #5D9FFF 0%, #B8DCFF 48%, #6BBBFF 100%);">
      <div class="container">

        <div class="row">
          <div class="col-md-8 mx-auto">

            <h1>Latest Blog Posts</h1>
            <p class="lead-2 opacity-90 mt-6">Read and get updated on how we progress</p>

          </div>
        </div>

      </div>
    </header><!-- /.header -->
@endsection

@section('content')
   <main class="main-content">
      <div class="section bg-gray">
        <div class="container">
          <div class="row" >
   
            <div class="col-md-12 col-xl-12">
              <div class="row gap-y">
              <recipes-component></recipes-component> 
              
           



       
            
          </div>
        </div>
        
      </div>
    </main>

@endsection



