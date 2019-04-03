@extends('layouts.app')

@section('content')
  <div class="card card-default">  
        <div class="card-header">
            {{isset($category) ? 'Edit Category' : 'Create Category'}}
        </div>
        <div class="card-body">
           @include('partials.error')
            <form 
                action="{{isset($category) ? route('category.update',$category->id)  : route('category.store')}}" 
                method="post">
                @csrf
              @if(isset($category))
                @method('PUT')
              @endif
              <div class="form-group">
                  <label for="name">name</label>
                  <input id="name" class="form-control" type="text" name="name"
                   value=" {{isset($category) ? $category->name : ''}}">                  
              </div>
              <div class="form-group">
                 <button class="btn btn-success">
                   {{isset($category) ? 'Update Category'  : 'Add Category'}}
                 </button>  
               </div>    
            </form>            
        </div>
    </div>
  </div>                           
@endsection