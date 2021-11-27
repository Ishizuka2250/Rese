<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>App</title>
    <link rel="stylesheet" href="{{ asset('css/reset.css') }}">
  </head>
  <body>
    <div id="app">
      <router-view :userinfo="{{ json_encode($userinfo) }}" :csrf="{{json_encode(csrf_token())}}"></router-view>
    </div>
    {{-- <script src="{{ asset('js/menu.js') }}"></script> --}}
    <script src="{{ mix('js/app.js')}}"></script>
  </body>
</html>