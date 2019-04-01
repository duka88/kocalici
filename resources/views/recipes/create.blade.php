@extends('layouts.app')

@section('content')
  <div class="card card-default">  
        <div class="card-header">
           Recipes
        </div>
        <div class="card-body">
          @if($errors->any())
          <div class="alert alert-danger">
             <ul class="list-group">
               @foreach(@$errors->all() as $error)
                <li class="list-group-item text-danger">{{$error}}</li>
                @endforeach
              </ul>
             </div>  
             @endif
            <form 
                action="{{route('recipe.store')}}" 
                method="post" enctype="multipart/form-data">
                @csrf              
              <div class="form-group">
                  <label for="title">title</label>
                  <input id="title" class="form-control" type="text" name="title">                  
              </div>
              <div class="form-group">
                  <label for="description">Description</label>
                  <textarea id="description" class="form-control" type="text" cols="5" rows="5" name="description" > </textarea>                 
              </div>
               <div class="form-group">
                  <label for="content">Content</label>
                  <textarea id="content" class="form-control" type="text" cols="5" rows="5" name="content" > </textarea>                 
              </div>
               <div class="form-group">
                  <label for="image">Image</label>
                  <input id="image" class="form-control" type="file" name="image" >                  
              </div>
              <div class="form-group">
                 <button type="submit"  class="btn btn-success">
                   Create Recipe                  
                 </button>  
               </div>    
            </form>            
        </div>
    </div>
  </div>                           
@endsection