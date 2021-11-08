@extends('layouts.default')

@section('title', 'Home')
@section('content')
<div id="app">
  <router-view :userinfo="{{ json_encode($userinfo) }}"></router-view>
</div>
<script src="{{ mix('js/app.js')}}"></script>
@endsection