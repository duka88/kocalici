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

 
 <div class="container">
   <div class="row justify-content-center">
     <div class="col-8">
 
   
  <form action="{{route('fridge')}}" method="GET">
    @foreach($tags as $tag)

      <input type="checkbox" name="tag[]" value="{{$tag->id}}">{{$tag->name}}<br>
      
   @endforeach
     <button type="submit" name="submit" value="submit" class="btn btn-success">Search</button>
    </form>
  </div>
   @if(isset($recipes))
      @foreach($recipes as $test)
       {{$test->title}}
      
       @endforeach
   @endif    
 </div>
</div>
@endsection