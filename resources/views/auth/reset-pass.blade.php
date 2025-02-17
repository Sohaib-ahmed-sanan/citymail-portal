@extends('auth.layout')
@section('content')
    <?php
    if (!isset($_GET['token']) || $_GET['token'] == '') {
        header('location:' . config('app.url'));
        exit();
    }
    $current_time = time();
    [$user_name, $time_stamp] = explode(':', $_GET['token']);
    if ($current_time - $time_stamp > 300) {
        header('location:' . config('app.url'));
        exit();
    }
    ?>
    <div class="heading-wrapper text-center mb-4">
        <h2 class="mb-2 Montserrat-Bold">
            Recover Password
        </h2>
        <p class="font-size-sm mb-0 font-weight-bold Montserrat-Regular">
            Set new password for your account
        </p>
    </div>
    <div class="form-wrapper">
        <form id="reset" class="needs-validation row" data-parsley-validate method="post" novalidate>
            @csrf
            <div class="col-md-12 p-0">
                <div class="form-group eye-toggle">
                    <label for="" class="d-none">Password</label>
                    <input type="password" id="pass" name="password" placeholder="Password"
                        class="form-control custom-input passwordField" tabindex="1" maxlength="50" required>
                    <span class="input-group-text p-1 bg-white eye-check show_pass_btn">
                        <i class="bi bi-eye"></i></span>
                    <div class="text-danger fw-bolder d-none" style="font-weight: bold" id="invalidError"></div>
                </div>
                <div class="form-group eye-toggle">
                    <label for="" class="d-none">Confirm password</label>
                    <input type="password" tabindex="2" minlength="6" maxlength="10" id="Confirmpass" name="Confirmpass"
                        data-parsley-equalto="#pass" class="form-control custom-input passwordField"
                        placeholder="Re-Enter Password" required="">
                    <span class="input-group-text p-1 bg-white eye-check show_pass_btn"> <i class="bi bi-eye"></i></span>
                </div>
                <div class="text-center d-none" id="register_loader">
                    <div class="spinner-border m-2 text-danger" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>
                <button type="submit" class="btn btn-orio-auth w-100 Montserrat-Regular text-white" tabindex="3"
                    id="reset-btn">Reset Password</button>
            </div>
            <input type="hidden" name="user_name" id="user_name" value="{{ $user_name }}"
                class="form-control custom-input" maxlength="50">
        </form>
    </div>
    <div class="text-center py-3 Montserrat-Regular font-size-sm">Don't have an account? <a
            href="{{ route('auth.register') }}" class="Montserrat-Regular" tabindex="5">Create an Account</a>
    </div>
@section('script')
    <script>
        var route = "{{ route('admin.reset-password') }}";
    </script>
    <script src="{{ asset('assets/js/auth/forgotPass.js') }}"></script>
@endsection
@endsection
