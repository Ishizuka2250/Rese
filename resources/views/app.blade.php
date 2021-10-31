@extends('layouts.default')

@section('title', 'Home')
@section('content')
<div class="container">
  <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
    <a class="dropdown-item" href="{{ route('logout') }}"
      onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">
      {{ __('Logout') }}
    </a>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
      @csrf
    </form>
  </div>
  <div id="app">
    <router-view></router-view>
  </div>
</div>
<script src="{{ mix('js/app.js')}}"></script>
@endsection