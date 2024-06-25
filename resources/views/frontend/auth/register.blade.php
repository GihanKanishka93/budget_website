@extends('frontend.auth.layouts.app')

@section('content')
<div class="container">
    <div class="row">
      <div class="col-sm-6 m-auto">
        <div class="form-container">
            <div class="form-wrapper">
                <h3>Sign up</h3>
                <form method="POST" action="{{ route('register') }}" autocomplete="off">
                @csrf
                <div class="row">
                    <div class="form-group col-md-12">
                        <input type="text" class="form-control" name="first_name" value="{{ old('first_name') }}" required autocomplete="none" placeholder="First Name">
                    </div>
                    <div class="form-group col-md-12">
                        <input type="text" class="form-control" name="last_name" value="{{ old('last_name') }}" required autocomplete="none" placeholder="Last Name">
                    </div>
                    <div class="form-group col-md-12">
                        <div class="input-group">
                            <input type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="Email" required>
                            <div class="input-group-prepend">
                                <div class="input-group-text">@ballyscolombo.com</div>
                            </div>
                        </div>
                        @error('email')
                        <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group col-md-12">
                        <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="none" id="password" placeholder="Password">
                        @error('password')
                        <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group col-md-12">
                        <input type="password" class="form-control" id="confirmPassword" placeholder="Confirm Password" name="password_confirmation" required>
                    </div>
                    <div class="button-wrapper form-group  col-md-12">
                        <button type="submit" class="btn btn-block">Submit</button>
                        <p class="text-white mt-4">Already have an account <a href="{{ route('login') }}">Login</a></p>
                    </div>  
                </div>
                </form>
            </div>
        </div>
      </div>
    </div>
</div>
@endsection