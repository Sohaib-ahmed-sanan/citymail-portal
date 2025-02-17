@extends('auth.layout')
@section('content')
    <div class="heading-wrapper text-center mb-4">
        <h2 class="mb-2 Montserrat-Bold">
            Forgot Password ?
        </h2>
        <p class="font-size-sm mb-0 font-weight-bold Montserrat-Regular">
            Fill following form to recover your password
        </p>
    </div>
    <div class="form-wrapper">
        <form id="forgot" class="needs-validation row" data-parsley-validate method="post" novalidate>
            @csrf
            <div class="col-md-12 p-0">
                <div class="form-group">
                    <label for="" class="d-none">Username</label>
                    <input type="text" name="user_name" id="user_name" required placeholder="Username"
                        class="form-control custom-input" maxlength="50" tabindex="1" required>
                </div>
                <div class="text-center d-none" id="register_loader">
                    <div class="spinner-border m-2 text-danger" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>
                <button type="submit" class="btn btn-orio-auth w-100 Montserrat-Regular text-white" tabindex="4"
                    id="forgot-btn">Recover Password</button>
            </div>
        </form>
    </div>
    <div class="text-center py-3 Montserrat-Regular font-size-sm content-color">Don't have an account? <a
            href="{{ route('auth.register') }}" class="Montserrat-Regular" tabindex="5">Create an Account</a>
    </div>
@section('script')
    <script>
        var route = "{{ route('admin.check-forgot-pass') }}";
    </script>
     <script src="{{ asset('assets/js/auth/forgotPass.js') }}"></script>
@endsection
@endsection
