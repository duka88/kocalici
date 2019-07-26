<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">


    <title>@yield('title')</title>

  
   
    <link href="{{asset('css/app.css')}}" rel="stylesheet">

  
  </head>

  <body>
   <div id="app">

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light navbar-stick-dark" data-navbar="sticky">
      <div class="container">

        <div class="navbar-left">
          <button class="navbar-toggler" type="button">&#9776;</button>
           <a class="navbar-brand" href="{{route('welcome')}}">
             <img src="{{asset('img/logo.jpg')}}" alt="Logo" class="brand-image img-circle elevation-3"
             style="opacity: .8">
             <span class="brand-text font-weight-light  logo-text">Cookie</span>
           </a>
        </div>

        <section class="navbar-mobile">
          <span class="navbar-divider d-mobile-none"></span>

          <ul class="nav nav-navbar">
          

          </ul>
        </section>
        <login-component></login-component>  
        <search-component></search-component>  

      </div>
    </nav><!-- /.navbar -->


   @yield('header')

  
    <!-- Main Content -->
     @yield('content')


    <!-- Footer -->
    <footer class="footer">
     
    </footer><!-- /.footer -->


    <!-- Scripts -->
   </div>
    @auth
  <script>
    window.user = @json(auth()->user())
  </script>
@endauth
    <script src="{{asset('js/app.js')}}"></script>


   
  </body>
</html>
