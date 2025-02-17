@extends('layout.main')
@section('content')
    <div class="app-content">
        <div class="app-content--inner">
            <div class="pb-4 text-center text-xl-left">
                <div class="row align-items-center">
                    <div class="col-xl-6">
                        <div>
                            <h5 class="title-text mb-1">{{ $title }}</h5>
                             <p class="sub-title-text mb-0">Please see list of {{ strtolower($title) }} below</p>
                        </div>
                    </div>
                    <div class="col-xl-6 d-flex align-items-center justify-content-start mt-xl-0 justify-content-xl-end">
                        <div class="mx-auto mx-xl-0  btn-wrapper" style="margin-right: 16px !important;">
                            <a class="btn btn-secondary-orio" href="{{ Route('admin.add_edit_arrivals') }}">Add {{ ucfirst($title) }}</a> 
                        </div>
                        <div class="mx-auto mx-xl-0">
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
            </div>
            <div class="card card-box mb-3">
                <div class="card-header">
                    <div class="card-header--title">
                        <b>List of {{ strtolower($title) }}</b>
                    </div>
                </div>
               
                <div id="append_btn_div" class="d-none">
                    <div class="row ml-2">
                        <div class="col-2">
                            <button id="generate_pickup" class="btn btn-orio">Assign</button>
                        </div>
                    </div>
                </div>
                <table id="example" class="example2 display nowrap table table-hover" width="100%">
                    <thead class="thead">
                        <tr>
                            <th>SNO</th>
                            <th>Sheet #</th>
                            <th>DATE</th>
                            <th>CONSIGNMENT COUNT</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
            <script>
                var page_type = "list";
                var listRoute = "{{ Route('admin.arivals') }}";
            </script>
        @section('scripts')
             <script src="{{ asset('assets/js/arrivals/arrivals.js') }}"></script>
        @endsection

    @endsection
