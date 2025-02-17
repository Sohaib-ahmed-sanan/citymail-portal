@extends('auth.layout')
@section('content')
    <div class="heading-wrapper text-center mb-4">
        <h2 class="mb-2 Montserrat-Bold">
            Login to your account
        </h2>
        <p class="font-size-sm mb-0 font-weight-bold Montserrat-Regular">
            and let's get those orders moving!
        </p>
    </div>
    <div class="form-wrapper">
        <form id="login" class="needs-validation row" data-parsley-validate method="post" novalidate>
            @csrf
            <div class="col-md-12 p-0">
                <div class="form-group">
                    <label for="" class="d-none">Username</label>
                    <input type="text" name="user_name" id="user_name" required placeholder="Username"
                        class="form-control custom-input" maxlength="50" tabindex="1" required>
                </div>
                <div class="form-group eye-toggle">
                    <label for="" class="d-none">Password</label>
                    <input type="password" id="Lpass" name="password" placeholder="Password"
                        class="form-control custom-input passwordField" tabindex="2" maxlength="50" required>
                    <span style="right: -13px !important" class="input-group-text p-1 bg-white eye-check show_pass_btn">
                        <i class="bi bi-eye"></i></span>
                    <div class="text-danger fw-bolder d-none" style="font-weight: bold" id="invalidError"></div>
                    <div class="d-flex justify-content-end">
                        <a href="{{ route('admin.forgot-pass') }}" class="mt-1 Montserrat-Regular font-size-sm"
                            tabindex="3">Forgot password?</a>
                    </div>
                </div>
                <div class="text-center d-none" id="register_loader">
                    <div class="spinner-border m-2 text-danger" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>
                <button type="submit" class="btn btn-orio-auth w-100 Montserrat-Regular text-white" tabindex="4"
                    id="signin">Sign in</button>
            </div>
        </form>
    </div>
    {{-- <div class="text-center py-3 Montserrat-Regular font-size-sm content-color">Don't have an account? <a href="{{ route('auth.register') }}" class="Montserrat-Regular" tabindex="5">Create an Account</a> --}}
    </div>
@section('script')
    <script>
        var storeUrl = "{{ route('admin.store_registration') }}";
        var loginUrl = "{{ route('auth.login_check') }}";
    </script>
    <script src="{{ asset('assets/js/auth/register.js') }}"></script>
@endsection
@endsection
