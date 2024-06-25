@extends('frontend.auth.layouts.app')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-sm-6 m-auto">
      <div class="form-container">
          <div class="form-wrapper">
              <h3 class="text-center">Login</h3> 
              <form method="POST" action="{{ route('send-otp') }}" autocomplete="off">
              @csrf
                <div class="row"> 
                  @if(session('success'))
                  <div class="form-group col-lg-12 text-center">
                    <p class="login-success text-center">{{session('success')}}</p>
                  </div>
                  @endif
                  @if(session('error'))
                  <div class="form-group col-lg-12 text-center">
                    <p class="login-success text-center">{{session('error')}}</p>
                  </div>
                  @endif
                  {{-- <div class="form-group col-md-12">
                    <div class="input-group">
                      <input type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="none" autofocus placeholder="Username">
                      <div class="input-group-prepend">
                        <div class="input-group-text">@ballyscolombo.com</div>
                      </div>
                    </div>
                    @error('email')
                      <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                  </div>
                  <div class="form-group col-md-12">
                    <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="none" placeholder="Password">
                    @error('password')
                      <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                  </div>   --}}
                  <div class="form-group col-md-12">
                    <div class="input-group">
                      <input type="number" class="form-control text-center @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}" required autocomplete="none" autofocus placeholder="Mobile Number">                    
                    </div>
                    @error('phone')
                      <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                  </div>
                </div>
                  <div class="button-wrapper form-group  col-md-12">
                    <button id="send-btn" class="btn btn-block">Send</button>
                  </div>  
                </div>
              </form>
          </div>
      </div>
    </div>
  </div>
</div>
@endsection