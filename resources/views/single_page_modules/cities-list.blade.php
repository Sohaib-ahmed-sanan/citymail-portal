@extends('layout.main')
@section('content')

 {{-- Edit modal --}}
 <div class="modal fade" id="add_modal" role="dialog" aria-labelledby="editsucessModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered w-800" role="document">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h6 class="modal-title" id="modal-title-default">Add City</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">
                        <svg viewBox="0 0 24 24" width="26" height="26" stroke="currentColor"
                            stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"
                            class="css-i6dzq1">
                            <line x1="18" y1="6" x2="6" y2="18"></line>
                            <line x1="6" y1="6" x2="18" y2="18"></line>
                        </svg>
                    </span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <form id="add_city_form" method="POST" enctype="multipart/form-data"
                        data-parsley-validate>
                        @csrf
                        <div class="form-row">
                            <div class=" col-md-6 px-3">
                                <label class="form-label">Select Country<span class="req">*</span></label>
                                <select required
                                    class=" form-control form-control-lg form-select form-control form-control-lg-lg input_field "
                                    id="add_country_id" data-toggle="select2" name="country_id" size="1"
                                    label="Select Country" data-placeholder="Select Country"
                                    data-allow-clear="1">
                                    <option value="">Select Country</option>
                                    @foreach ($countries as $country)
                                        <option value="{{ $country->id }}">
                                            {{ $country->country_name }} </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 px-3">
                                <label class="form-label">City Name<span class="req">*</span></label>
                                <input type="text" name="city_name" minlength="3" maxlength="20" parsely-data-type="string" 
                                class="form-control form-control-lg" id="city_name" label="City Name"
                                required placeholder="City Name">
                            </div>
                        </div>    
                    </div>
                    <div class="col-md-12 text-center mt-1">
                        <div class="d-flex justify-content-center w-100">
                            <button type="button" class="btn btn-secondary-orio mr-3 my-3" data-dismiss="modal" aria-label="Close">Close</button>
                            <button type="button" class="btn btn-orio my-3" id="add-city">Add City</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

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
                        <div class="mx-auto mx-xl-0  btn-wrapper" data-toggle="modal" data-target="#add_modal" style="margin-right: 16px !important;">
                            <a class="btn btn-secondary-orio" >Add City</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card card-box mb-3">
                <div class="card-header">
                    <div class="card-header--title">
                        <div class="row">
                            <div class="col-6">
                                <b>List of {{ $title }}</b>
                            </div>
                        </div>
                    </div>
                </div>
                  
                <table id="example" class="example2 display nowrap table table-hover" width="100%">
                    <thead class="thead">
                        <tr>
                            <th>SNO</th>
                            <th>City name</th>
                            <th>Country Code</th>
                            <th>City id</th>
                            <th>Zone</th>
                        </tr>
                    </thead>
                </table>
            </div>
            
        @section('scripts')
        <script>
            const countries_array = @json($countries);
        </script>
        <script src="{{ asset('assets/js/admin/city-list.js') }}"></script>
        @endsection

    @endsection
