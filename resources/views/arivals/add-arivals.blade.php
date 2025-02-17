@extends('layout.main')
@section('content')
    <div class="app-content">
        <div class="app-content--inner">
            <div class="pb-4 text-center text-xl-left">
                <div class="row align-items-center">
                    <div class="col-xl-6">
                         <div>
                            <h5 class="title-text mb-1">{{ $title }}</h5>
                             <p class="sub-title-text mb-0">Add {{ strtolower($title) }} by filling the form below</p>
                        </div>
                    </div>
                    <div class="col-xl-6 d-flex align-items-center justify-content-start mt-xl-0 justify-content-xl-end">
                        <div class="mx-auto mx-xl-0 mt-3 btn-wrapper">
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
                    <form action="#" data-parsley-validate id="search_form" method="post">
                        <div class="row" data-select2-id="6">
                            <div class="col-md-3" data-select2-id="5">
                                <label for="station_id">Select Station<span class="req">*</span></label>
                                <select required class="form-control form-select station_id form-control-lg input_field"
                                    id="station_id" data-toggle="select2" name="station_id" size="1"
                                    label="Select Station" data-placeholder="Select Station" data-allow-clear="1">
                                    <option value="">Select Station</option>
                                    @foreach ($stations as $station)
                                        <option value="{{ $station->id }}">{{ $station->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            {{-- <div class="col-md-3" data-select2-id="5">
                                <label for="riders_id">Select Rider<span class="req">*</span></label>
                                <select required class="form-control form-select riders_id form-control-lg input_field"
                                    id="riders_id" data-toggle="select2" name="riders_id" size="1"
                                    label="Select Rider" data-placeholder="Select Rider" data-allow-clear="1">
                                    <option value="">Select Rider</option>
                                    @foreach ($riders as $rider)
                                        <option value="{{ $rider->id }}">{{ $rider->first_name }}
                                            {{ $rider->last_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3" data-select2-id="5">
                                <label for="route_id">Select Route<span class="req">*</span></label>
                                <select required class="form-control form-select route_id form-control-lg input_field"
                                    id="route_id" data-toggle="select2" name="route_id" size="1" label="Select Route"
                                    data-placeholder="Select Route" data-allow-clear="1">
                                    <option value="">Select Route</option>
                                    @foreach ($routes as $route)
                                        <option value="{{ $route->id }}">{{ $route->address }}</option>
                                    @endforeach
                                </select>
                            </div> --}}
                            <div class="col-md-3">
                                <label for="shipment_no">Consignment No<span class="req">*</span></label>
                                <input minlength="5" maxlength="13" data-parsley-type="integer" type="int"
                                    class="form-control form-control-lg number" id="shipment_no" name="shipment_no"
                                    placeholder="Enter Consignment No" value="" required="true">
                            </div>
                            <div class="d-flex col-md-3">
                                <div class="wp-col col-md-6 d-none">
                                    <label for="shipment_no">Peices<span class="req">*</span></label>
                                    <input class="form-control form-control-lg number" id="peices-first"
                                        data-parsley-validate="number" placeholder="Enter Peices" required="true"
                                        minlength="1" maxlength="5">
                                </div>
                                <div class="wp-col col-md-6 d-none">
                                    <label for="shipment_no">Weight<span class="req">*</span></label>
                                    <input data-parsley-validate="number" class="form-control form-control-lg float"
                                        minlength="1" maxlength="5" id="weight-first" name=""
                                        placeholder="Enter Weight" value="" required="true">
                                </div>
                            </div>
                            <div class="col-md-3 mt-3">
                                    <button type="button"
                                        class="d-none btn btn-secondary-orio mx-2 my-3 float-right"
                                        id="search-btn">Search</button>
                            </div>
                            <div class="col-md-12 mt-3">
                                    <button type="button"
                                        class="d-none btn btn-secondary-orio mx-2 my-3 float-right" id="save-btn">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div style="overflow-x: scroll">
                    <table class="example display nowrap table table-hover" width="100%">
                        <thead class="thead">
                            <tr>
                                <th>Consignment No #</th>
                                <th>SHIPPER NAME</th>
                                <th>CONSIGNEE NAME</th>
                                <th>DESTINATION CITY</th>
                                <th>REFERANCE</th>
                                <th>PEICES</th>
                                <th>WEIGHT</th>
                                <th>ACTION</th>
                            </tr>
                        </thead>
                        <tbody id="arrival_list">
                            <tr id="def_msg" class="text-center">
                                <td colspan="8">No Records Found</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <form action="" method="post" id="insert_arrival">
                </form>
            </div>
        @section('scripts')
            <script>
                var page_type = "add";
            </script>
            <script src="{{ asset('assets/js/arrivals/arrivals.js') }}"></script>
        @endsection
    @endsection
