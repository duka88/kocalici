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
          <div class="row" id="app">
   
            <div class="col-md-8 col-xl-8">
              <div class="row gap-y">
              <router-link to="/cookie">Cookies</router-link>
               <router-link to="/cake">Cake</router-link>
        
                <router-view></router-view>
           



       
            
          </div>
        </div>
        <div class="col-md-4 col-xl-4 w-100">
           @include('partials.sidebar')
        </div>   
      </div>
    </main>

@endsection



