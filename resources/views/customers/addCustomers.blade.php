@extends('layout.main')
@section('content')
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
            <div class="catalogue-wrapper">
                <div class="row">
                    <div class="col-12">
                        <div class="card card-box mb-5">
                            <div class="card-header">
                                <div class="card-header--title">
                                    <b>{{ $title }}:</b>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="no-gutters row">
                                    <div class="col-md-12">
                                        <form class="customer_form" action="#" data-parsley-validate id="customer_form"
                                            method="post" novalidate="" id="remove_data">
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
                                                    <label class="form-label" for="" >Select
                                                        Country<span class="req">*</span></label>
                                                    <select required
                                                        class=" form-control form-control-lg form-select country_id form-control form-control-lg-lg input_field "
                                                        id="country_id" data-toggle="select2" name="country_id"
                                                        size="1" label="Select Country"
                                                        data-placeholder="Select Country" data-allow-clear="1">
                                                        <option value="">Select Country</option>
                                                        @foreach ($countries as $country)
                                                            <option value="{{ $country->id }}">
                                                                {{ $country->country_name }} </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="mb-3 col-md-6">
                                                    <label class="form-label" for="city_id" >
                                                        Select City<span class="req">*</span></label>
                                                    <select required
                                                        class=" form-control form-select city_id form-control-lg input_field "
                                                         data-toggle="select2" name="city_id" size="1"
                                                        label="Select City" data-placeholder="Select city"
                                                        data-allow-clear="1">
                                                        <option value="">Select City</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label" for="address">Address<span class="req">*</span></label>
                                                    <input type="text" class="form-control form-control-lg"
                                                        id="address" name="address" placeholder="Enter Address"
                                                        value="{{ isset($payload->address) ? $payload->address : '' }}"
                                                        required="true">
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label" for="business_name">Business Name<span
                                                            class="req">*</span></label>
                                                    <input type="text" class="form-control form-control-lg"
                                                        id="business_name" name="business_name"
                                                        placeholder="Enter Business Name"
                                                        value="{{ isset($payload->business_name) ? $payload->business_name : '' }}"
                                                        required="true">
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label" for="business_address">Business Address<span
                                                            class="req">*</span></label>
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
                                                    <input type="text"
                                                        class="form-control form-control-lg" id="ntn"
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
                                                    <label class="form-label" for="other_phone">Other Phone</label>
                                                    <input type="tel" minlength="10" maxlength="12"
                                                        data-parsley-type="integer"
                                                        class="form-control form-control-lg number" id="other_phone"
                                                        name="other_phone" placeholder="Enter Other Phone"
                                                        value="{{ isset($payload->other_phone) ? $payload->other_phone : '' }}">
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label" for="bank" id="bank">Bank<span class="req"></span></label>
                                                    <select required
                                                        class="form-select service form-control form-control-lg-lg input_field "
                                                        id="bank" data-toggle="select2" name="bank"
                                                        size="1" label="bank" data-placeholder="Select bank"
                                                        data-allow-clear="1">
                                                        <option value="">Select Bank</option>
                                                        @foreach (session('banks') as $bank)
                                                            <option value="{{ $bank->id }}">
                                                                {{ $bank->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label" for="account_title">Account Title<span
                                                            class="req">*</span></label>
                                                    <input type="text" class="form-control form-control-lg"
                                                        id="account_title" name="account_title" minlength="2"
                                                        maxlength="25" placeholder="Enter Account Title"
                                                        value="{{ isset($payload->account_title) ? $payload->account_title : '' }}"
                                                        required="true">
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label" for="account_number">Account Number<span
                                                            class="req">*</span></label>
                                                    <input type="text" class="form-control form-control-lg"
                                                        id="account_number" name="account_number" minlength="5"
                                                        maxlength="35" placeholder="Enter Account Number"
                                                        value="{{ isset($payload->account_number) ? $payload->account_number : '' }}"
                                                        required="true">
                                                </div>
                                                @if (session('type') == '3')
                                                    <input type="hidden" name="sales_person_id"
                                                        value="{{ session('employee_id') }}">
                                                @endif
                                                @if (session('type') != '3')
                                                    <div class="mb-3 col-md-6">
                                                        <label class="form-label" for="sales_person_id" >
                                                            Sales Person<span
                                                            class="req">*</span></label>
                                                        <select required
                                                            class="form-control form-select form-control-lg input_field "
                                                            id="sales_person_id" data-toggle="select2" name="sales_person_id"
                                                            size="1" label="Sales Person"
                                                            data-placeholder="Select Sales Person" data-allow-clear="1">
                                                            <option value="">Select Sales Person</option>
                                                            @foreach ($salespersons as $salesperson)
                                                                <option value="{{ $salesperson->id }}"
                                                                    {{ isset($payload->sales_person) && $salesperson->id == $payload->sales_person ? 'selected' : '' }}>
                                                                    {{ $salesperson->first_name }} </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                @endif
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label" for="services_ids">Assign Service<span
                                                        class="req">*</span></label>
                                                    <select required
                                                        class="form-control form-select service form-control-lg input_field "
                                                        id="services_ids" multiple data-toggle="select2"
                                                        name="service_assigned[]" size="1" label="Service"
                                                        data-placeholder="Select Service" data-allow-clear="1">
                                                        <option value="">Select Service</option>
                                                        @foreach (session('services') as $service)
                                                            @if (!in_array($service->id,['5','6']))
                                                                <option data-service-code="{{ $service->service_code }}"
                                                                    value="{{ $service->id }}">
                                                                    {{ $service->service_name }}</option>                                                                
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label for="user_name">User Name<span class="req">*</span></label>
                                                    <input type="string" minlength="4" maxlength="25"
                                                        class="form-control form-control-lg" id="user_name"
                                                        name="user_name" placeholder="Enter User Name"
                                                        value="{{ isset($payload->user_name) ? $payload->user_name : '' }}"
                                                        required="true">
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <div class="d-flex justify-content-between">
                                                        <label for="inputEmail4">Password<span class="req">*</span></label>
                                                        <label data-toggle="tooltip" title="Click to generate password" class="gen-pass mb-0">Generate password</label>
                                                    </div>
                                                    <input type="password" minlength="6" maxlength="16"
                                                        class="form-control form-control-lg passwordField" id="password"
                                                        name="password" placeholder="Enter Password" value=""
                                                        {{ isset($type) && $type == 'edit' ? '' : 'required="true"' }}>
                                                    <span class="show_pass_btn" style="right: 33px !important;"><i
                                                            class="fa-regular fa-eye"></i></span>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label for="password">Confirm Password<span
                                                            class="req">*</span></label>
                                                    <input type="password" minlength="6" data-parsley-equalto="#password"
                                                        maxlength="16" class="form-control form-control-lg passwordField"
                                                        id="confirm_password" name="password"
                                                        placeholder="Confirm Password" value=""
                                                        {{ isset($type) && $type == 'edit' ? '' : 'required="true"' }}>
                                                    <span class="show_pass_btn" style="right: 33px !important;"><i
                                                            class="fa-regular fa-eye"></i></span>
                                                </div>
                                            </div>
                                            <div class="d-none" id="tariff_hidden_feilds"></div>
                                            <div class="d-none" id="handling_hidden_feilds"></div>
                                            <div class="d-none" id="additional_hidden_feilds"></div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- For Tarif Working --}}
            <div class="cataloge-wrapper">
                <div class="row">
                    <div class="col-12">
                        <div class="card card-box mb-5">
                            <div class="card-header">
                                <b>Add Tariff</b>
                            </div>
                            <div class="card-body">
                                <div class="no-gutters row">
                                    <div class="col-md-12" id="service_tarif">
                                        <form class="tariff_details" data-input_hidden="#tariff_hidden_feilds"
                                            data-display_table="#tariff_display" action="#" data-parsley-validate
                                            id="tariff_details" method="post">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <label class="form-label" for="service_name" id="service_name">
                                                        Select Service</label>
                                                    <select required
                                                        class="form-control form-select service_name form-control-lg input_field "
                                                        id="service_name" data-toggle="select2" name="service_name"
                                                        size="1" label="Service" data-placeholder="Select Service"
                                                        data-allow-clear="1">
                                                        <option value="">Select Service</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="form-label" for="origin_country" >Origin
                                                        Country</label>
                                                    <select required
                                                        class="form-control form-control-lg form-select origin_country form-control form-control-lg-lg input_field "
                                                        id="origin_country" data-toggle="select2" name="origin_country"
                                                        size="1" label="Origin Country"
                                                        data-placeholder="Origin Country" data-allow-clear="1">
                                                        <option value="">Origin Country</option>
                                                        @foreach ($countries as $country)
                                                            <option value="{{ $country->id }}">
                                                                {{ $country->country_name }} </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="form-label" for="destination_country" >Destination
                                                        Country</label>
                                                    <select required
                                                        class="form-control form-control-lg form-select destination_country form-control form-control-lg-lg input_field "
                                                        id="destination_country" data-toggle="select2"
                                                        name="destination_country" size="1"
                                                        label="Destination Country" data-placeholder="Destination Country"
                                                        data-allow-clear="1">
                                                        <option value="">Destination Country</option>
                                                        @foreach ($countries as $country)
                                                            <option value="{{ $country->id }}">
                                                                {{ $country->country_name }} </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="form-label" for="region_type" >Select
                                                        Zone</label>
                                                    <select required
                                                        class="form-control form-select region form-control-lg input_field "
                                                        id="region_type" data-toggle="select2" name="region_type"
                                                        size="1" label="Zone" data-placeholder="Select Zone"
                                                        data-allow-clear="1">
                                                        <option value="">Select Region</option>
                                                        <option value="T-1">Tier-1</option>
                                                        <option value="T-2">Tier-2</option>
                                                        <option value="T-3">Tier-3</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-3 mt-2">
                                                    <label for="start_weight">Start Weight<span
                                                            class="req">*</span></label>
                                                    <input type="text" class="form-control form-control-lg float"
                                                        id="start_weight" name="start_weight" data-parsley-type="number"
                                                        minlength="1" maxlength="4" placeholder="Enter Start Weight"
                                                        required="true">
                                                </div>
                                                <div class="col-md-3 mt-2">
                                                    <label for="end_weight">End Weight<span
                                                            class="req">*</span></label>
                                                    <input type="text" class="form-control form-control-lg float"
                                                        id="end_weight" name="end_weight" data-parsley-type="number"
                                                        minlength="1" maxlength="4" placeholder="Enter End Weight"
                                                        required="true">
                                                </div>
                                                <div class="col-md-3 mt-2">
                                                    <label for="charges">Charges<span class="req">*</span></label>
                                                    <input type="text" class="form-control form-control-lg float"
                                                        id="charges" name="charges" data-parsley-type="number"
                                                        minlength="1" maxlength="4" placeholder="Enter Charges"
                                                        required="true">
                                                </div>
                                                <div class="col-md-3 mt-2">
                                                    <label for="add_weight">Additional Weight<span
                                                            class="req">*</span></label>
                                                    <input type="text" class="form-control form-control-lg float"
                                                        id="add_weight" name="add_weight" data-parsley-type="number"
                                                        minlength="1" maxlength="3"
                                                        placeholder="Enter Additional Weight">
                                                </div>
                                                <div class="col-md-3 mt-2">
                                                    <label class="form-label" for="add_charges">Additional Charges<span
                                                            class="req">*</span></label>
                                                    <input type="text" class="form-control form-control-lg float"
                                                        id="add_charges" name="add_charges" data-parsley-type="number"
                                                        minlength="1" maxlength="4"
                                                        placeholder="Enter Additional Charges">
                                                </div>
                                                <div class="col-md-3 mt-2">
                                                    <label class="form-label" for="rto_charges">RTO Charges<span
                                                            class="req">*</span></label>
                                                    <input type="text" class="form-control form-control-lg float"
                                                        id="rto_charges" name="rto_charges" data-parsley-type="number"
                                                        minlength="1" value="0" maxlength="4"
                                                        placeholder="Enter RTO Charges">
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
                                                        data-form_id="#tariff_details"
                                                        class="btn btn-orio btn-sm float-right add_more_info"
                                                        style="min-width: 10px !important">
                                                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M1.5 10H18.5" stroke="#fff" stroke-width="2" stroke-linecap="round"></path>
                                                            <path d="M10 18.5V1.5" stroke="#fff" stroke-width="2" stroke-linecap="round"></path>
                                                        </svg>
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                        <div style="overflow-x: scroll">
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
                                                        {{-- <th>Additional weight (RTO)</th> --}}
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
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- For Cash Handling Charges --}}
            <div class="cataloge-wrapper">
                <div class="row">
                    <div class="col-12">
                        <div class="card card-box mb-5">
                            <div class="card-header">
                                <b>Add Cash Handling Charges</b>
                            </div>
                            <div class="card-body">
                                <div class="no-gutters row">
                                    <div class="col-md-12">
                                        <form class="handling_charges" data-input_hidden="#handling_hidden_feilds"
                                            data-display_table="#handling_display" action="#" data-parsley-validate
                                            id="handling_charges" method="post">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <label class="form-label" for="handl_dedc_type" >
                                                        Select Deduction Type</label>
                                                    <select required
                                                        class="form-control form-select form-control-lg input_field"
                                                        id="handl_dedc_type" data-toggle="select2"
                                                        name="handling_deduction_type" size="1"
                                                        label="Select Deduction Type"
                                                        data-placeholder="Select Deduction Type" data-allow-clear="1">
                                                        <option value="">Select Deduction Type</option>
                                                        <option value="1">Flat</option>
                                                        <option value="2">Percentage</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="form-label" for="min_amt">Minimum Amount<span
                                                            class="req">*</span></label>
                                                    <input type="text" data-parsley-type="number"
                                                        class="form-control form-control-lg float" id="min_amt"
                                                        name="min_amt" placeholder="Enter Minimum Amount"
                                                        required="true" minlength="1" maxlength="6">
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="form-label" for="max_amt">Maximum Amount<span
                                                            class="req">*</span></label>
                                                    <input type="text" data-parsley-type="number"
                                                        class="form-control form-control-lg float" id="max_amt"
                                                        name="max_amt" placeholder="Enter Maximum Amount"
                                                        required="true" minlength="1" maxlength="6">
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="form-label" for="charges">Charges<span class="req">*</span></label>
                                                    <input type="text" data-parsley-type="number"
                                                        class="form-control form-control-lg float"
                                                        id="handling_charges_amt" name="handling_charges"
                                                        placeholder="Enter Charges" required="true" minlength="1"
                                                        maxlength="4">
                                                </div>
                                                <div class="col-md-12 mt-4">
                                                    <button type="button" data-type="handling" data-count="1"
                                                        data-form_id="#handling_charges"
                                                        class="float-right btn btn-orio btn-sm float-right add_more_info"
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
                                                    <th>Minimum Amt</th>
                                                    <th>Maximum Amt</th>
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
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- For Additional Charges --}}
            <div class="cataloge-wrapper">
                <div class="row">
                    <div class="col-12">
                        <div class="card card-box mb-5">
                            <div class="card-header">
                                <b>Add Additional Charges</b>
                            </div>
                            <div class="card-body">
                                <div class="no-gutters row">
                                    <div class="col-md-12">
                                        <form class="additional_charges" data-input_hidden="#additional_hidden_feilds"
                                            data-display_table="#additional_display" action="#" data-parsley-validate
                                            id="additional_charges" method="post">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <label class="form-label" for="service" id="service_name">
                                                        Select Service</label>
                                                    <select required
                                                        class="form-control form-select service_name form-control-lg input_field "
                                                        id="service_name2" data-toggle="select2"
                                                        name="additional_service_name" size="1" label="Service"
                                                        data-placeholder="Select Service" data-allow-clear="1">
                                                        <option value="">Select Service</option>
                                                        @foreach (session('services') as $service)
                                                            <option value="{{ $service->id }}">
                                                                {{ $service->service_name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="form-label" for="add_charges_type" >
                                                        Select Charges</label>
                                                    <select required
                                                        class=" form-control form-select add_charges_type form-control-lg input_field"
                                                        id="add_charges_type" data-toggle="select2"
                                                        name="add_charges_type" size="2" label="Select Charges"
                                                        data-placeholder="Select Charges" data-allow-clear="1">
                                                        <option value="">Select Charges</option>
                                                        <option value="1">GST</option>
                                                        <option value="2">SST</option>
                                                        <option value="3">Bank Charges</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="form-label" for="add_dedc_type" >
                                                        Select Deduction Type</label>
                                                    <select required
                                                        class=" form-control form-select form-control-lg input_field"
                                                        id="add_dedc_type" data-toggle="select2"
                                                        name="additionl_deduction_type" size="1"
                                                        label="Select Deduction Type"
                                                        data-placeholder="Select Deduction Type" data-allow-clear="1">
                                                        <option value="">Select Deduction Type</option>
                                                        <option value="1">Flat</option>
                                                        <option value="2">Percentage</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-3">
                                                    <label for="charges">Charges<span class="req">*</span></label>
                                                    <input type="text" data-parsley-type="number"
                                                        class="form-control form-control-lg float" minlength="1"
                                                        maxlength="4" id="additional_amt" name="additional_amt"
                                                        placeholder="Enter Charges" required="true">
                                                </div>
                                                <div class="col-md-12 mt-4">
                                                    <button type="button" data-count="1" data-type="additional"
                                                        data-form_id="#additional_charges"
                                                        class="btn btn-orio float-right btn-sm add_more_info"
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
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 mb-3 mt-2 text-right">
                <button type="button" class="btn btn-orio ml-auto" id="addCustomer">Save</button>
            </div>
        </div>
    </div>
    </div>
    <script>
        var listRoute = "";
    </script>

    @if ($type == 'add')
        <script>
            var storeUrl = "{{ route('customer.add_edit_customer') }}";
            var id = "";
        </script>
    @endif
@section('scripts')
    <script src="{{ asset('assets/js/customers/customers.js') }}"></script>
    <script src="{{ asset('assets/js/customers/charges.js') }}"></script>
@endsection
@endsection
