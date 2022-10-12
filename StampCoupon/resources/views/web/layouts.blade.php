<!doctype html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token()}}">
  {{-- <link rel="stylesheet" href="{{asset('css/style.css')}}"> --}}
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
  <script src="https://cdn.tailwindcss.com"></script>
  
</head>
<body class="preloading">
  <div id="preload" class="preload-container text-center">
    <span class="glyphicon glyphicon-repeat preload-icon rotating"></span>
</div>
  <div class="content">
    @include('web.header')
  @yield('content')
</div>
  <script>
   $(window).load(function() {
    $('#preload').delay(1000).fadeOut('fast', function() {
      console.log('hiccc');
        $('body').removeClass('preloading');
    });
});
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

</body>
</html>