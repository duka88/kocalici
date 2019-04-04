@extends('layouts.app')

@section('content')
   <div class="card card-default">
     <div class="card-header">Users</div>
      <div class="cart-body">
       @if($users->count() > 0)   
        <table class="table">
         <thead>
           <th>Image</th>
           <th>Name</th>
           <th>Email</th>
           <th></th>
           <th></th>
         </thead> 
         <tbody>
           @foreach($users as $user)
           <tr>
            <td><img src="{{ Gravatar::src($user->email)}}" width="60px" height="50"></td>
            <td>{{$user->name}}</td>
            <td><a href="">
              {{$user->email}}
            </a></td>
            @endforeach
           @if(!$user->isAdmin()) 
            <td>
              <form action="{{route('users.make-admin', $user->id)}}" method="POST">
                @csrf
                <button type="submit" class="btn  btn-success btn-sm">Make Amin</button>
              </form>
            </td>
           @endif 
           </tr> 
           
         </tbody>
         @else
         <h2 class="text-center my-3">No Users Yet</h2>
         @endif

    </div>    
  </div>
</div>
@endsection
