<footer class="footer mt-4">
    <footer-component></footer-component>

  </footer>
 </div>
   @include('cookieConsent::index')
  <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5c8f94f16cc4ba51"></script>
</main>


   </div>
    @auth
  <script>
    window.user = @json(auth()->user())
  </script>
@endauth
    <script src="{{asset('js/app.js')}}"></script>


   
  </body>
</html>
