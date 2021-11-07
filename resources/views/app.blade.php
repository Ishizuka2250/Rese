@extends('layouts.default')

@section('title', 'Home')
@section('content')
<div id="app">
  <router-view></router-view>
</div>
<script src="{{ mix('js/app.js')}}"></script>
@endsection