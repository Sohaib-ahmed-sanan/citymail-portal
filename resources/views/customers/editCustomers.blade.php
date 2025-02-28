@extends('layout.main')
@section('content')
    @php
        $selectedServiceIds = explode(',', $payload->service_id);
    @endphp
    {{-- Add tarif modal --}}
    <div class="modal fade" id="add_tariff_modal" role="dialog" aria-labelledby="editsucessModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
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

                            <form class="tariff_details" data-input_hidden="#tariff_hidden_feilds"

                                data-display_table="#tariff_display" action="#" data-parsley-validate

                                id="tariff_details" method="post">

                                <div class="row">

                                    <div class="col-md-3">

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

                                    <div class="col-md-3">

                                        <label class="form-label" for="" >Origin Country</label>

                                        <select required

                                            class="form-control form-control-lg form-select origin_country form-control form-control-lg-lg input_field "

                                            id="origin_country" data-toggle="select2" name="origin_country" size="1"

                                            label="Origin Country" data-placeholder="Origin Country" data-allow-clear="1">

                                            <option value="">Origin Country</option>

                                            @foreach ($countries as $country)

                                                <option value="{{ $country->id }}">

                                                    {{ $country->country_name }} </option>

                                            @endforeach

                                        </select>

                                    </div>

                                    <div class="col-md-3">

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

                                    <div class="col-md-3">

                                        <label class="form-label" for="Region" >Select

                                            Zone</label>

                                        <select required

                                            class="form-control form-select region form-control-lg input_field "

                                            id="region_type" data-toggle="select2" name="region_type" size="1"

                                            label="Zone" data-placeholder="Select Zone" data-allow-clear="1">

                                            <option value="">Select Region</option>

                                            <option value="T-1">Tier-1</option>

                                            <option value="T-2">Tier-2</option>

                                            <option value="T-3">Tier-3</option>

                                        </select>

                                    </div>

                                    <div class="mt-2 col-md-3">
                                        <label class="form-label" for="start_weight">Start Weight<span class="req">*</span></label>
                                        <input type="text" class="form-control form-control-lg float" id="start_weight"
                                            name="start_weight" data-parsley-type="number" minlength="1" maxlength="4"
                                            placeholder="Enter Start Weight" required="true">
                                    </div>

                                    <div class="col-md-3 mt-2">

                                        <label class="form-label" for="end_weight">End Weight<span class="req">*</span></label>

                                        <input type="text" class="form-control form-control-lg float" id="end_weight"

                                            name="end_weight" data-parsley-type="number" minlength="1" maxlength="4"

                                            placeholder="Enter End Weight" required="true">

                                    </div>

                                    <div class="col-md-3 mt-2">

                                        <label class="form-label" for="charges">Charges<span class="req">*</span></label>

                                        <input type="text" class="form-control form-control-lg float" id="charges"

                                            name="charges" data-parsley-type="number" minlength="1" maxlength="4"

                                            placeholder="Enter Charges" required="true">

                                    </div>

                                    <div class="col-md-3 mt-2">

                                        <label class="form-label" for="add_weight">Additional Weight<span class="req">*</span></label>

                                        <input type="text" class="form-control form-control-lg float" id="add_weight"

                                            name="add_weight" data-parsley-type="number" minlength="1" maxlength="3"

                                            placeholder="Enter Additional Weight">

                                    </div>

                                    <div class="col-md-3 mt-2">

                                        <label class="form-label" for="add_charges">Additional Charges<span class="req">*</span></label>

                                        <input type="text" class="form-control form-control-lg float" id="add_charges"

                                            name="add_charges" data-parsley-type="number" minlength="1" maxlength="4"

                                            placeholder="Enter Additional Charges">

                                    </div>

                                    <div class="col-md-3 mt-2">

                                        <label class="form-label" for="rto_charges">RTO Charges<span class="req">*</span></label>

                                        <input type="text" class="form-control form-control-lg float" id="rto_charges"

                                            name="rto_charges" data-parsley-type="number" minlength="1" value="0"

                                            maxlength="4" placeholder="Enter RTO Charges">

                                    </div>

                                    <div class="col-md-3 mt-2">

                                        <label class="form-label" for="add_rto_charges">Additional Charges (RTO)<span

                                                class="req">*</span></label>

                                        <input type="text" class="form-control form-control-lg float"

                                            id="add_rto_charges" name="add_rto_charges" data-parsley-type="number"

                                            minlength="1" maxlength="4"

                                            placeholder="Enter Additional Charges">

                                    </div>

                                    <div class="col-md-3 mt-4">
                                        <button type="button" data-count="1" data-type="tarrif"
                                            data-form_id="#tariff_details" class="float-right btn btn-orio btn-sm add_more_info"
                                            style="min-width: 10px !important">
                                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M1.5 10H18.5" stroke="#fff" stroke-width="2" stroke-linecap="round"></path>
                                                <path d="M10 18.5V1.5" stroke="#fff" stroke-width="2" stroke-linecap="round"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </form>

                            <table class="example2 display nowrap table table-hover mt-4" width="100%">

                                <thead class="thead">

                                    <tr>
                                        <th>SNO</th>
                                        <th>Service</th>
                                        <th>Origin Country</th>
                                        <th>Destination Country</th>
                                        <th>Region</th>
                                        <th>Start weight</th>
                                        <th>End weight</th>
                                        <th>Charges</th>
                                        <th>Additional weight</th>
                                        <th>Additional Charges</th>
                                        <th>RTO Charges</th>
                                        <th>Additional Charges (RTO)</th>
                                        <th>Action</th>
                                    </tr>

                                </thead>

                                <tbody id="tariff_display">
                                    <tr class="default-tarif text-center">
                                        <td colspan="15">No Tariff Found</td>
                                    </tr>
                                </tbody>
                            </table>

                            <form action="#" method="post" id="add_new_tariff">

                                <div id="tariff_hidden_feilds"></div>

                                <input type="hidden" name="customer_acno" value="{{ $payload->acno }}">

                            </form>

                        </div>

                        <div class="col-md-12 text-center mt-1">

                            <div class="d-flex justify-content-center w-100">

                                <button type="button" class="btn btn-sm btn-secondary-orio mr-3 my-3"

                                    data-dismiss="modal" aria-label="Close">Close</button>

                                <button type="button" data-form_id="#add_new_tariff"

                                    class="btn btn-sm btn-orio add_new_charge_btn my-3">Add Tariff</button>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>
    {{--  add_handling_modal --}}
    <div class="modal fade" id="add_handling_modal" role="dialog" aria-labelledby="editsucessModal"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="modal-title-default">Add Cash Handling Charges</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">

                            <form class="handling_charges" data-input_hidden="#handling_hidden_feilds"

                                data-display_table="#handling_display" action="#" data-parsley-validate

                                id="handling_charges" method="post">

                                <div class="row">

                                    <div class="col-md-3">

                                        <label class="form-label" for="" >

                                            Select Deduction Type</label>

                                        <select required

                                            class=" form-control form-select country_id form-control-lg input_field"

                                            data-toggle="select2" name="handling_deduction_type"

                                            size="1" label="Select Deduction Type"

                                            data-placeholder="Select Deduction Type" data-allow-clear="1">

                                            <option value="">Select Deduction Type</option>

                                            <option value="1">Flat</option>

                                            <option value="2">Percentage</option>

                                        </select>

                                    </div>

                                    <div class="col-md-3">

                                        <label for="min_amt">Minimum Amount<span class="req">*</span></label>

                                        <input type="text" data-parsley-type="integer"

                                            class="form-control form-control-lg" id="min_amt" name="min_amt"

                                            placeholder="Enter Minimum Amt" required="true">

                                    </div>

                                    <div class="col-md-3">

                                        <label for="max_amt">Maximum Amount<span class="req">*</span></label>

                                        <input type="text" data-parsley-type="number"

                                            class="form-control form-control-lg float" id="max_amt" name="max_amt"

                                            placeholder="Enter Maximum Amt" required="true" minlength="1"

                                            maxlength="6">

                                    </div>

                                    <div class="col-md-3">

                                        <label for="charges">Charges<span class="req">*</span></label>

                                        <input type="text" data-parsley-type="number"

                                            class="form-control form-control-lg float" id="handling_charges_amt"

                                            name="handling_charges" placeholder="Enter Charges" required="true"

                                            minlength="1" maxlength="6">

                                    </div>

                                    <div class="col-md-12 mt-4">

                                        <button type="button" data-type="handling" data-count="1"
                                            data-form_id="#handling_charges" class="float-right btn btn-orio btn-sm add_more_info"
                                            style="min-width: 10px !important">
                                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M1.5 10H18.5" stroke="#fff" stroke-width="2" stroke-linecap="round"></path>
                                                <path d="M10 18.5V1.5" stroke="#fff" stroke-width="2" stroke-linecap="round"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </form>
                            <table class="example2 display nowrap table table-hover mt-4" width="100%">
                                <thead class="thead">
                                    <tr>
                                        <th>SNO</th>
                                        <th>Deduction</th>
                                        <th>Minimum Amount</th>
                                        <th>Maximum Amount</th>
                                        <th>Charges</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody id="handling_display">
                                    <tr class="default-handling text-center">
                                        <td colspan="15">No Cash Handling Charges Found</td>
                                    </tr>
                                </tbody>

                            </table>

                            <form action="#" method="post" id="add_new_handling">
                                <div id="handling_hidden_feilds"></div>
                                <input type="hidden" name="customer_acno" value="{{ $payload->acno }}">
                            </form>
                        </div>
                        <div class="col-md-12 text-center mt-1">
                            <div class="d-flex justify-content-center w-100">
                                <button type="button" class="btn btn-sm btn-secondary-orio mr-3 my-3"
                                    data-dismiss="modal" aria-label="Close">Close</button>
                                <button type="button" data-form_id="#add_new_handling"
                                    class="btn btn-sm btn-orio add_new_charge_btn my-3">Add Cash Handling
                                    Charges</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{--  add_additional_modal --}}
    <div class="modal fade" id="add_additional_modal" role="dialog" aria-labelledby="editsucessModal"

        aria-hidden="true">

        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">

            <div class="modal-content">

                <div class="modal-header">

                    <h6 class="modal-title" id="modal-title-default">Add Additional Charges</h6>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                        <span aria-hidden="true">×</span>

                    </button>

                </div>

                <div class="modal-body">

                    <div class="row">

                        <div class="col-md-12">

                            <form class="additional_charges" data-input_hidden="#additional_hidden_feilds"

                                data-display_table="#additional_display" action="#" data-parsley-validate

                                id="additional_charges" method="post">

                                <div class="row">

                                    <div class="col-md-3">
                                        <label class="form-label" for="service" id="service_name">
                                            Select Service</label>

                                        <select required

                                            class="form-control form-select service form-control-lg input_field "

                                            id="service_name" data-toggle="select2" name="additional_service_name"

                                            size="1" label="Service" data-placeholder="Select Service"

                                            data-allow-clear="1">

                                            <option value="">Select Service</option>

                                            @foreach (session('services') as $service)

                                                @if (in_array($service->id, $selectedServiceIds))

                                                    <option value="{{ $service->id }}">

                                                        {{ $service->service_name }}</option>

                                                @endif

                                            @endforeach

                                        </select>

                                    </div>

                                    <div class="col-md-3">

                                        <label class="form-label" for=""></label>Select

                                            Charges</label>

                                        <select required class=" form-control form-select form-control-lg input_field "

                                            id="charges" data-toggle="select2" name="add_charges_type" size="2"

                                            label="Sales Person" data-placeholder="Select Charges" data-allow-clear="1">

                                            <option value="">Select Charges</option>

                                            <option value="1">GST</option>

                                            <option value="2">SST</option>

                                            <option value="3">Bank Charges</option>

                                        </select>

                                    </div>

                                    <div class="col-md-3">

                                        <label class="form-label" for="">

                                            Select Deduction Type</label>

                                        <select required

                                            class=" form-control form-select type_id form-control-lg input_field"

                                            data-toggle="select2" name="additionl_deduction_type"

                                            size="1" label="Select Deduction Type"

                                            data-placeholder="Select Deduction Type" data-allow-clear="1">

                                            <option value="">Select Deduction Type</option>

                                            <option value="1">Flat</option>

                                            <option value="2">Percentage</option>

                                        </select>

                                    </div>

                                    <div class="col-md-3">

                                        <label for="charges">Charges<span class="req">*</span></label>

                                        <input type="text" data-parsley-type="number"

                                            class="form-control form-control-lg" id="additional_amt"

                                            name="additional_amt" placeholder="Enter Charges" required="true">

                                    </div>

                                    <div class="col-md-12 mt-4">
                                        <button type="button" data-count="1" data-type="additional"
                                            data-form_id="#additional_charges" class="float-right btn btn-orio btn-sm add_more_info"
                                            style="min-width: 10px !important">
                                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M1.5 10H18.5" stroke="#fff" stroke-width="2" stroke-linecap="round"></path>
                                                <path d="M10 18.5V1.5" stroke="#fff" stroke-width="2" stroke-linecap="round"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </form>

                            <table class="example2 display nowrap table table-hover mt-4" width="100%">

                                <thead class="thead">

                                    <tr>

                                        <th>SNO</th>

                                        <th>SERVICE</th>

                                        <th>Deduction</th>

                                        <th>Additional</th>

                                        <th>Charges</th>

                                        <th>Action</th>

                                    </tr>

                                </thead>

                                <tbody id="additional_display">

                                    <tr class="default-additional text-center">

                                        <td colspan="15">No Additional Charges Found</td>

                                    </tr>

                                </tbody>

                            </table>

                            <form action="#" method="post" id="add_new_additional">

                                <div id="additional_hidden_feilds"></div>

                                <input type="hidden" name="customer_acno" value="{{ $payload->acno }}">

                            </form>

                        </div>

                        <div class="col-md-12 text-center mt-1">

                            <div class="d-flex justify-content-center w-100">

                                <button type="button" class="btn btn-sm btn-secondary-orio mr-2 my-3"

                                    data-dismiss="modal" aria-label="Close">Close</button>

                                <button type="button" data-form_id="#add_new_additional"

                                    class="btn btn-sm btn-orio add_new_charge_btn my-3">Add Additional

                                    Charges</button>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <div class="app-content">
        <div class="app-content--inner order-detail-wrapper">
            <div class="pb-4 text-center text-xl-left">
                <div class="row align-items-center">
                    <div class="col-xl-7">
                        <div>
                            <h5 class="title-text mb-1">{{ $title }}</h5>
                             <p class="sub-title-text mb-0">{{ $title }} below by filling the form</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- form updating customer details --}}

            <div class="catalogue-wrapper">

                <div class="row">

                    <div class="col-12">

                        <div class="card card-box mb-5">

                            <div class="card-header">

                                <div class="card-header--title">
                                    <b>{{ $title }}: {{ $payload->acno }}</b>
                                </div>

                            </div>

                            <div class="card-body">

                                <div class="no-gutters row">

                                    <div class="col-md-12">

                                        <form class="customer_form" action="#" data-parsley-validate
                                            id="customer_form" method="post" novalidate="" id="remove_data">
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label" for="name">Name<span class="req">*</span></label>
                                                    <input type="text" class="form-control form-control-lg"
                                                        id="name" name="name" placeholder="Enter Name"
                                                        value="{{ isset($payload->name) ? $payload->name : '' }}"
                                                        required="true">
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label" for="email">Email<span class="req">*</span></label>
                                                    <input type="email" class="form-control form-control-lg"
                                                        id="email" name="email" placeholder="Enter Email"
                                                        value="{{ isset($payload->email) ? $payload->email : '' }}"
                                                        required="true">
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label" for="phone">Phone<span class="req">*</span></label>
                                                    <input minlength="10" data-parsley-type="integer" maxlength="12"
                                                        type="tel" class="form-control form-control-lg number"
                                                        id="phone" name="phone" placeholder="Enter Phone"
                                                        value="{{ isset($payload->phone) ? $payload->phone : '' }}"
                                                        required="true">
                                                </div>
                                                <div class="mb-3 col-md-6">
                                                    <label class="form-label">Select Country<span class="req">*</span></label>
                                                    <select required
                                                        class=" form-control form-control-lg form-select country_id form-control form-control-lg-lg input_field "
                                                        id="country_id" data-toggle="select2" name="country_id"
                                                        size="1" label="Select Country"
                                                        data-placeholder="Select Country" data-allow-clear="1">
                                                        <option value="">Select Country</option>
                                                        @foreach ($countries as $country)
                                                            <option value="{{ $country->id }}"
                                                                {{ isset($payload->country_id) && $payload->country_id == $country->id ? 'selected' : '' }}>
                                                                {{ $country->country_name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="mb-3 col-md-6 ">
                                                    <label class="form-label" for="city_id">
                                                        Select City<span class="req">*</span>
                                                    </label>
                                                    <select required
                                                        class=" form-control form-select city_id form-control-lg input_field "
                                                        data-toggle="select2" name="city_id"
                                                        size="1" label="Select City" data-placeholder="Select city"
                                                        data-allow-clear="1">
                                                        <option value="">Select City</option>
                                                        @foreach ($cities as $city)
                                                            <option
                                                                {{ isset($payload->city_id) && $payload->city_id == $city->id ? 'selected' : '' }}
                                                                value="{{ $city->id }}">
                                                                {{ $city->city }} </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label" for="address">Address<span
                                                            class="req">*</span></label>
                                                    <input type="text" class="form-control form-control-lg"
                                                        id="address" name="address" placeholder="Enter Address"
                                                        value="{{ isset($payload->address) ? $payload->address : '' }}"
                                                        required="true">
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label  class="form-label" for="business_name">Business Name<span
                                                            class="req">*</span></label>
                                                    <input type="text" class="form-control form-control-lg"
                                                        id="business_name" name="business_name"
                                                        placeholder="Enter Business Name"
                                                        value="{{ isset($payload->business_name) ? $payload->business_name : '' }}"
                                                        required="true">
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label  class="form-label" for="business_address">Business
                                                        Address<span class="req">*</span></label>
                                                    <input type="text" class="form-control form-control-lg"
                                                        id="business_address" name="business_address"
                                                        placeholder="Enter Business Address"
                                                        value="{{ isset($payload->business_address) ? $payload->business_address : '' }}"
                                                        required="true">
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label" for="cnic">CNIC<span class="req">*</span></label>
                                                    <input type="integer" data-parsley-type="integer" minlength="13"
                                                        maxlength="13" class="form-control form-control-lg number"
                                                        id="cnic" name="cnic" placeholder="Enter CNIC"
                                                        value="{{ isset($payload->cnic) ? $payload->cnic : '' }}"
                                                        required="true">
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label" for="ntn">NTN<span class="req"></span></label>
                                                    <input type="integer" minlength="4" maxlength="13"
                                                        class="form-control form-control-lg number" id="ntn"
                                                        name="ntn" placeholder="Enter NTN" class="ntnNumber"
                                                        value="{{ isset($payload->ntn) ? $payload->ntn : '' }}">
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label" for="other_name">Other Name</label>
                                                    <input type="text" class="form-control form-control-lg"
                                                        id="other_name" name="other_name" placeholder="Enter Other Name"
                                                        value="{{ isset($payload->other_name) ? $payload->other_name : '' }}">
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Other Phone</label>
                                                    <input type="tel" minlength="11" maxlength="13"
                                                        data-parsley-type="integer"
                                                        class="form-control form-control-lg number" id="other_phone"
                                                        name="other_phone" placeholder="Enter Other Phone"
                                                        value="{{ isset($payload->other_phone) ? $payload->other_phone : '' }}">
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label" for="bank" id="bank">
                                                        Select Bank<span class="req"></span></label>
                                                    <select required
                                                        class="form-control form-select service form-control-lg input_field "
                                                        id="bank" data-toggle="select2" name="bank"
                                                        size="1" label="bank" data-placeholder="Select bank"
                                                        data-allow-clear="1">
                                                        <option value="">Select Bank</option>
                                                        @foreach (session('banks') as $bank)
                                                            <option
                                                                {{ isset($payload->bank) && $payload->bank == $bank->id ? 'selected' : '' }}
                                                                value="{{ $bank->id }}">
                                                                {{ $bank->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label  class="form-label" for="account_number">Account Title<span
                                                            class="req">*</span></label>
                                                    <input type="text" class="form-control form-control-lg"
                                                        id="account_title" name="account_title"
                                                        placeholder="Enter Account Title"
                                                        value="{{ isset($payload->account_title) ? $payload->account_title : '' }}"
                                                        required="true">
                                                </div>

                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Account Number<span
                                                            class="req">*</span></label>
                                                    <input class="form-control form-control-lg"
                                                        id="account_number" name="account_number"
                                                        minlength="5" maxlength="35"
                                                        placeholder="Enter Account Number"
                                                        value="{{ isset($payload->account_number) ? $payload->account_number : '' }}"
                                                        required="true">
                                                </div>

                                                <div class="mb-3 col-md-6">
                                                    <label class="form-label">
                                                        Select Sales Person
                                                    <span
                                                            class="req">*</span>
                                                    </label>
                                                    <select required
                                                        class=" form-control form-select form-control-lg input_field "
                                                        data-toggle="select2" name="sales_person_id"
                                                        size="1" label="Sales Person"
                                                        data-placeholder="Select Sales Person" data-allow-clear="1">
                                                        <option value="">Select Sales Person
                                                        </option>
                                                        @foreach ($salespersons as $salesperson)
                                                            <option value="{{ $salesperson->id }}"
                                                                {{ isset($payload->sales_person) && $salesperson->id == $payload->sales_person ? 'selected' : '' }}>
                                                                {{ $salesperson->first_name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label" for="service" id="service_name">
                                                        Assign Service
                                                    <span
                                                            class="req">*</span>
                                                    </label>
                                                    <select required
                                                        class="form-control form-select service form-control-lg input_field "
                                                        id="services_ids" multiple data-toggle="select2"
                                                        name="service_assigned[]" size="1" label="Service"
                                                        data-placeholder="Select Service" data-allow-clear="1">
                                                        <option value="">Select Service
                                                        </option>
                                                        @foreach (session('services') as $service)

                                                            <option data-service-code="{{ $service->service_code }}"

                                                                value="{{ $service->id }}"

                                                                {{ in_array($service->id, $selectedServiceIds) ? 'selected' : '' }}>

                                                                {{ $service->service_name }}

                                                            </option>

                                                        @endforeach

                                                    </select>

                                                </div>

                                                <div class="col-md-6 mb-3">

                                                    <label class="form-label" for="user_name">User Name<span class="req">*</span></label>

                                                    <input type="string" class="form-control form-control-lg"

                                                        id="user_name" name="user_name" placeholder="Enter User Name"

                                                        value="{{ isset($payload->user_name) ? $payload->user_name : '' }}"

                                                        required="true">

                                                    <input type="hidden" name="user_name_old"

                                                        value="{{ isset($payload->user_name) ? $payload->user_name : '' }}">

                                                </div>

                                                <div class="col-md-6 mb-3">
                                                    <div class="d-flex justify-content-between">
                                                        <label class="form-label">Password<span
                                                                class="req">*</span></label>
                                                        <label data-toggle="tooltip" title="Click to generate password"
                                                            class="gen-pass mb-0">Generate password</label>
                                                    </div>

                                                    <input type="password" minlength="6" maxlength="16"

                                                        class="form-control form-control-lg passwordField" id="password"

                                                        name="password" placeholder="Enter Password" value=""

                                                        {{ isset($type) && $type == 'edit' ? '' : 'required="true"' }}>

                                                    <span class="show_pass_btn" style="right: 33px !important;"><i

                                                            class="fa-regular fa-eye"></i></span>

                                                </div>

                                                <div class="col-md-6 mb-3">

                                                    <label class="form-label" for="password">Confirm Password<span
                                                            class="req">*</span></label>
                                                    <input type="password" minlength="6" ata-parsley-equalto="#password"

                                                        maxlength="16" class="form-control form-control-lg passwordField"

                                                        id="confirm_password" name="password"

                                                        placeholder="Confirm Password" value=""

                                                        {{ isset($type) && $type == 'edit' ? '' : 'required="true"' }}>

                                                    <span class="show_pass_btn" style="right: 33px !important;"><i

                                                            class="fa-regular fa-eye"></i></span>

                                                </div>


                                            </div>

                                            <div class="col-md-12 mb-3 mt-2 text-right">
                                                <button type="button" class="btn btn-orio ml-auto" id="addCustomer">Save</button>
                                            </div>
                                        </form>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

            {{-- for updating tariff --}}

            <div class="catalogue-wrapper">

                <div class="row">

                    <div class="col-12">

                        <div class="card card-box mb-5">

                            <div class="card-header">

                                <div class="card-header--title">

                                    <b>Current Tariffs</b>

                                </div>

                            </div>

                            <div class="card-body">

                                <div class="no-gutters row">

                                    <div class="col-md-12">

                                        <button class="btn btn-secondary-orio" data-toggle="modal"

                                            data-target="#add_tariff_modal">Add Tariff</button>

                                        <button data-check_id="check_box"

                                            class="btn btn-secondary-orio d-none float-right mb-3 update_charges_btn"

                                            id="update_tariff">Update Tariff</button>

                                        <div style="overflow-x: scroll;width: 100%;">

                                            <table class="example2 display nowrap table table-hover mt-4" width="100%">

                                                <thead class="thead">

                                                    <tr>
                                                        <th>SNO</th>
                                                        <th colspan="4">Service</th>
                                                        <th>Origin Country</th>
                                                        <th>Destination Country</th>
                                                        <th colspan="4">Region</th>
                                                        <th colspan="1">Start weight</th>
                                                        <th>End weight</th>
                                                        <th>Charges</th>
                                                        <th>Additional weight</th>
                                                        <th>Additional charges</th>
                                                        <th>RTO charges</th>
                                                        <th>Additional Charges (RTO)</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if (count($charges->tarifs) > 0)
                                                        <form action="#" id="update_tarif_form" method="post">
                                                            @foreach ($charges->tarifs as $key => $tarif)
                                                                <tr>
                                                                    <td class="d-flex align-items-center justify-content-center">
                                                                        <div class="custom-control custom-checkbox my-3">
                                                                            <input type="checkbox"
                                                                                class="custom-control-input check_box"
                                                                                data-btn_id="#update_tariff"
                                                                                name="checked_id[]"
                                                                                value="{{ $tarif->id }}"
                                                                                id="addiCheck{{ $loop->iteration }}"
                                                                                data-form="update_tarif_form_{{ $loop->iteration }}">
                                                                            <label class="custom-control-label"
                                                                                for="addiCheck{{ $loop->iteration }}"></label>
                                                                        </div>
                                                                        {{ $loop->iteration }}
                                                                    </td>
                                                                    <td colspan="4">

                                                                        <select required

                                                                            class="form-control form-select service_name form-control-lg input_field "

                                                                            id="service_name{{ $loop->iteration }}"

                                                                            data-toggle="select2" name="service_name[]"

                                                                            size="1" label="Service"

                                                                            data-placeholder="Select Service"

                                                                            data-allow-clear="1">

                                                                            <option value="">

                                                                                Select

                                                                                Service

                                                                            </option>

                                                                            @foreach (session('services') as $service)

                                                                                @if (in_array($service->id, $selectedServiceIds))

                                                                                    <option value="{{ $service->id }}"

                                                                                        {{ $tarif->service_id == $service->id ? 'selected' : '' }}>

                                                                                        {{ $service->service_name }}

                                                                                    </option>

                                                                                @endif

                                                                            @endforeach

                                                                        </select>

                                                                    </td>

                                                                    <td>

                                                                        <select required

                                                                            class="form-control form-control-lg form-select origin_country form-control form-control-lg-lg input_field "

                                                                            id="origin_country{{ $loop->iteration }}"

                                                                            data-toggle="select2" name="origin_country[]"

                                                                            size="1" label="Origin Country"

                                                                            data-placeholder="Origin Country"

                                                                            data-allow-clear="1">

                                                                            <option value="">

                                                                                Origin

                                                                                Country

                                                                            </option>

                                                                            @foreach ($countries as $country)

                                                                                <option value="{{ $country->id }}"

                                                                                    {{ $tarif->origin_country == $country->id ? 'selected' : '' }}>

                                                                                    {{ $country->country_name }}

                                                                                </option>

                                                                            @endforeach

                                                                        </select>

                                                                    </td>

                                                                    <td>

                                                                        <select required

                                                                            class="form-control form-control-lg form-select destination_country form-control form-control-lg-lg input_field "

                                                                            id="destination_country{{ $loop->iteration }}"

                                                                            data-toggle="select2"

                                                                            name="destination_country[]" size="1"

                                                                            label="Destination Country"

                                                                            data-placeholder="Destination Country"

                                                                            data-allow-clear="1">

                                                                            <option value="">

                                                                                Destination

                                                                                Country

                                                                            </option>

                                                                            @foreach ($countries as $country)

                                                                                <option value="{{ $country->id }}"

                                                                                    {{ $tarif->destination_country == $country->id ? 'selected' : '' }}>

                                                                                    {{ $country->country_name }}

                                                                                </option>

                                                                            @endforeach

                                                                        </select>

                                                                    </td>

                                                                    <td colspan="4">

                                                                        <select style="width: 100px;" required

                                                                            class="form-control form-select region form-control-lg input_field "

                                                                            id="region_type{{ $loop->iteration }}"

                                                                            data-toggle="select2" name="region_type[]"

                                                                            size="1" label="Region"

                                                                            data-placeholder="Select Region"

                                                                            data-allow-clear="1">

                                                                            <option value="">

                                                                                Select

                                                                                Region

                                                                            </option>

                                                                            <option

                                                                                {{ $tarif->region == 'T-1' ? 'selected' : '' }}

                                                                                value="T-1">

                                                                                Tier-1

                                                                            </option>

                                                                            <option

                                                                                {{ $tarif->region == 'T-2' ? 'selected' : '' }}

                                                                                value="T-2">

                                                                                Tier-2

                                                                            </option>

                                                                            <option

                                                                                {{ $tarif->region == 'T-3' ? 'selected' : '' }}

                                                                                value="T-3">

                                                                                Tier-3

                                                                            </option>

                                                                            <option

                                                                                {{ $tarif->region == 'DEF' ? 'selected' : '' }}

                                                                                value="DEF">

                                                                                Default

                                                                            </option>

                                                                        </select>

                                                                    </td>

                                                                    <td>

                                                                        <input style="width: 100px;" type="text"

                                                                            class="form-control float" minlength="1"

                                                                            maxlength="4" name="start_weight[]"

                                                                            value="{{ $tarif->start_weight }}" required>

                                                                    </td>

                                                                    <td>

                                                                        <input style="width: 100px;" type="text"

                                                                            class="form-control float" minlength="1"

                                                                            maxlength="4" name="end_weight[]"

                                                                            value="{{ $tarif->end_weight }}" required>

                                                                    </td>

                                                                    <td>

                                                                        <input style="width: 100px;" type="text"

                                                                            class="form-control float" minlength="1"

                                                                            maxlength="4" name="charges[]"

                                                                            value="{{ $tarif->charges }}" required>

                                                                        <input type="hidden" name="id[]"

                                                                            value="{{ $tarif->id }}">

                                                                    </td>

                                                                    <td>

                                                                        <input style="width: 100px;" type="text"

                                                                            class="form-control float" minlength="1"

                                                                            maxlength="4" name="add_weight[]"

                                                                            value="{{ $tarif->additional_weight }}"

                                                                            required>

                                                                    </td>

                                                                    <td>

                                                                        <input style="width: 100px;" type="text"

                                                                            class="form-control w-10 float" minlength="1"

                                                                            maxlength="4" name="add_charges[]"

                                                                            value="{{ $tarif->additional_charges }}"

                                                                            required>

                                                                    </td>

                                                                    <td>

                                                                        <input style="width: 100px;" type="text"

                                                                            class="form-control w-10 float" minlength="1"

                                                                            maxlength="4" name="rto_charges[]"

                                                                            value="{{ $tarif->rto_charges }}" required>

                                                                    </td>

                                                                    <td>

                                                                        <input style="width: 100px;" type="text"

                                                                            class="form-control w-10 float" minlength="1"

                                                                            maxlength="4" name="add_rto_charges[]"

                                                                            value="{{ $tarif->additional_rto_charges }}" required>

                                                                    </td>
                                                                    <td>
                                                                        <button type="button"
                                                                            class="btn p-2 btn-sm delete"
                                                                            table="customer_tariffs"
                                                                            style="min-width: 10px !important"
                                                                            data-id="{{ $tarif->id }}">
                                                                                <svg width="20" height="20" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg"> <path d="M9 8.5V17" stroke="#525252" stroke-width="2" stroke-linecap="round"></path> <path d="M13 8.5V17" stroke="#525252" stroke-width="2" stroke-linecap="round"></path> <path d="M2.75 4.5L3.89495 19.6133C3.95421 20.3955 4.60619 21 5.39066 21H16.6093C17.3938 21 18.0458 20.3955 18.1051 19.6133L19.25 4.5" stroke="#525252" stroke-width="2"></path> <path d="M1 4.5H21" stroke="#525252" stroke-width="2" stroke-linecap="round"></path> <path d="M7.5 4.5L8.22075 2.81824C8.69349 1.71519 9.7781 1 10.9782 1H11.0218C12.2219 1 13.3065 1.71519 13.7792 2.81824L14.5 4.5" stroke="#525252" stroke-width="2" stroke-linejoin="round"></path> </svg>    
                                                                        </button>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </form>

                                                    @else
                                                        <tr class="text-center">
                                                            <td colspan="15">
                                                                <p>No Records Found</p>
                                                            </td>
                                                        </tr>
                                                    @endif

                                                </tbody>

                                            </table>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

            {{-- for updating cash handling --}}

            <div class="catalogue-wrapper">

                <div class="row">

                    <div class="col-12">

                        <div class="card card-box mb-5">

                            <div class="card-header">

                                <div class="card-header--title">

                                    <b>Current Cash Handling Charges</b>

                                </div>

                            </div>

                            <div class="card-body">

                                <div class="no-gutters row">

                                    <div class="col-md-12">

                                        <button class="btn btn-secondary-orio" data-toggle="modal"

                                            data-target="#add_handling_modal">Add Cash Handling

                                            Charges</button>

                                        <button data-check_id="check_box"
                                            class="btn btn-secondary-orio d-none float-right mb-3 update_charges_btn"
                                            id="update_handling_charges">Update Charges</button>
                                        <table class="example2 display nowrap table table-hover mt-4" width="100%">
                                            <thead class="thead">
                                                <tr>
                                                    <th>SNO</th>
                                                    <th>Deduction</th>
                                                    <th>Minimum Amount</th>
                                                    <th>Maximum Amount</th>
                                                    <th>Charges</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                @if (count($charges->cash_handling) > 0)

                                                    <form action="#" id="update_tarif_form" method="post">

                                                        @foreach ($charges->cash_handling as $key => $cash_handling)

                                                            <tr>
                                                                <td class="d-flex align-items-center justify-content-center">
                                                                    <div class="custom-control custom-checkbox my-3">
                                                                        <input type="checkbox"
                                                                            class="custom-control-input check_box"
                                                                            data-btn_id="#update_handling_charges"
                                                                            name="checked_id[]"
                                                                            value="{{ $cash_handling->id }}"
                                                                            id="handlingCheck{{ $loop->iteration }}"
                                                                            data-form="update_tarif_form_{{ $loop->iteration }}">
                                                                        <label class="custom-control-label"
                                                                            for="handlingCheck{{ $loop->iteration }}"></label>
                                                                    </div>
                                                                    {{ $loop->iteration }}
                                                                </td>

                                                                <td>

                                                                    <select required

                                                                        class="form-control form-select service form-control-lg input_field "

                                                                        id="handling_deduction_type_2{{ $loop->iteration }}"

                                                                        data-toggle="select2"

                                                                        name="handling_deduction_type[]" size="1"

                                                                        label="Deduction Type"

                                                                        data-placeholder="Select Deduction Type"

                                                                        data-allow-clear="1">

                                                                        <option value="">

                                                                            Select

                                                                            Deduction

                                                                            Type

                                                                        </option>

                                                                        <option

                                                                            {{ $cash_handling->charges_type == '1' ? 'selected' : '' }}

                                                                            value="1">Flat

                                                                        </option>

                                                                        <option

                                                                            {{ $cash_handling->charges_type == '2' ? 'selected' : '' }}

                                                                            value="2">

                                                                            Percentage

                                                                        </option>

                                                                    </select>

                                                                </td>

                                                                <td colspan="1">

                                                                    <input type="text" class="form-control float"

                                                                        minlength="1" maxlength="6" name="min_amt[]"

                                                                        value="{{ $cash_handling->min_amt }}" required>

                                                                </td>

                                                                <td>

                                                                    <input type="text" class="form-control float"

                                                                        minlength="1" maxlength="6" name="max_amt[]"

                                                                        value="{{ $cash_handling->max_amt }}" required>

                                                                </td>

                                                                <td>

                                                                    <input type="text" class="form-control float"

                                                                        minlength="1" maxlength="5"

                                                                        name="handling_charges[]"

                                                                        value="{{ $cash_handling->handling_charges }}"

                                                                        required>

                                                                </td>

                                                                <td>
                                                                    <button type="button"
                                                                        class="btn p-2 btn-sm delete"
                                                                        table="customer_cash_handling_charges"
                                                                        style="min-width: 10px !important"
                                                                        data-id="{{ $cash_handling->id }}">
                                                                        <svg width="20" height="20" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg"> <path d="M9 8.5V17" stroke="#525252" stroke-width="2" stroke-linecap="round"></path> <path d="M13 8.5V17" stroke="#525252" stroke-width="2" stroke-linecap="round"></path> <path d="M2.75 4.5L3.89495 19.6133C3.95421 20.3955 4.60619 21 5.39066 21H16.6093C17.3938 21 18.0458 20.3955 18.1051 19.6133L19.25 4.5" stroke="#525252" stroke-width="2"></path> <path d="M1 4.5H21" stroke="#525252" stroke-width="2" stroke-linecap="round"></path> <path d="M7.5 4.5L8.22075 2.81824C8.69349 1.71519 9.7781 1 10.9782 1H11.0218C12.2219 1 13.3065 1.71519 13.7792 2.81824L14.5 4.5" stroke="#525252" stroke-width="2" stroke-linejoin="round"></path> </svg> 
                                                                    </button>
                                                                </td>
                                                            </tr>
                                                        @endforeach

                                                    </form>

                                                @else
                                                        <tr class="text-center">
                                                            <td colspan="15">
                                                                <p>No Records Found</p>
                                                            </td>
                                                        </tr>
                                                @endif

                                            </tbody>

                                        </table>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

            {{-- for updating additional --}}

            <div class="catalogue-wrapper">

                <div class="row">

                    <div class="col-12">

                        <div class="card card-box mb-5">

                            <div class="card-header">

                                <div class="card-header--title">

                                    <b>Current Additional Charges</b>

                                </div>

                            </div>

                            <div class="card-body">

                                <div class="no-gutters row">

                                    <div class="col-md-12">

                                        <button class="btn btn-secondary-orio" data-toggle="modal"

                                            data-target="#add_additional_modal">Add Additional

                                            Charges</button>

                                        <button data-check_id="check_box"

                                            class="btn btn-secondary-orio d-none float-right mb-3 update_charges_btn"

                                            id="update_additional_charges">Update Charges</button>

                                        <table class="example2 display nowrap table table-hover mt-4" width="100%">
                                            <thead class="thead">
                                                <tr>
                                                    <th>SNO</th>
                                                    <th>SERVICE</th>
                                                    <th>Deduction</th>
                                                    <th>Additional</th>
                                                    <th>Charges</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                @if (count($charges->additional_charges) > 0)

                                                    <form action="#" id="update_tarif_form" method="post"

                                                        data-parsley-validate>

                                                        @foreach ($charges->additional_charges as $key => $additional)

                                                            <tr>
                                                                <td class="d-flex align-items-center justify-content-center">
                                                                    <div class="custom-control custom-checkbox my-3">
                                                                        <input type="checkbox"
                                                                            data-btn_id="#update_additional_charges"
                                                                            class="custom-control-input check_box"
                                                                            name="add_checked_id[]"
                                                                            value="{{ $additional->id }}"
                                                                            id="addCheck{{ $loop->iteration }}"
                                                                            data-form="update_tarif_form_{{ $loop->iteration }}">
                                                                        <label class="custom-control-label"
                                                                            for="addCheck{{ $loop->iteration }}"></label>
                                                                    </div>
                                                                    {{ $loop->iteration }}
                                                                </td>

                                                                <td>

                                                                    <select required

                                                                        class="form-control form-select service_name service form-control-lg input_field "

                                                                        id="service_name_3{{ $loop->iteration }}"

                                                                        data-toggle="select2" name="service_name[]"

                                                                        size="1" label="Service"

                                                                        data-placeholder="Select Service"

                                                                        data-allow-clear="1">

                                                                        <option value="">

                                                                            Select

                                                                            Service

                                                                        </option>

                                                                        @foreach (session('services') as $service)

                                                                            @if (in_array($service->id, $selectedServiceIds))

                                                                                <option value="{{ $service->id }}"

                                                                                    {{ $additional->service_id == $service->id ? 'selected' : '' }}>

                                                                                    {{ $service->service_name }}

                                                                                </option>

                                                                            @endif

                                                                        @endforeach

                                                                    </select>

                                                                </td>

                                                                <td>

                                                                    <select required

                                                                        class="form-control form-select service form-control-lg input_field "

                                                                        id="additionl_deduction_type_2{{ $loop->iteration }}"

                                                                        data-toggle="select2"

                                                                        name="additionl_deduction_type[]" size="1"

                                                                        label="Deduction Type"

                                                                        data-placeholder="Select Deduction Type"

                                                                        data-allow-clear="1">

                                                                        <option value="">

                                                                            Select

                                                                            Deduction

                                                                            Type

                                                                        </option>

                                                                        <option

                                                                            {{ $additional->deduction_type == '1' ? 'selected' : '' }}

                                                                            value="1">Flat

                                                                        </option>

                                                                        <option

                                                                            {{ $additional->deduction_type == '2' ? 'selected' : '' }}

                                                                            value="2">

                                                                            Percentage

                                                                        </option>

                                                                    </select>

                                                                </td>

                                                                <td class="">

                                                                    <select required

                                                                        class=" form-control form-select country_id form-control-lg input_field "

                                                                        data-toggle="select2"

                                                                        name="add_charges[]" size="1"

                                                                        label="Sales Person"

                                                                        data-placeholder="Select Charges"

                                                                        data-allow-clear="1">

                                                                        <option value="">

                                                                            Select

                                                                            Charges

                                                                        </option>

                                                                        <option

                                                                            {{ $additional->charges_type == 1 ? 'selected' : '' }}

                                                                            value="1">GST

                                                                        </option>

                                                                        <option

                                                                            {{ $additional->charges_type == 2 ? 'selected' : '' }}

                                                                            value="2">SST

                                                                        </option>

                                                                        <option

                                                                            {{ $additional->charges_type == 3 ? 'selected' : '' }}

                                                                            value="3">Bank

                                                                            Charges

                                                                        </option>

                                                                    </select>

                                                                </td>

                                                                <td>

                                                                    <input type="text" class="form-control float"

                                                                        minlength="1" maxlength="4"

                                                                        data-parsley-type="number" name="charges_amt[]"

                                                                        value="{{ $additional->charges_amt }}" required>

                                                                </td>

                                                                <td>
                                                                    <button type="button"
                                                                        class="btn p-2 btn-sm delete"
                                                                        table="customer_additional_charges"
                                                                        style="min-width: 10px !important"
                                                                        data-id="{{ $additional->id }}">
                                                                        <svg width="20" height="20" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg"> <path d="M9 8.5V17" stroke="#525252" stroke-width="2" stroke-linecap="round"></path> <path d="M13 8.5V17" stroke="#525252" stroke-width="2" stroke-linecap="round"></path> <path d="M2.75 4.5L3.89495 19.6133C3.95421 20.3955 4.60619 21 5.39066 21H16.6093C17.3938 21 18.0458 20.3955 18.1051 19.6133L19.25 4.5" stroke="#525252" stroke-width="2"></path> <path d="M1 4.5H21" stroke="#525252" stroke-width="2" stroke-linecap="round"></path> <path d="M7.5 4.5L8.22075 2.81824C8.69349 1.71519 9.7781 1 10.9782 1H11.0218C12.2219 1 13.3065 1.71519 13.7792 2.81824L14.5 4.5" stroke="#525252" stroke-width="2" stroke-linejoin="round"></path> </svg>                                                             
                                                                    </button>
                                                                </td>
                                                            </tr>

                                                        @endforeach

                                                    </form>

                                                @else
                                                        <tr class="text-center">
                                                            <td colspan="15">
                                                                <p>No Records Found</p>
                                                            </td>
                                                        </tr>
                                                @endif

                                            </tbody>

                                        </table>

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
        var listRoute = "";
    </script>

    @if ($type == 'edit')
        <script>
            var id = {{ isset($payload->id) ? $payload->id : '' }};
            var customer_acno = "{{ isset($payload->acno) ? $payload->acno : '' }}";
            var storeUrl = "{{ route('customer.add_edit_customer', ['id' => ':id']) }}".replace(':id', id);
        </script>
    @endif

@section('scripts')
    <script src="{{ asset('assets/js/customers/customers.js') }}"></script>
    <script src="{{ asset('assets/js/customers/charges.js') }}"></script>
@endsection
@endsection

