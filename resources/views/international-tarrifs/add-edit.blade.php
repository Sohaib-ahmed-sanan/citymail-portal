@extends('layout.main')
@section('content')
    <div class="app-content">
        @php
            $selectedServiceIds = explode(',',request('id'));
        @endphp
        {{-- Add tarif modal --}}
      
        <div class="modal fade charges_modal" id="add_tariff_modal" role="dialog" aria-labelledby="editsucessModal" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6 class="modal-title" id="modal-title-default">Add Tariff</h6>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <form class="tariff_details" data-input_hidden="#tariff_display"
                                    data-display_table="#tariff_display" action="#" data-parsley-validate
                                    id="tariff_details" method="post">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label class="form-label" for="service" id="service_name">
                                                Select Service</label>
                                            <select required
                                                class="form-control form-select service_name form-control-lg input_field "
                                                id="service_name_e" data-toggle="select2" name="service_name" size="1"
                                                label="Service" data-placeholder="Select Service" data-allow-clear="1">
                                                <option value="">Select Service</option>
                                                @foreach (session('services') as $service)
                                                    @if (in_array($service->id, $selectedServiceIds))
                                                        <option value="{{ $service->id }}">
                                                            {{ $service->service_name }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label" for="" >Destination Country</label>
                                            <select required
                                                class="form-control form-control-lg form-select destination_country form-control form-control-lg-lg input_field "
                                                id="destination_country" data-toggle="select2" name="destination_country"
                                                size="1" label="Destination Country"
                                                data-placeholder="Destination Country" data-allow-clear="1">
                                                <option value="">Destination Country</option>
                                                @foreach ($countries as $country)
                                                    <option value="{{ $country->id }}">
                                                        {{ $country->country_name }} </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label" for="start_weight">Start Weight<span
                                                    class="req">*</span></label>
                                            <input type="text" class="form-control form-control-lg float" id="start_weight"
                                                name="start_weight" data-parsley-type="number" minlength="1" maxlength="4"
                                                placeholder="Enter Start Weight" required="true">
                                        </div>
                                        <div class="col-md-4 mt-2">
                                            <label class="form-label" for="end_weight">End Weight<span
                                                    class="req">*</span></label>
                                            <input type="text" class="form-control form-control-lg float" id="end_weight"
                                                name="end_weight" data-parsley-type="number" minlength="1" maxlength="4"
                                                placeholder="Enter End Weight" required="true">
                                        </div>
                                        <div class="col-md-4 mt-2">
                                            <label class="form-label" for="charges">Charges<span
                                                    class="req">*</span></label>
                                            <input type="text" class="form-control form-control-lg float" id="charges"
                                                name="charges" data-parsley-type="number" minlength="1" maxlength="10"
                                                placeholder="Enter Charges" required="true">
                                        </div>
                                        <div class="col-md-4 mt-2">
                                            <label class="form-label" for="add_weight">Additional Weight<span
                                                    class="req">*</span></label>
                                            <input type="text" class="form-control form-control-lg float" id="add_weight"
                                                name="add_weight" data-parsley-type="number" minlength="1" maxlength="3"
                                                placeholder="Enter Additional Weight">
                                        </div>
        
                                        <div class="col-md-4 mt-2">
                                            <label class="form-label" for="add_charges">Additional Charges<span
                                                    class="req">*</span></label>
                                            <input type="text" class="form-control form-control-lg float" id="add_charges"
                                                name="add_charges" data-parsley-type="number" minlength="1" maxlength="10"
                                                placeholder="Enter Additional Charges">
                                        </div>
                                        <div class="col-md-8 mt-4">
                                            <button type="button" data-count="1" data-type="tarrif"
                                                data-form_id="#tariff_details"
                                                class="float-right btn btn-orio btn-sm add_more_info min-w-20">
                                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M1.5 10H18.5" stroke="#fff" stroke-width="2" stroke-linecap="round"></path>
                                                    <path d="M10 18.5V1.5" stroke="#fff" stroke-width="2" stroke-linecap="round"></path>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                                <div style="overflow-x: scroll" class="tabel-responsive">
                                    <table class="example2 display nowrap table table-hover" width="100%">
                                        <thead class="thead">
                                            <tr>
                                                <th>SNO</th>
                                                <th>Service</th>
                                                <th>Origin Country</th>
                                                <th>Destination Country</th>
                                                <th>Start weight</th>
                                                <th>End weight</th>
                                                <th>Charges</th>
                                                <th>Additional weight</th>
                                                <th>Additional Charges</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tariff_display">
                                            <tr class="default-tarif text-center">
                                                <td colspan="15">No Tariff Found</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-md-12 text-center mt-1">
                                <div class="d-flex justify-content-center w-100">
                                    <button type="button" class="btn btn-sm btn-secondary-orio mr-3 my-3"
                                        data-dismiss="modal" aria-label="Close">Close</button>
                                    <button type="button" id="add_new_charge_btn" data-form_id="#add_new_tariff"
                                        class="btn btn-sm btn-orio add_new_charge_btn my-3">Add Charges</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="app-content--inner order-detail-wrapper">
            <div class="pb-4 text-center text-xl-left">
                <div class="row align-items-center">
                    <div class="col-xl-5">
                        <div>
                            <h5 class="title-text mb-1">{{ $title }}</h5>
                             <p class="sub-title-text mb-0">Please see list of {{ strtolower($title) }} below</p>
                        </div>
                    </div>
                    <div class="col-xl-7 d-flex align-items-center justify-content-start mt-xl-0 justify-content-xl-end">
                        <button class="btn btn-secondary-orio mr-2" data-toggle="modal" data-target="#add_tariff_modal">Add
                            Tarrif</button>
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
                            <th class="d-flex align-items-center justify-content-center">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox"class="custom-control-input" id="check_all">
                                    <label class="custom-control-label" for="check_all"></label>
                                </div>
                                SNO
                            </th>
                            <th>Service</th>
                            <th>Destination Country</th>
                            <th>Start Weight</th>
                            <th>End Weight</th>
                            <th>Charges</th>
                            <th>Additional Weight</th>
                            <th>Additional Charges</th>
                            <th>ACTION</th>
                        </tr>
                    </thead>
                </table>
            </div>
    </div>
@section('scripts')
    <script>
        var service_id = "{{ request('id') }}";
    </script>
    <script src="{{ asset('assets/js/international-tarrif/main.js') }}"></script>
    <script src="{{ asset('assets/js/international-tarrif/charges.js') }}"></script>
@endsection
@endsection
