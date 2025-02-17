<?php
$baseUrl = config('app.url');
?>
<script>
    const BASEURL = "<?= $baseUrl ?>";
</script>
<!Doctype html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>{{ $title }} | CITY MAIL</title>
    <meta name="viewport"
        content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no" />
    <link rel="shortcut icon" href="favicon/favicon.svg">
    <meta name="msapplication-tap-highlight" content="no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/bamburgh.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/md-style.css') }}">
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-167963116-2"></script>

</head>

<body id="app-top">
    <div class="app-main">
        <div class="app-content p-0">
            <div class="row p-0">
                <div class="col-lg-6 p-0 bg-fixed">
                    <div>
                        <img src="{{ asset('images/default/auth/auth-3.jpg') }}" alt="Orio Pattern"
                            class="w-100 vh-100">
                    </div>
                </div>
                <div class="col-lg-6 d-flex justify-content-center align-items-center">
                    <div class="mt-4">
                        <div class="text-white">
                            <div class="logo-wrapper">
                                <a class="brand-logo text-center d-block">
                                    <img src="{{ asset('images/default/auth/logo.jpg') }}" width="147px"
                                        class="img-fluid" />
                                </a>
                            </div>
                            @yield('content')
                        </div>
                    </div>
                </div>
                <script>
                    const BASEURL = '<?php $baseUrl; ?>/';
                </script>
                <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
                <script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
                <script src="{{ asset('assets/js/core/jquery.cookie.min.js') }}"></script>
                <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.min.js') }}"></script>
                <script src="{{ asset('assets/js/core/bamburgh.min.js') }}"></script>
                <script src="{{ asset('assets/js/core/parsley.min.js') }}"></script>
                <script src="{{ asset('assets/vendor/select2/js/select2.min.js') }}"></script>
                <script src="{{ asset('assets/vendor/notify/js/notify.min.js') }}"></script>
                <script src="{{ asset('assets/js/core/common.js') }}"></script>
                @yield('script')
</body>

</html>
