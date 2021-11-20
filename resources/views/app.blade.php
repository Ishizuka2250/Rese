@extends('layouts.default')

@section('title', 'Home')

@section('side-menu')
  <a href="#">MyPage</a>
  <a href="{{ route('logout') }}" style="text-decoration: none" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
    Logout
  </a>
  <form id="logout-form" action="{{ route('logout') }}" method="POST">
    @csrf
  </form>
@endsection

@section('content')
<div id="app">
  <router-view :userinfo="{{ json_encode($userinfo) }}"></router-view>
</div>
<script src="{{ mix('js/app.js')}}"></script>
@endsection