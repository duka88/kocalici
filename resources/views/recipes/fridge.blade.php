@extends('layouts.single')

@section('title')
 Fridge
@endsection

@section('header')
    <!-- Header -->
    <header class="header text-center text-white" style="background-image: linear-gradient(-225deg, #5D9FFF 0%, #B8DCFF 48%, #6BBBFF 100%);">
      <div class="container">

        <div class="row">
          <div class="col-md-8 mx-auto">

            <h1> Fridge</h1>

          </div>
        </div>

      </div>
    </header><!-- /.header -->
@endsection

@section('content')

 
 <div class="container" id="app">
   <div class="row justify-content-center">
     <div class="col-8">
      <fridge-component></fridge-component>

 </div>
</div>
</div>
@endsection