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
                </div>
            </div>
            <div class="card card-box mb-3">
                <div class="card-header">
                    <div class="card-header--title">
                        <b>List of {{ strtolower($title) }}</b>
                    </div>
                </div>
                <div class="order-filter-wrapper p-3 mb-3 border-bottom">
                    <form id="special-form" method="post">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="col-md-12">
                                    <div class="col-sm-10">
                                        <label for="cn_no">Consignment no<span class="req">*</span></label>
                                        <input style="width: 200px !important;" required name="cn_no" type="text" class="form-control form-control-lg" id="cn_no" data-role="tagsinput">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <button type="button" class="btn btn btn-orio float-right" id="search-btn">Search</button>
                            </div>
                        </div>
                    </form>

                    <div class="row" id="output" style="overflow-y: scroll;max-height: 600px;">

                    </div>
                </div>
            </div>
            <script>
                var route = "{{ Route('admin.tracking_data') }}";
            </script>
        @section('scripts')
            <script src="{{ asset('assets/js/tracking/tracking.js') }}"></script>
        @endsection
        
    @endsection
