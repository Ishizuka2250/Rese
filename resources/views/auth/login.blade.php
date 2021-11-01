@extends('layouts.default')

@section('css')
<link rel="stylesheet" href="{{ asset('css/common.css') }}">
@endsection

@section('content')
<div class="container">
  <div class="card">
    <div class="card-header">
      Login
    </div>
    <div class="card-body">
      <form method="POST" action="{{ route('login') }}">
        @csrf
        @error('email')
        <div class="form-group">
          <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
          </span>
        </div>
        @enderror
        <div class="form-group">
          <label for="email"><img src="images/baseline_email_black.png" class="inner-image" alt=""></label>
          <input id="email" type="email" class="form-input @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Email">
        </div>
        
        <div class="form-group">
          <label for="password"><img src="images/baseline_lock_black.png" class="inner-image" alt=""></label>
          <input id="password" type="password" class="form-input @error('password') is-invalid @enderror" name="password" required autocomplete="New-password" placeholder="Password">
        </div>

        <div class="form-group right">
          <button type="submit" class="form-button">ログイン</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
