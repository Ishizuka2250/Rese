@extends('layouts.default')

@section('title', 'Home')
@section('content')
<div class="container">
  <div id="app">
    <router-view></router-view>
  </div>
</div>
<script src="{{ mix('js/app.js')}}"></script>
@endsection