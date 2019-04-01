@extends('layouts.app')

@section('content')
   <div class="d-flex justify-content-end mb-2">
     <a href="{{route('recipe.create')}}" class="btn btn-success">Add Recipes</a>
   </div>

   <div class="card card-default">
     <div class="card-header">categories</div>
      <div class="cart-body">
        <table class="table">
         <thead>
           <th>Name</th>
         </thead> 
    </div>    
  </div>
</div>
@endsection
