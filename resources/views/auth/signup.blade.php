@extends('auth.layout')
@section('content')
    <div class="heading-wrapper text-center mb-4">
        <h2 class="mb-2 Montserrat-Bold">
            Create account
        </h2>
        <p class="font-size-sm mb-0 font-weight-bold Montserrat-Regular">
            Fill in the fields below and you'll be good to go.
        </p>
    </div>
    <div class="form-wrapper">
        <form id="register" class="needs-validation row" data-parsley-validate method="post" novalidate="">
            @csrf
            <div class="col-md-10 mx-auto">
                <div class="form-group">
                    <label for="" class="d-none">First name</label>
                    <input type="text" tabindex="1" maxlength="40" name="first_name" value="{{ old('first_name') }}"
                        label="first name" id="f_name" class="form-control custom-input" placeholder="First Name"
                        required="">
                </div>
                <div class="form-group">
                    <label for="" class="d-none">Last name</label>
                    <input type="text" tabindex="2" maxlength="40" name="last_name" required label="last name"
                        value="{{ old('last_name') }}" id="l_name" class="form-control custom-input"
                        placeholder="Last Name">
                </div>
                <div class="form-group">
                    <label for="" class="d-none">Email</label>
                    <input type="email" tabindex="3" maxlength="40" id="Remail" name="email" label="email"
                        class="form-control custom-input" placeholder="Email" required="">
                </div>
                <div class="form-group">
                    <label for="" class="d-none">User name</label>
                    <input type="text" minlength="4" tabindex="4" maxlength="15" name="user_name" required label="user name"
                        value="{{ old('user_name') }}" id="user_name" class="form-control custom-input"
                        placeholder="User Name">
                    <div class="invalid-feedback" id="user_exists" style="display: none;">
                        <b>User name already taken please use different</b>
                    </div>
                </div>
                <div class="form-group eye-toggle">
                    <label for="" class="d-none">Password</label>
                    <input type="password" tabindex="5" minlength="6" maxlength="10" name="password" required label="password"
                        value="{{ old('password') }}" id="Rpass" class="form-control custom-input passwordField"
                        placeholder="Password" required="">
                    <span class="input-group-text p-1 bg-white eye-check show_pass"> <i class="bi bi-eye-slash"></i></span>
                </div>
                <div class="form-group eye-toggle">
                    <label for="" class="d-none">Confirm password</label>
                    <input type="password" minlength="6" maxlength="10" id="Confirmpass" name="Confirmpass"
                        data-parsley-equalto="#Rpass" tabindex="6" class="form-control custom-input passwordField"
                        placeholder="Re-Enter Password" required="">
                    <span class="input-group-text p-1 bg-white eye-check show_pass"> <i class="bi bi-eye-slash"></i></span>
                </div>
                <div class="form-check">
                    <input type="checkbox" tabindex="7" id="terms_check" name="termscondition" class="form-check-input">
                    <label for="invalidCheck" class="Montserrat-Regular font-size-sm content-color">I have
                        read and agreed to the <a href="https://orio.tech/privacy-policy" target="_blank"
                            class="Montserrat-Regular font-size-sm">Privacy
                            Policy</a> and <a href="https://orio.tech/terms-conditions" target="_blank"
                            class="Montserrat-Regular font-size-sm">Terms and
                            Conditions</a></label>
                    <div class="text-danger fw-bolder d-none" style="font-weight: bold" id="conditions_err"></div>
                </div>
                <div class="text-center d-none" id="register_loader">
                    <div class="spinner-border m-2 text-danger" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>
                <button tabindex="8" class="btn btn-orio w-100 Montserrat-Regular text-white"
                    id="register_button">Create Account</button>
            </div>
        </form>
    </div>
    <div class="text-center pt-3 Montserrat-Regular font-size-sm content-color" tabindex="7">Already have
        an account? <a href="{{ route('auth.login') }}" class="Montserrat-Regular" tabindex="8">Sign in</a></div>
@section('script')
    <script>
        var storeUrl = "{{ route('admin.store_registration') }}";
        var loginUrl = "{{ route('auth.login_check') }}";
    </script>
    <script src="{{ asset('assets/js/auth/register.js') }}"></script>
@endsection
@endsection
