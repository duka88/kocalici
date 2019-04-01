@extends('layouts.app')

@section('content')
   <div class="d-flex justify-content-end mb-2">
     <a href="{{route('recipe.create')}}" class="btn btn-success">Add Recipes</a>
   </div>

   <div class="card card-default">
     <div class="card-header">categories</div>
      <div class="cart-body">
       @if($recipes->count() > 0)   
        <table class="table">
         <thead>
           <th>Image</th>
           <th>Title</th>
           <th></th>
           <th></th>
         </thead> 
         <tbody>
           @foreach($recipes as $recipe)
           <tr>
            <td><img src="{{asset('/storage/'.$recipe->image)}}" width="60px" height="50"></td>
            <td>{{$recipe->title}}</td>
            @if(!$recipe->trashed())
             <td><a href="{{route('recipe.edit', $recipe->id)}}" class="btn btn-info btn-sm">Edit</a></td>
            @else 
             <td>
              <form action="{{route('restore-recipe', $recipe->id)}}" method="POST">
                @csrf
                @method('PUT')
                <button type="submit" class="btn btn-info btn-sm text-white">Restore</button>
            </form>
            </td>
            @endif
            <td>
              <form action="{{route('recipe.destroy', $recipe->id)}}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" href="" class="btn btn-danger btn-sm">
                 {{ $recipe->trashed() ? 'Delete' : 'Trash'}}
                 </button>
              </form>
            </td>
           </tr> 
            @endforeach
         </tbody>
         @else
         <h2 class="text-center my-3">No Recipes Yet</h2>
         @endif

    </div>    
  </div>
</div>
@endsection
