@extends('layouts.app')

@section('content')
  <div class="card card-default">  
        <div class="card-header">
          {{isset($recipe) ? 'Edit Recipe' : 'Creat Recipe'}}
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
                action="{{isset($recipe) ?  route('recipe.update', $recipe->id) : route('recipe.store')}}" 
                method="post" enctype="multipart/form-data">
                @csrf
                @if(isset($recipe))
                 @method('PUT')
                @endif 

              <div class="form-group">
                  <label for="title">title</label>
                  <input id="title" class="form-control" type="text" name="title" value="{{isset($recipe) ? $recipe->title : ''}} ">                  
              </div>
              <div class="form-group">
                  <label for="description">Description</label>
                  <textarea id="description" class="form-control" type="text" cols="5" rows="5" name="description">{{isset($recipe) ? $recipe->description : ''}} </textarea>                 
              </div>
               <div class="form-group">
                  <label for="content">Content</label>
                  <input id="content" value="{{isset($recipe) ? $recipe->content : ''}}" type="hidden" name="content" >
                  <trix-editor input="content"></trix-editor>               
              </div>
               <div class="form-group">
                  <label for="published_at">Published at</label>
                  <input id="published_at" class="form-control" type="text" name="published_at" value="{{isset($recipe) ? $recipe->published_at : ''}}">                  
              </div>
               <div class="form-group">
                  <label for="category">Category</label>
                  <select name="category" id="category" class="form-control">
                    @foreach($categories as $category)
                    <option value="{{$category->id}}"
                     @if(isset($recipe)) 
                      @if($category->id == $recipe->category_id)
                      selected
                      @endif
                      @endif>
                      {{$category->name}}
                    </option>
                    @endforeach    
                  </select>
                                    
              </div>

              @if(isset($recipe))
                <div class="form-group">
                  <img src="{{asset('/storage/' . $recipe->image)}}" style="width: 100%">
                </div>
              @endif
               <div class="form-group">
                  <label for="image">Image</label>
                  <input id="image" class="form-control" type="file" name="image" >                  
              </div>
              <div class="form-group">
                 <button type="submit"  class="btn btn-success">
                   {{(isset($recipe)) ? 'Edit Recipe' : 'Create Recipe'}}
                                   
                 </button>  
               </div>    
            </form>            
        </div>
    </div>
  </div>                           
@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/trix/1.1.0/trix.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script> flatpickr('#published_at',{
  enableTime: true
})</script>

@endsection
@section('css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/trix/1.1.0/trix.css">
@endsection