@extends('layout.main')
@section('content')


    <div class="app-content">
        {{-- add pickup locations --}}
            <div class="modal fade" id="add_pickup_modal" role="dialog" aria-labelledby="editsucessModal" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered w-800" role="document">
                    <div class="modal-content">
                        <div class="modal-header border-0">
                            <h6 class="modal-title" id="modal-title-default">Add Pickup Location</h6>
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
                                    <form id="add_location_from" data-url="{{ route('admin.add_edit_pickupLocation') }}" method="POST" enctype="multipart/form-data"
                                        data-parsley-validate>
                                        @csrf
                                        <div class="form-row">
                                            <div class="col-md-6 mb-3 px-3">
                                                <label for="title">Title<span class="req">*</span></label>
                                                <input type="text" class="form-control form-control-lg" id="title"
                                                    name="pickup_title" placeholder="Enter Title"
                                                    value="" required="true">
                                            </div>
                                            <div class="col-md-6 mb-3 px-3">
                                                <label for="Customer_name">Name<span class="req">*</span></label>
                                                <input type="text" class="form-control form-control-lg" id="name"
                                                    name="pickup_name" placeholder="Enter Name"
                                                    value="" required="true">
                                            </div>
                                            <div class="col-md-6 mb-3 px-3">
                                                <label for="Customer_name">Email<span class="req">*</span></label>
                                                <input type="email" class="form-control form-control-lg" id="email"
                                                    name="pickup_email" placeholder="Enter Email"
                                                    value="" required="true">
                                            </div>
                                            <div class="col-md-6 mb-3 px-3">
                                                <label for="Customer_name">Phone<span class="req">*</span></label>
                                                <input minlength="10" maxlength="12" type="tel"
                                                    class="form-control form-control-lg mobilenumber"data-inputmask="'mask': '0399-9999999'"
                                                    id="phone" name="pickup_phone" placeholder="Enter Phone"
                                                    value="" required="true">
                                            </div>
                                            <div class="col-md-6 mb-3 px-3">
                                                <label for="Customer_name">Address<span class="req">*</span></label>
                                                <input type="text" class="form-control form-control-lg" id="address"
                                                    name="pickup_address" placeholder="Enter Address"
                                                    value=""
                                                    required="true">
                                            </div>
                                            @if (is_ops())
                                                <div class="mb-3 col-md-6 px-3">
                                                    <label class="form-label" for="select_customer_id">
                                                        Select Customer</label>
                                                    <select required
                                                        class="form-control form-select  form-control-lg input_field"
                                                        id="select_customer_id" data-toggle="select2" name="pickup_customer_acno"
                                                        size="1" label="Select Customer"
                                                        data-placeholder="Select Customer" data-allow-clear="1">
                                                        <option value="">Select Customer</option>
                                                        @foreach ($customers as $customer)
                                                            <option value="{{ $customer->acno }}">
                                                                {{ $customer->business_name }}
                                                                ({{ $customer->acno }})
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            @else
                                                <input type="hidden" name="pickup_customer_acno" value="{{ session('acno') }}">
                                            @endif
                                            @if (is_portal())
                                                <div class="mb-3 col-md-6 px-3">
                                                    <label class="form-label" for="sub_account_id" id="">Make for
                                                        Sub account</label>
                                                    <select
                                                        class=" form-control form-select sub_account_id form-control-lg input_field"
                                                        id="is-sub-account" data-toggle="select2" name=""
                                                        size="1" label="Make for Sub account"
                                                        data-placeholder="Make for Sub account" data-allow-clear="1">
                                                        <option value="0">NO</option>
                                                        <option value="1">YES</option>
                                                    </select>
                                                </div>
                                                <div id="sub_account_id" class="mb-3 col-md-6 d-none">
                                                    <label class="form-label" for="sub_account_id" id="">
                                                        Select Sub Account</label>
                                                    <select
                                                        class="form-control form-select sub_account_id form-control-lg input_field"
                                                        data-toggle="select2" name="sub_account_acno" size="1"
                                                        id="sub-acc-select" label="Select Sub Account"
                                                        data-placeholder="Select Sub Account" data-allow-clear="1">
                                                        <option value="">Select Sub Account</option>
                                                        @foreach ($sub_accounts as $sub_account)
                                                            <option value="{{ $sub_account->acno }}">
                                                                {{ $sub_account->name }} </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            @elseif(is_customer_sub())
                                                <input type="hidden" name="sub_account_acno" value="{{ session('acno') }}">
                                            @endif
                                            <div class="mb-3 col-md-6 px-3">
                                                <label class="form-label">Select Country</label>
                                                <select required
                                                    class="form-control form-control-lg form-select input_field"
                                                    id="pickup_country_id" onchange="get_city(this.value,'.pickup_city')" data-toggle="select2" name="pickup_country_id"
                                                    size="1" label="Select Country"
                                                    data-placeholder="Select Country" data-allow-clear="1">
                                                    <option value="">Select Country</option>
                                                    @foreach ($countries as $country)
                                                        <option value="{{ $country->id }}">
                                                            {{ $country->country_name }} </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="mb-3 col-md-6 px-3">
                                                <label class="form-label" for="pickup_city">
                                                    Select City<span class="req">*</span></label>
                                                <select required
                                                    class="form-control pickup_city form-select form-control-lg input_field"
                                                    id="pickup_city" data-toggle="select2" name="pickup_city_id" size="1"
                                                    label="Select Citiy" data-placeholder="Select Citiy"
                                                    data-allow-clear="1">
                                                    <option value="">Select City</option>
                                                </select>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-md-12 text-center mt-1">
                                    <div class="d-flex justify-content-center w-100">
                                        <button type="button" class="btn btn-secondary-orio mr-3 my-3" data-dismiss="modal"
                                            aria-label="Close">Close</button>
                                        <button type="button" class="btn btn-orio my-3" id="add-pickup-btn" onclick="create_pickup(this,event)">Add Location</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        {{-- add customers --}}
        @if (is_ops())
            <div class="modal fade" id="add_customer_modal" role="dialog" aria-labelledby="editsucessModal" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered w-800" role="document">
                    <div class="modal-content">
                        <div class="modal-header border-0">
                            <h6 class="modal-title" id="modal-title-default">Add Customer</h6>
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
                                    <form id="add_customer_from" data-url="{{ route('admin.add-walkin-customer') }}" method="POST" enctype="multipart/form-data"
                                        data-parsley-validate>
                                        @csrf
                                        <div class="form-row">
                                            <div class="col-md-6 mb-3 px-3">
                                                <label for="">Name<span class="req">*</span></label>
                                                <input type="text" class="form-control form-control-lg" id="customer_name"
                                                    name="customer_name" placeholder="Enter Name"
                                                    value="" required="true">
                                            </div>
                                            <div class="col-md-6 mb-3 px-3">
                                                <label for="">Email<span class="req">*</span></label>
                                                <input type="email" class="form-control form-control-lg" id="customer_email"
                                                    name="customer_email" placeholder="Enter Email"
                                                    value="" required="true">
                                            </div>
                                            <div class="col-md-6 mb-3 px-3">
                                                <label for="">Phone<span class="req">*</span></label>
                                                <input minlength="10" maxlength="12" type="tel"
                                                    class="form-control form-control-lg mobilenumber"data-inputmask="'mask': '0399-9999999'"
                                                    id="customer_phone" name="customer_phone" placeholder="Enter Phone"
                                                    value="" required="true">
                                            </div>
                                            <div class="col-md-6 mb-3 px-3">
                                                <label for="">Address<span class="req">*</span></label>
                                                <input type="text" class="form-control form-control-lg" id="customer_address"
                                                    name="customer_address" placeholder="Enter Address"
                                                    value=""
                                                    required="true">
                                            </div>
                                            <div class="col-md-6 mb-3 px-3">
                                                <label for="">Postal Code<span class="req">*</span></label>
                                                <input type="text" class="form-control form-control-lg" id="customer_postal_code"
                                                    name="customer_postal_code" placeholder="Enter Postal Code"
                                                    value="" required="true">
                                            </div>
                                            <div class="col-md-6 mb-3 px-3">
                                                <label class="form-label" for="business_name">Business Name<span
                                                        class="req">*</span></label>
                                                <input type="text" class="form-control form-control-lg"
                                                    id="customer_business_name" name="customer_business_name"
                                                    placeholder="Enter Business Name"
                                                    value="" required="true">
                                            </div>
                                            <div class="col-md-6 mb-3 px-3">
                                                <label class="form-label" for="business_address">Business Address<span
                                                        class="req">*</span></label>
                                                <input type="text" class="form-control form-control-lg"
                                                    id="customer_business_address" name="customer_business_address"
                                                    placeholder="Enter Business Address"
                                                    value=""  required="true">
                                            </div>
                                            <div class="col-md-6 mb-3 px-3">
                                                <label class="form-label" for="cnic">CNIC<span class="req">*</span></label>
                                                <input type="integer" data-parsley-type="integer" minlength="13"
                                                    maxlength="13" class="form-control form-control-lg number"
                                                    id="customer_cnic" name="customer_cnic" placeholder="Enter CNIC"
                                                    value=""  required="true">
                                            </div>
                                            <div class="col-md-6 mb-3 px-3">
                                                <label class="form-label" for="ntn">NTN<span class="req"></span></label>
                                                <input type="text"
                                                    class="form-control form-control-lg" id="customer_ntn"
                                                    name="customer_ntn" placeholder="Enter NTN" class="ntnNumber"
                                                    value="">
                                            </div>
                                            <div class="mb-3 col-md-6 px-3">
                                                <label class="form-label">Select Country</label>
                                                <select required
                                                    class="form-control form-control-lg form-select input_field"
                                                    id="customer_country_id" onchange="get_city(this.value,'.customer_city')" data-toggle="select2" name="customer_country_id"
                                                    size="1" label="Select Country"
                                                    data-placeholder="Select Country" data-allow-clear="1">
                                                    <option value="">Select Country</option>
                                                    @foreach ($countries as $country)
                                                        <option value="{{ $country->id }}">
                                                            {{ $country->country_name }} </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="mb-3 col-md-6 px-3">
                                                <label class="form-label" for="customer_city">
                                                    Select City<span class="req">*</span></label>
                                                <select required
                                                    class="form-control customer_city form-select form-control-lg input_field"
                                                    id="customer_city" data-toggle="select2" name="customer_city_id" size="1"
                                                    label="Select Citiy" data-placeholder="Select Citiy"
                                                    data-allow-clear="1">
                                                    <option value="">Select City</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6 mb-3 px-3">
                                                <label for="user_name">User Name<span class="req">*</span></label>
                                                <input type="string" minlength="4" maxlength="25"
                                                    class="form-control form-control-lg" id="user_name"
                                                    name="user_name" placeholder="Enter User Name"
                                                    value=""  required="true">
                                            </div>
                                            <div class="col-md-6 mb-3 px-3">
                                                <div class="d-flex justify-content-between">
                                                    <label for="inputEmail4">Password<span class="req">*</span></label>
                                                    <label data-toggle="tooltip" title="Click to generate password" class="gen-pass mb-0">Generate password</label>
                                                </div>
                                                <input type="password" minlength="6" maxlength="16"
                                                    class="form-control form-control-lg passwordField" id="password"
                                                    name="customer_password" placeholder="Enter Password" value=""
                                                    required="true">
                                                <span class="show_pass_btn" style="right: 33px !important;"><i
                                                        class="fa-regular fa-eye"></i></span>
                                            </div>
                                            <div class="col-md-6 mb-3 px-3">
                                                <label for="password">Confirm Password<span
                                                        class="req">*</span></label>
                                                <input type="password" minlength="6" data-parsley-equalto="#password"
                                                    maxlength="16" class="form-control form-control-lg passwordField"
                                                    id="confirm_password"
                                                    placeholder="Confirm Password" value="" required="true">
                                                <span class="show_pass_btn" style="right: 33px !important;"><i
                                                        class="fa-regular fa-eye"></i></span>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-md-12 text-center mt-1">
                                    <div class="d-flex justify-content-center w-100">
                                        <button type="button" class="btn btn-secondary-orio mr-3 my-3" data-dismiss="modal"
                                            aria-label="Close">Close</button>
                                        <button type="button" class="btn btn-orio my-3" id="add-customer-btn" onclick="create_customer(this,event)">Add Customer</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        <div class="app-content--inner order-detail-wrapper">
            <div class="pb-4 text-center text-xl-left">
                <div class="row align-items-center">
                    <div class="col-xl-5">
                        <div>
                            <h5 class="title-text mb-1">{{ $title }}</h5>
                             <p class="sub-title-text mb-0">{{ $title }} by filling the form below</p>
                        </div>
                    </div>
                    <div class="col-xl-7 d-flex align-items-center justify-content-start mt-xl-0 justify-content-xl-end">
                        @if (is_ops())
                            <button class="btn btn-secondary-orio mr-2" data-toggle="modal" data-target="#add_customer_modal">Add
                                Customer
                            </button>
                        @endif
                        <button class="btn btn-secondary-orio mr-2" data-toggle="modal" data-target="#add_pickup_modal">Add
                            Location</button>
                    </div>
                </div>
            </div>
            <div class="catalogue-wrapper">
                <div class="row">
                    <div class="col-12">
                        <div class="card card-box mb-5">
                            <div class="card-header">
                                <div class="card-header--title">
                                    <b>{{ $title }}:
                                        {{ isset($shipment->consignment_no) ? $shipment->consignment_no : '' }}</b>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="no-gutters row">
                                    <div class="col-md-12">
                                        <form class="shipment_form" action="#" data-parsley-validate
                                            id="shipment_form" method="post"
                                            data-url="{{ isset($shipment) ? route('admin.store-express-shipments', ['id' => $shipment->id]) : route('admin.store-express-shipments') }}">
                                            <div class="row">
                                                @if (is_ops())
                                                    <div class="mb-3 col-md-6 px-3">
                                                        <label class="form-label" for="" id="">
                                                            Select Customer</label>
                                                        <select required
                                                            class="form-control form-select customer_acno form-control-lg input_field"
                                                            id="customer_acno" data-toggle="select2"
                                                            name="customer_acno" size="1" label="Select Customer"
                                                            data-placeholder="Select Customer" data-allow-clear="1">
                                                            <option value="">Select Customer</option>
                                                            @foreach ($customers as $customer)
                                                                <option {{ isset($shipment->customer_acno) && $shipment->customer_acno == $customer->acno ? 'selected' : '' }} value="{{ $customer->acno }}">
                                                                    {{ $customer->business_name }}
                                                                    ({{ $customer->acno }})
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                @else
                                                    <input type="hidden" name="customer_acno"
                                                        value="{{ session('acno') }}">
                                                @endif
                                                <div class="mb-3 col-md-6">
                                                    <label class="form-label" for="pickup_locations" >
                                                        Select Pickup Location<span
                                                            class="req">*</span></label>
                                                    <select required
                                                        class="form-control form-select form-control-lg input_field"
                                                        id="pickup_locations" data-toggle="select2"
                                                        name="pickup_location" size="1"
                                                        label="Select Pickup Location"
                                                        data-placeholder="Select Pickup Location" data-allow-clear="1">
                                                        <option value="">Select Pickup Location</option>
                                                        @if (isset($pickup_locations))
                                                            @foreach ($pickup_locations as $pl)
                                                                <option value="{{ $pl->id }}"
                                                                    {{ $shipment->pickup_location_id == $pl->id ? 'selected' : '' }}
                                                                    data-location-id="{{ $pl->id }}">
                                                                    {{ $pl->title }}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                                {{-- ---------------------------------------------------------------------------------------- --}}
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Consignee Name<span
                                                            class="req">*</span></label>
                                                    <input type="text" class="form-control form-control-lg"
                                                        id="consignee_name" name="consignee_name"
                                                        placeholder="Enter Consignee Name"
                                                        value="{{ isset($shipment->consignee_name) ? $shipment->consignee_name : '' }}"
                                                        required="true">
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Consignee Email</label>
                                                    <input type="email" class="form-control form-control-lg"
                                                        id="consignee_email" required name="consignee_email"
                                                        placeholder="Enter Consignee Email"
                                                        value="{{ isset($shipment->consignee_email) ? $shipment->consignee_email : '' }}">
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Consignee Phone<span
                                                            class="req">*</span></label>
                                                    <input minlength="10" maxlength="17" type="tel"
                                                        name="consignee_phone" class="form-control form-control-lg"
                                                        id="consignee_phone" label="Consignee Phone" required
                                                        placeholder="03xx-xxxxxxx"
                                                        value="{{ isset($shipment->consignee_phone) ? $shipment->consignee_phone : '' }}"
                                                        required="true">
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Consignee CNIC</label>
                                                    <input type="integer" data-parsley-type="integer" minlength="6"
                                                        maxlength="13" name="consignee_cnic"
                                                        class="form-control form-control-lg" id="consignee_cnic"
                                                        label="Consignee CNIC/NTN" placeholder="Enter Consignee CNIC/NTN"
                                                        value="{{ isset($shipment->consignee_cnic) ? $shipment->consignee_cnic : '' }}">
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Consignee Postal Code<span
                                                            class="req">*</span></label>
                                                    <input minlength="4" maxlength="10" name="consignee_postcode"
                                                        class="form-control form-control-lg" id="consignee_postcode"
                                                        label="Consignee Postal Code" required
                                                        placeholder="Enter Consignee Postal Code"
                                                        value="{{ isset($shipment->consignee_postalcode) ? $shipment->consignee_postalcode : '' }}"
                                                        required="true" type="integer" data-parsley-type="integer">
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Consignee Address<span
                                                            class="req">*</span></label>
                                                    <input type="text" class="form-control form-control-lg"
                                                        id="consignee_address" name="consignee_address"
                                                        placeholder="Enter Consignee Address"
                                                        value="{{ isset($shipment->consignee_address) ? $shipment->consignee_address : '' }}"
                                                        required="true">
                                                </div>

                                                <div class="mb-3 col-md-6">
                                                    <label class="form-label" for="">Select
                                                        Destination Country<span class="req">*</span></label>
                                                    <select required
                                                        class=" form-control form-control-lg form-select form-control form-control-lg-lg input_field "
                                                        id="destination_country_id" data-toggle="select2"
                                                        name="destination_country_id" size="1"
                                                        onchange="get_city(this.value,'.destination_city_id')"
                                                        label="Select Destination Country"
                                                        data-placeholder="Select Destination Country"
                                                        data-allow-clear="1">
                                                        <option value="">Select Destination Country</option>
                                                        @foreach ($countries as $country)
                                                            <option value="{{ $country->id }}"
                                                                {{ isset($shipment->destination_country_id) && $country->id == $shipment->destination_country_id ? 'selected' : '' }}>
                                                                {{ $country->country_name }} </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="mb-3 col-md-6">
                                                    <label class="form-label" for="country_id">
                                                        Select Destination City<span class="req">*</span></label>
                                                    <select required
                                                        class="form-control form-select destination_city_id form-control-lg input_field"
                                                        data-toggle="select2" name="destination_city_id" size="1"
                                                        label="Select Destination City"
                                                        data-placeholder="Select Destination City" data-allow-clear="1">
                                                        <option value="">Select Destination City</option>
                                                        @if (isset($shipment->destination_city_id))
                                                            @foreach ($cities as $city)
                                                                <option
                                                                    {{ $shipment->destination_city_id == $city->id ? 'selected' : '' }}
                                                                    value="{{ $city->id }}">{{ $city->city }}
                                                                </option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Shipmenr Referance<span
                                                            class="req">*</span></label>
                                                    <input data-parsley-validate="text"
                                                        class="form-control form-control-lg" id="shipment_ref"
                                                        name="shipment_ref" placeholder="Enter Shipmenr Referance"
                                                        value="{{ isset($shipment->shipment_referance) ? $shipment->shipment_referance : '' }}"
                                                        required="true" minlength="1" maxlength="100">
                                                </div>
                                                <div class="mb-3 col-md-6">
                                                    <label class="form-label" for="service_name">
                                                        Select Service<span class="req">*</span></label>
                                                    <select required
                                                        class="form-control form-select service form-control-lg input_field "
                                                        id="service_name" data-toggle="select2" name="service_id"
                                                        size="1" label="Service" data-placeholder="Select Service"
                                                        data-allow-clear="1">
                                                        <option value="">Select Service</option>
                                                        <option
                                                            {{ isset($shipment) && $shipment->service_id == '5' ? 'selected' : '' }}
                                                            value="5">
                                                            Express
                                                        </option>
                                                        <option
                                                            {{ isset($shipment) && $shipment->service_id == '6' ? 'selected' : '' }}
                                                            value="6">
                                                            Economy
                                                        </option>
                                                    </select>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Total Weight (Kg)<span
                                                            class="req">*</span></label>
                                                    <input data-parsley-validate="number"
                                                        class="form-control form-control-lg float" id="weight"
                                                        name="weight" placeholder="Enter Total Weight (Kg) "
                                                        value="{{ isset($shipment->weight) ? $shipment->weight : '' }}"
                                                        required="true" minlength="1" maxlength="5">
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Export Reason<span
                                                            class="req">*</span></label>
                                                    <input class="form-control form-control-lg" id="export_reason"
                                                        name="export_reason" placeholder="Enter Export Reason"
                                                        value="{{ isset($shipment->shipper_comment) ? $shipment->shipper_comment : '' }}"
                                                        required="true" minlength="1" maxlength="20">
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Document<span
                                                            class="req">*</span></label>
                                                    <input type="file" class="form-control form-control-lg"
                                                        id="document" name="document"
                                                        accept="application/pdf, image/jpeg, image/jpg, image/png">
                                                </div>
                                                @if (isset($shipment->document) && $shipment->document != "")
                                                    <div class="col-md-6 mt-4">
                                                        <a class="btn btn-orio"
                                                            href="{{ env('API_URL').$shipment->document }}"
                                                            target="_blank">View Document</a>
                                                    </div>
                                                @endif
                                            </div>
                                        </form>
                                        @if (!isset($shipment))
                                            <form class="product_details" data-display_table="#detais_table"
                                                data-parsley-validate id="product_details">
                                                <div class="row">
                                                    <div class="col-md-4 mt-2">
                                                        <label for="product_details_inp">Details<span
                                                                class="req">*</span></label>
                                                        <input type="text" class="form-control form-control-lg "
                                                            id="product_details_inp" name="product_details_inp"
                                                            minlength="1" maxlength="100" placeholder="Enter Details"
                                                            required="true">
                                                    </div>
                                                    <div class="col-md-3 mt-2">
                                                        <label for="start_weight">HS Code<span
                                                                class="req">*</span></label>
                                                        <input type="text" class="form-control form-control-lg float"
                                                            id="hs_code_inp" name="hs_code_inp"
                                                            data-parsley-type="number" minlength="1" maxlength="20"
                                                            placeholder="Enter HS Code" required="true">
                                                    </div>
                                                    <div class="col-md-2 mt-2">
                                                        <label>Value<span class="req">*</span></label>
                                                        <input type="text" class="form-control form-control-lg float"
                                                            id="value_inp" name="value_inp" data-parsley-type="number"
                                                            minlength="1" maxlength="4" placeholder="Enter Value"
                                                            required="true">
                                                    </div>
                                                    <div class="col-md-2 mt-2">
                                                        <label>QTY<span class="req">*</span></label>
                                                        <input type="text" class="form-control form-control-lg float"
                                                            id="qty_inp" name="qty_inp" data-parsley-type="number"
                                                            minlength="1" maxlength="4" placeholder="Enter QTY"
                                                            required="true">
                                                    </div>
                                                    <div class="col-md-1 mt-4">
                                                        <button type="button" data-toggle="toolip" title="Add Details"
                                                            data-count="1" onclick="addDetails(this)"
                                                            data-form_id="#product_details"
                                                            class="btn btn-orio btn-sm float-right add_more_details"
                                                            style="min-width: 10px !important">+</button>
                                                    </div>
                                                </div>
                                            </form>
                                        @endif
                                        <div style="overflow-x: scroll">
                                            <table class="example2 display nowrap table table-hover mt-4" width="100%">
                                                <thead class="thead">
                                                    <tr>
                                                        <th>SNO</th>
                                                        <th>Product Details</th>
                                                        <th>HS Code</th>
                                                        <th>Value</th>
                                                        <th>QTY</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="detais_table">
                                                    @if (isset($shipment) && count($shipment->product_details) > 0)
                                                        @foreach ($shipment->product_details as $details)
                                                            <tr data-id="{{ $details->id }}">
                                                                <td>
                                                                    <div
                                                                        class="d-flex align-items-center justify-content-center">
                                                                        <div class="custom-control custom-checkbox my-3">
                                                                            <input type="checkbox"
                                                                                class="custom-control-input check_box"
                                                                                name="checked_ids[]"
                                                                                value="{{ $details->id }}"
                                                                                id="updateCheck{{ $loop->iteration }}">
                                                                            <label class="custom-control-label"
                                                                                for="updateCheck{{ $loop->iteration }}"></label>
                                                                        </div>
                                                                        {{ $loop->iteration }}
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <input readonly type="text" minlength="1"
                                                                        maxlength="100"
                                                                        class="form-control form-control-lg"
                                                                        name="product_detail_{{ $details->id }}"
                                                                        value="{{ $details->product_detail }}">
                                                                </td>
                                                                <td>
                                                                    <input readonly minlength="1" maxlength="20"
                                                                        class="form-control form-control-lg number"
                                                                        type="text" name="hs_code_{{ $details->id }}"
                                                                        value="{{ $details->hs_code }}">
                                                                </td>
                                                                <td>
                                                                    <input readonly minlength="1" maxlength="4"
                                                                        type="text"
                                                                        class="form-control form-control-lg float"
                                                                        name="value_{{ $details->id }}"
                                                                        value="{{ $details->value }}">
                                                                </td>
                                                                <td>
                                                                    <input readonly minlength="1" maxlength="4"
                                                                        type="text"
                                                                        class="form-control form-control-lg float"
                                                                        name="qty_{{ $details->id }}"
                                                                        value="{{ $details->qty }}">
                                                                </td>
                                                                <input type="hidden" name="amount_{{ $details->id }}"
                                                                    value="{{ $details->amount }}">
                                                                <td>
                                                                    <button type="button" table="shipment_detail"
                                                                        data-id="{{ $details->id }}" data-status="0"
                                                                        class=" delete btn btn-danger p-2 btn-sm"
                                                                        style="min-width: 10px !important"><i
                                                                            class="fa-solid fa-trash"></i></button>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    @else
                                                        <tr class="default text-center">
                                                            <td colspan="15">No details Found</td>
                                                        </tr>
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>

                                        <div class="col-md-12 mt-5 text-right">
                                            <button type="button" class="btn btn-orio ml-auto" id="save-btn">Save</button>
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
    </div>
@section('scripts')
    <script>
        var sessionType = "{{ session('type') }}";
    </script>
    <script src="{{ asset('assets/js/express-shipments/main.js') }}"></script>
@endsection
@endsection
