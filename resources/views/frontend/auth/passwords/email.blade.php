@extends('frontend.auth.layouts.app')

@section('content')
<section id="entrance" class="d-flex justify-content-center align-items-center">
    <div class="container ">
      <div class="row">
        <div class="col-lg-7 mx-auto">
          <div class="form-div">
            <div class="text-center">
              <img src="{{ asset('frontend/images/netstripes_logo.svg') }}" class="img-fluid w-50 pb-4" alt="">
            </div>
            <h4>{{ __('Reset Password') }}</h4>
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif
            <form method="POST" action="{{ route('password.email') }}" autocomplete="off">
            @csrf
              @if(session('success'))
                  <span class="login-success">{{session('success')}}</span>
              @endif
              <div class="form-group">
                <label for="emailAddress">{{ __('E-Mail Address') }}</label>
                <input id="emailAddress" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="none" autofocus>
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
              </div>
              <button type="submit" class="btn w-100 mt-4">{{ __('Send Password Reset Link') }}</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection
