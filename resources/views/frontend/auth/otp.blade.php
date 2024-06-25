@extends('frontend.auth.layouts.app')

@section('content')
@php
$phone = isset($phone) ? $phone : Session::get('phone');
// dd($phone);
@endphp
<div class="container">
  <div class="row">
    <div class="col-sm-6 m-auto">
      <div class="form-container">
          <div class="form-wrapper">
              <h3 class="text-center">OTP Verification</h3> 
              <p class="text-center">
                Enter Your One Time Pasword Here
              </p>
              <form method="POST" action="{{ route('login') }}" autocomplete="off">
              @csrf              
                <div class="row">                
                  @if(session('error'))
                  <div class="form-group col-lg-12 text-center">
                    <p class="login-success text-center">{{session('error')}}</p>
                  </div>
                  @endif
                  <div class="col-lg-6 offset-lg-3 col-12">
                    <div class="row">
                      <div class="form-group col-md-3 col-3">
                        <input type="number" name="otp1" class="form-control" maxlength="1" required>
                      </div>
                      <div class="form-group col-md-3 col-3">
                        <input type="number" name="otp2" class="form-control" maxlength="1" required>
                      </div>
                      <div class="form-group col-md-3 col-3">
                        <input type="number" name="otp3" class="form-control" maxlength="1" required>
                      </div>
                      <div class="form-group col-md-3 col-3">
                        <input type="number" name="otp4" class="form-control" maxlength="1" required>
                      </div>
                    </div>
                    <input type="hidden" name="phone" value="{{$phone}}">  

                    <div class="button-wrapper">
                      <button type="submit" class="btn btn-block ">Submit</button>
                    </div>
                  </div>
                </div> 
              </form>             
              <form method="POST" action="{{ route('send-otp') }}" autocomplete="off">
                @csrf
                <input type="hidden" name="phone" value="{{$phone}}">  
                <p class="text-center pt-3">
                  <button type="submit" class="btn btn-block ">Resend OTP</button>
                </p>
              </form>
          </div>
      </div>
    </div>
  </div>
</div>
@endsection