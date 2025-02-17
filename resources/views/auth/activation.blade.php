@extends('auth.layout')
@section('content')
    <?php
    if (!isset($_GET['token']) || $_GET['token'] == '') {
        header('location:' . config('app.url') . '/');
        exit();
    }
    $current_time = time();
    [$token, $time_stamp] = explode(':', $_GET['token']);
    [$all, $tabel] = explode('|', $_GET['token']);
    ?>
    <div class="heading-wrapper text-center mb-4">
        <h2 class="mb-2 Montserrat-Bold">
            Account Activation
        </h2>
        <p class="font-size-sm mb-0 font-weight-bold Montserrat-Regular m-4">Please wait while we are activating your account!</p>
        <div class="text-center" id="register_loader">
            <div class="spinner-border m-2 text-danger" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <div class="d-none">
            <input type="hidden" id="token" value="{{ $token }}">
            <input type="hidden" id="tabel" value="{{ base64_decode($tabel) }}">
        </div>
    @section('script')
        <script>
            var route = "{{ route('admin.check_activaton') }}";
        </script>
        <script src="{{ asset('assets/js/auth/activation.js') }}"></script>
    @endsection
@endsection
