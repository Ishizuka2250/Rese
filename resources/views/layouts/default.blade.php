<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield("title")</title>
  {{-- <link rel="stylesheet" href="{{ mix('css/app.css') }}"> --}}
  <link rel="stylesheet" href="{{ asset('css/reset.css') }}">
  <link rel="stylesheet" href="{{ asset('css/common.css') }}">
</head>
<body>
  <header class="header">
    <img src="{{ asset('images/header_img.png') }}" class="header-menu" alt="">
    <h1 class="header-title">Rese</h1>
  </header>
  @yield("content")
</body>
</html>