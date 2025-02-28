@extends('layout.main')
@section('content')
    <div class="app-content">
        <div class="app-content--inner">
            <div class="pb-4 text-center text-xl-left">
                <div class="row align-items-center">
                   <div class="col-xl-5">
                        <div>
                            <h5 class="title-text mb-1">{{ $title }}</h5>
                             <p class="sub-title-text mb-0">Please see list of {{ strtolower($title) }} below</p>
                        </div>
                    </div>
                    <div class="col-xl-7 d-flex align-items-center justify-content-start mt-xl-0 justify-content-xl-end">
                        <div class="d-inline-block btn-group btn btn-primary coursor-pointer">
                            <div id="datepicker">
                                <span class="date_title"></span>
                                <span class="date_range"></span>
                                <i class="fa fa-caret-down"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card card-box mb-3">
                <div class="card-header">
                    <div class="card-header--title">
                        <b>List of {{ strtolower($title) }}</b>
                    </div>
                </div>
                <table id="example" class="example2 display nowrap table table-hover" width="100%">
                    <thead class="thead">
                        <tr>
                            <th>SNO</th>
                            <th>Service</th>
                            <th>Total Tarifs count</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        @section('scripts')
            <script src="{{ asset('assets/js/datatable-helper.js') }}"></script>
        @endsection
    @endsection
