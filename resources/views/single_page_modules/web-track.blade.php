<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Track Shipments</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/bamburgh.min.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/md-style.css') }}">
</head>
<style>
    .customInput {
        background: #f3f6f9 !important;
        border: 0 !important;
        height: 50px !important;
        border-radius: 0.6rem !important;
    }
</style>

<body>
    <div class="container-fuid">
        <div class="row">
            <div class="col-md-6">
                <img src="{{ asset('images/default/auth/auth-3.jpg') }}"  style="
                object-fit: cover;
                height: 100%;
            " class="w-100" alt="">
            </div>
            <div class="col-md-6 mt-5">
                <div class="heading-wrapper text-center mb-2">
                    <h2 class="mb-2 Montserrat-Bold">
                        Track Your Shipments Here
                    </h2>
                </div>
                <div class="row text-center mt-4 justify-content-center align-items-center">
                    <div class="col-md-7">
                        <div class="form-group mb-0">
                            <label for="" class="d-none">Username</label>
                            <input type="text" id="track-nav" name="cn_number" placeholder="Enter Consignment Number"
                                class="form-control customInput" maxlength="50" tabindex="1">
                        </div>
                    </div>
                    <div class="col-md-12 mt-3">
                        <div style="height: 360px; overflow-y: auto;">
                            <div id="track-details"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
<script>
    var track_route = "{{ Route('admin.tracking_data_web') }}";
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
