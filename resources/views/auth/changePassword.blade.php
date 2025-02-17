@extends('layout.main')
@section('content')
    <div class="app-content">
        <div class="app-content--inner order-detail-wrapper">
            <div class="pb-4 text-center text-xl-left">
                <div class="row align-items-center">
                    <div class="col-xl-7">
                        <div>
                            <ol class="d-inline-block breadcrumb text-uppercase font-size-xs p-0">
                                <li class="d-inline-block breadcrumb-item"><a href="{{ Route('admin.index') }}">Dashboard</a>
                                </li>
                                <li class="d-inline-block breadcrumb-item active">{{ $title }}</li>
                            </ol>
                            <h5 class="display-4 mt-1 mb-2 font-weight-bold text-uppercase">{{ $title }}</h5>
                            <p class="text-black-50 mb-0">{{ ucfirst($title) }} below by filling the form</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="catalogue-wrapper">
                <div class="row">
                    <div class="col-12">
                        <div class="card card-box mb-5">
                            <div class="card-header">
                                <div class="card-header--title">
                                    <small class="d-block text-uppercase mt-1">{{ $title }}</small>
                                    <b>{{ ucfirst($title) }}:</b>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="no-gutters row">
                                    <div class="col-md-12">
                                        <form data-parsley-validate class="needs-validation" method="POST"
                                            id="change-pass">
                                            <div class="form-row">
                                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                    <div class="form-group eye-toggle">
                                                        <label for="old_password">Old Password<span
                                                                class="req">*</span></label>
                                                        <input type="password" label="Old Password"
                                                            class="form-control passwordField" id="old_password"
                                                            name="old_password" placeholder="Old Password" minlength="6" maxlength="15" required="" autocomplete="off">
                                                        <span class="show_pass_btn" style="top: 37px !important;"><i  class="fa-regular fa-eye"></i></span>
                                                    </div>
                                                    <div class="form-group eye-toggle">
                                                        <label for="new_password">New Password<span
                                                                class="req">*</span></label>
                                                        <input label="Password" type="password"
                                                            class="form-control passwordField" id="new_password"
                                                            name="new_password" placeholder="New Password" minlength="6" maxlength="15" required="" autocomplete="off">
                                                        <span class="show_pass_btn" style="top: 37px !important;"><i  class="fa-regular fa-eye"></i></span>
                                                    </div>
                                                    <div class="form-group eye-toggle">
                                                        <label for="confirm_password">Confirm Password<span class="req">*</span></label>
                                                        <input label="Confirm password" type="password"
                                                            data-parsley-equalto="#new_password"
                                                            class="form-control passwordField" id="confirm_password"
                                                            name="confirm_password" placeholder="Confirm Password"
                                                            minlength="6" maxlength="15" required="" autocomplete="off">
                                                        <span class="show_pass_btn" style="top: 37px !important;"><i class="fa-regular fa-eye"></i></span>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div>
                                                        <button id="change-btn" tabindex="6" type="button" class="btn btn-orio float-right">Update</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <script>
        var ajaxUrl = "{{ route('admin.updatePass') }}";
    </script>
@section('scripts')
    <script src="{{ asset('assets/js/auth/changePass.js') }}"></script>
@endsection
@endsection
