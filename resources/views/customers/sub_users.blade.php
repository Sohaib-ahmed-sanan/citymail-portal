@extends('layout.main')
@section('content')
    <div class="app-content">
        <div class="app-content--inner">
            <div class="pb-4 text-center text-xl-left">
                <div class="row align-items-center">
                    <div class="col-xl-6">
                        <div>
                            <ol class="d-inline-block breadcrumb text-uppercase font-size-xs p-0">
                                <li class="d-inline-block breadcrumb-item"><a href="{{ Route('admin.index') }}">Dashboard</a></li>
                                <li class="d-inline-block breadcrumb-item"><a href="javascript::void(0)">Admin</a></li>
                                <li class="d-inline-block breadcrumb-item active" aria-current="page">{{ $title }}</li>
                            </ol>
                            <h5 class="display-4 mt-1 mb-2 font-weight-bold">{{ $title }}</h5>
                            <p class="text-black-50 mb-0">Please see list of {{ strtolower($title) }} below</p>
                        </div>
                    </div>
                    <div class="col-xl-6 d-flex align-items-center justify-content-start mt-xl-0 justify-content-xl-end">
                        <div class="mx-auto mx-xl-0 mt-3 btn-wrapper">
                            <a class="btn btn-secondary-orio" href="{{ Route('customer.add_edit_sub_user') }}">Add {{ ucfirst($title) }}</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card card-box mb-3">
                <div class="card-header">
                    <div class="card-header--title">
                        <small>{{ $title }}</small>
                        <b>List of <span class="text-lowercase">{{ $title }}</span></b>
                    </div>
                    <div class="card-header--actions">
                        <div class="mx-auto mx-xl-0">
                            <div class="d-inline-block btn-group btn btn-primary coursor-pointer">
                                <div id="datepicker">
                                    <i class="fa fa-calendar"></i>
                                    <span class="date_title"></span>
                                    <span class="date_range"></span>
                                    <i class="fa fa-caret-down"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <table id="example" class="example2 display nowrap table table-hover" width="100%">
                    <thead class="thead">
                        <tr>
                            <th>SNO</th>
                            <th>Account Title</th>
                            <th>NAME</th>
                            <th>EMAIL</th>
                            <th>PHONE</th>
                            <th>ADDRESS</th>
                            <th>ACTIVE</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
            <script>
                var listRoute = "{{ Route('customer.sub_accounts') }}";
            </script>
        @section('scripts')
            <script src="{{ asset('assets/js/customers/sub_users.js') }}"></script>
        @endsection
    @endsection
