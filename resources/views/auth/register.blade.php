@extends('layouts.default')

@section('content')
<div class="container">
  <div class="card">
    <div class="card-header">
      Registration
    </div>
    <div class="card-body">
      <form method="POST" action="{{ route('register') }}">
        @csrf
        <div class="form-group">
          <label for="name"><img src="images/baseline_person_black.png" class="inner-image" alt=""></label>
          <input id="name" type="text" class="form-input @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="Username">
        </div>
        @error('name')
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
        @error('email')
        <div class="form-group">
          <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
          </span>
        </div>
        @enderror
        
        <div class="form-group">
          <label for="password"><img src="images/baseline_lock_black.png" class="inner-image" alt=""></label>
          <input id="password" type="password" class="form-input @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="Password">
        </div>

        <div class="form-group">
          <label for="password-confirm"><img src="images/baseline_lock_black.png" class="inner-image" alt=""></label>
          <input id="password-confirm" type="password" class="form-input" name="password_confirmation" required autocomplete="new-password" placeholder="ReType-Password">
        </div>
        @error('password')
        <div class="form-group">
          <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
          </span>
        </div>
        @enderror

        <div class="form-group right">
          <button type="submit" class="form-button">登録</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
