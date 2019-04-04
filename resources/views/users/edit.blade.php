@extends('layouts.app')

@section('content')

        <div class="col-md-8">
            <div class="card">


                <div class="card-header">My Profile</div>

                <div class="card-body">
                      @include('partials.error')
                   <form action="{{route('users.update-profile')}}"  class="form-group" method="POST">
                     @csrf
                     @method('PUT')
                       <div class="form-group">
                         <label for="name">Name</label>
                         <input type="text" name="name" id="name" value="{{$user->name}}" class="form-control">
                      </div>
                      <div class="form-gropu">
                        <label for="about">About Me</label>
                        <textarea name="about" class="form-control" id="about" cols="5" rows="5">{{$user->about}}</textarea>
                     </div>
                     <button type="submit" class="btn btn-success my-3">Update Profile</button>
                   </form>
                </div>
            </div>
        </div>

@endsection
