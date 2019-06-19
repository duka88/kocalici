@extends('layouts.single')

@section('content')

 <div id='app'>


   <create-recipe-component :user_id="{{auth()->user()->id}}"></create-recipe-component> 
   

</div>
@endsection



