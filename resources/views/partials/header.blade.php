<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">
  
    <script src='//google.com/recaptcha/api.js'></script>
    

    <title>@yield('title')</title>

  
   
    <link href="{{asset('css/app.css')}}" rel="stylesheet">

  
  </head>

  <body>
   <div id="app" :class="{'overlay-active': overlay}">

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg pt-0 navbar-light navbar-stick-dark" data-navbar="sticky"  >
      <div class="container">
        <div class="row justify-content-between align-items-center w-100">

            <div class="col-2">         
               <a class="navbar-brand d-flex align-items-center" href="{{route('welcome')}}">
                 <img src="{{asset('img/logo.jpg')}}" alt="Logo" class="logo-img img-circle elevation-3"
                 style="opacity: .8">
                 <span class="brand-text font-weight-light ml-1 logo-text">Cookie</span>
               </a>
            </div>

            <div class="col-10 d-flex  justify-content-end">
               <div class="col-4 d-flex align-items-center  justify-content-end">
                 <div class="row">
                   <div class="col-12 d-flex py-2  justify-content-between login-container">
                          <p class="login m-0 p-0">Contact Us</p>
                         
                          @if(Auth::check())
                           @if (Auth::user()->isAdmin())
                            <p class="m-0"><a href="{{route('home')}}" class="login m-0 p-0" style="text-decoration: none;">Home</a></p>
                           @else
                              <p class="m-0"><a href="{{route('my_profile')}}" class="login m-0 p-0" style="text-decoration: none;">Profile</a></p>
                           @endif
                             <a class="nav-link login p-0" href="{{ route('logout') }}"

                                          onclick="event.preventDefault();
                                           document.getElementById('logout-form').submit();">
                                       
                                          Logout
                                       </a>

                          <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                                    @csrf
                            </form>
                         @else
                           <login-component></login-component>
                           
                         @endif
                        
                   </div>


                    <div class="col-12 d-flex mt-2 px-0 justify-content-between">
                        <div class="addthis_inline_share_toolbox"></div>
                        <search-component></search-component> 
                   </div>
                 </div>   
             
              </div>  
              
            </div>



          </div> 

      </div>
    </nav>



 


    