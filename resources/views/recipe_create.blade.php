@extends('layouts.single')

@section('content')

 <div id='app'>
dsfsdfs

   <create-recipe-component :user_id="{{auth()->user()->id}}"></create-recipe-component> 
   
///////////////////////////////////////////////////////////////////////
   <tag-component></tag-component>
</div>
@endsection
