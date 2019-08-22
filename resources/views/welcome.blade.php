@extends('layouts.single')

@section('title')
  Recipes
@endsection

@section('header')

           @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                       

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Register</a>
                        @endif
                    @endauth
                </div>
            @endif
               
          
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                               
    <!-- Header -->
    <header class="header text-center text-white my-5" >
      <div class="container-fluid">

        <div class="row">
          <div class="col-6 background-1">

            <h1 class="text-dark text-left">Cookie is your smart cooking sidekick</h1>
            <p class="text-dark mt-5 text-left">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley </p>
            <login-component></login-component>  

          </div>
          <div class="col-6 background-2">
            
          </div>
        </div>

      </div>
    </header><!-- /.header -->
@endsection

@section('content')
   <main class="main-content">
     
        <div class="container-fluid">
          <div class="row" >

              <recipes-component ></recipes-component>  
       
       </div>  
      </div>
  {{session('status')}}

    </main>

@endsection



