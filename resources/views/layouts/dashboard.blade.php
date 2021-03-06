<!DOCTYPE html >
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminLTE 3 | Dashboard</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <link rel="stylesheet" href="{{asset('css/app.css')}}">
 
</head>
<body class="hold-transition sidebar-mini layout-fixed" >
<div  :class="{'overlay-active': overlay}" class="wrapper" id="app">

  <!-- Navbar -->
  <nav  :class="{'z-index': overlay}" class="main-header navbar navbar-expand avbar-white navbar-light border-bottom">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="" class="nav-link">Home</a>
      </li>
    
    </ul>

    <!-- SEARCH FORM -->
    
        <search-component ></search-component>
    <!-- Right navbar links -->
   
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/" class="brand-link">
      <img src="{{asset('img/logo.jpg')}}" alt="Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light logo-text">Cookie</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
   

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        </router-link>  
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
            
          <li class="nav-header">RECIPES</li>

          <li class="nav-item ">
            <router-link to="/add-recipe" class="nav-link">
              <i class="fas fa-plus"></i>
              <p>
                ADD RECIPE                
              </p>
            </router-link>
          </li>
          <li class="nav-item">
           <router-link to="/all-recipe" class="nav-link">
              <i class="fas fa-cookie"></i>
              <p>
                ALL RECIPE                
              </p>
            </router-link>
            <router-link to="/trash" class="nav-link">
               <i class="fa fa-trash"></i>
              <p>
                TRASHED RECIPE                
              </p>
            </router-link>
          </li>


          <li class="nav-header">CATEGORIES</li>

           <router-link to="/categories" class="nav-link">
            
               <i class="fas fa-list-ul"></i>
              <p>
                ALL CATEGORIES              
              </p>
           
          </router-link>
          

          <li class="nav-header">COMMENTS</li>

          <li class="nav-item">
            <router-link to="/get-comments" class="nav-link">
              <i class="fas fa-comments"></i>
              <p>
                COMMENTS               
              </p>           
          </li>
         

          <li class="nav-header">USERS</li>

          <li class="nav-item">
            <router-link  to="/profile" class="nav-link">
              <i class="fas fa-user"></i>
              <p>
                PROFILE               
              </p>
            </router-link>
          </li>
          <li class="nav-item">
            <router-link to="/users" class="nav-link">
              <i class="fas fa-users"></i>
              <p>
                ALL USERS            
              </p>
            </router-link>
          </li>
   
          <li class="nav-header">PAGES
          </li>          
          
          <li class="nav-item has-treeview">
            <a href="{{route('welcome')}}" class="nav-link">
              <i class="nav-icon fas fa-book"></i>
              <p>
                Welcome
                
              </p>
            </a>            
          </li>
          <li class="nav-item has-treeview">
            <a href="{{route('fridge')}}" class="nav-link">
              <i class="nav-icon fas fa-book"></i>
              <p>
                Fridge
                
              </p>
            </a>            
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('logout') }}"

                              onclick="event.preventDefault();
                               document.getElementById('logout-form').submit();">
               <i class="nav-icon fa fa-power-off text-danger"></i>                
                               {{ __('Logout') }}
                           </a>

              <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                </form>
          </li>

        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

   <router-view></router-view>

    <!-- /.content-header -->

    <!-- Main content -->
   <div class="d-flex justify-content-end"></div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->



</div>
@auth
  <script>
    window.user = @json(auth()->user())
  </script>
@endauth
<!-- ./wrapper -->

<!-- jQuery -->
<script src="{{asset('js/app.js')}}">  </script>
</body>
</html>
