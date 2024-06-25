@extends('frontend.auth.layouts.app')

@section('content')
   
<div class="container">
    <div class="row">
      <div class="col-sm-6 m-auto">
        <div class="form-container">
            <div class="form-wrapper text-center">    
                <h3 class="mb-0">Email Verification</h3>
                <p class="my-4">{{$message}}</p>            
                <button type="submit" class="btn btn-block" onclick="window.location.href='/login'">Login</button>
            </div>
        </div>
      </div>
    </div>
</div>
@endsection

@push('custom-scripts')
<script>
    // alert()
</script>
@endpush
