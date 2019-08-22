@include('partials.header') 

  
    <!-- Main Content -->
     @yield('content')


  
 @include('partials.footer') 
   


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
