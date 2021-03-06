<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    @yield('css')

    

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">


    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                           
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>
                                     <a class="dropdown-item" href="{{ route('users.edit-profile') }}">
                                        My Profile
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">        
          @auth
         <div class="container">
              @if(session()->has('success'))
               <div class="alert alert-success">
                {{session()->get('success')}}
               </div>
               @elseif(session()->has('error'))
               <div class="alert alert-danger">
                {{session()->get('error')}}
               </div>
               @endif
           <div class="row">
              <div class="col-md-4">
               <ul class="list-group">
                  @if(auth()->user()->isAdmin())
                  <li class="list-group-item">
                    <a href="{{route('users.index')}}">Users</a>
                 </li>
                @endif
                 <li class="list-group-item">
                    <a href="{{route('recipe.index')}}">Recipe</a>
                 </li>
                 <li class="list-group-item">
                    <a href="{{route('trashed-recipe.index')}}">Trashed Recipe</a>
                 </li>              
                 <li class="list-group-item">
                    <a href="/category">Categoties</a>
                 </li>
                 <li class="list-group-item">
                    <a href="/tags">Tags</a>
                 </li>
               </ul>
              </div>
              <div class="col-md-8">
                 @yield('content')
              </div>
 
          @else
            @yield('content')

          @endauth
            </div>
           
          </div>
        </main>
    </div>
<!-- Scripts -->
<script src="{{ asset('js/app.js') }}" ></script>   
@yield('scripts')

    </body>
</html>
