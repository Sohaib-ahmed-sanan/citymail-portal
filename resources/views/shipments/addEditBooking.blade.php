@extends('layout.main')
@section('content')
    {{-- @dd(session('cities')) --}}
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
                                    <b>{{ $title }}:
                                    {{ isset($payload->consignment_no) ? $payload->consignment_no : '' }}</b>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="no-gutters row">
                                    <div class="col-md-12">
                                        <form class="customer_form" action="#" data-parsley-validate id="customer_form"
                                            method="post" novalidate="" id="remove_data">
                                            <div class="row">

                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Consignee Name<span class="req">*</span></label>
                                                    <input type="text" class="form-control form-control-lg"
                                                        id="name" name="name" placeholder="Enter Name"
                                                        value="{{ isset($payload->consignee_name) ? $payload->consignee_name : '' }}"
                                                        required="true">
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Consignee Email</label>
                                                    <input type="email" class="form-control form-control-lg"
                                                        id="email" name="email" placeholder="Enter Email"
                                                        value="{{ isset($payload->consignee_email) ? $payload->consignee_email : '' }}">
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Consignee Phone<span
                                                            class="req">*</span></label>
                                                    <input minlength="10" maxlength="17" type="tel" name="phone"
                                                        class="form-control form-control-lg" id="phone"
                                                        label="Phone" required placeholder="03xx-xxxxxxx"
                                                        value="{{ isset($payload->consignee_phone) ? $payload->consignee_phone : '' }}"
                                                        required="true">
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Consignee Address<span
                                                            class="req">*</span></label>
                                                    <input type="text" class="form-control form-control-lg"
                                                        id="address" name="address" placeholder="Enter Address"
                                                        value="{{ isset($payload->consignee_address) ? $payload->consignee_address : '' }}"
                                                        required="true">
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Shipment Ref<span
                                                            class="req">*</span></label>
                                                    <input type="text" class="form-control form-control-lg"
                                                        id="name" name="shipment_ref"
                                                        placeholder="Enter Shipment Ref"value="{{ isset($payload->shipment_referance) ? $payload->shipment_referance : '' }}"
                                                        required="true">
                                                </div>
                                                @if (is_ops())
                                                    <div class="mb-3 col-md-6">
                                                        <label class="form-label" for="customer_acno" >
                                                            Select Customer<span class="req">*</span></label>
                                                        <select required
                                                            class="form-control form-select customer_acno form-control-lg input_field "
                                                            id="customer_acno" data-toggle="select2" name="account"
                                                            size="1" label="Select Customer"
                                                            data-placeholder="Select Customer" data-allow-clear="1">
                                                            <option value="">Select Customer</option>
                                                            @foreach ($customers as $customer)
                                                                <option value="{{ $customer->acno }}"
                                                                    {{ isset($payload->customer_acno) && $payload->customer_acno == $customer->acno ? 'selected' : '' }}>
                                                                    {{ $customer->business_name }} ({{ $customer->acno }})
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                @endif
                                                @if (is_portal())
                                                    <input type="hidden" id="customer_acno" name="account"
                                                        value="{{ session('acno') }}">
                                                    {{-- <div class="mb-3 col-md-6">
                                                        <label class="form-label" for="sub_account_id"
                                                            >Make for Sub account</label>
                                                        <select
                                                            class=" form-control form-select sub_account_id form-control-lg input_field"
                                                            id="is-sub-account" data-toggle="select2"
                                                            name="sub_account_id" size="1"
                                                            label="Make for Sub account"
                                                            data-placeholder="Make for Sub account" data-allow-clear="1">
                                                            <option value="0">NO</option>
                                                            <option value="1">YES</option>
                                                        </select>
                                                    </div> --}}
                                                    {{-- <div id="sub_account_id" class="mb-3 col-md-6 d-none">
                                                        <label class="form-label" for="account_id" >
                                                            Select Sub Account</label>
                                                        <select
                                                            class="form-control form-select account_id form-control-lg input_field "
                                                            id="sub_account" data-toggle="select2" name="sub_account"
                                                            size="1" label="Select Sub Account"
                                                            data-placeholder="Select Sub Account" data-allow-clear="1">
                                                            <option value="">Select Sub Account</option>
                                                        </select>
                                                    </div> --}}
                                                @endif
                                                @if (is_customer_sub())
                                                    <input type="hidden" id="customer_acno" name="account"
                                                        value="{{ session('acno') }}">
                                                @endif

                                                <div class="mb-3 col-md-6">
                                                    <label class="form-label" for="country_id" >
                                                        Select Pickup Location<span
                                                            class="req">*</span></label>
                                                    <select required
                                                        class=" form-control form-select  form-control-lg input_field "
                                                        id="pickup_locations" data-toggle="select2"
                                                        name="pickup_location" size="1"
                                                        label="Select Pickup Location"
                                                        data-placeholder="Select Pickup Location" data-allow-clear="1">
                                                        <option value="">Select Pickup Location</option>
                                                        @if (isset($pickup_locations))
                                                            @foreach ($pickup_locations as $pl)
                                                                <option value="{{ $pl->id }}"
                                                                    {{ $payload->pickup_location_id == $pl->id ? 'selected' : '' }}
                                                                    data-location-id="{{ $pl->id }}">
                                                                    {{ $pl->title }}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                                <div class="mb-3 col-md-6">
                                                    <label class="form-label" for="service_name">
                                                        Select Service<span
                                                            class="req">*</span></label>
                                                    <select required
                                                        class="form-control form-select service form-control-lg input_field"
                                                        id="service_name" data-toggle="select2" name="service_id"
                                                        size="1" label="Service" data-placeholder="Select Service"
                                                        data-allow-clear="1">
                                                        <option value="">Select Service</option>
                                                        @if (isset($services))
                                                            @foreach (session('services') as $s)
                                                                @if (in_array($s->id, $services))
                                                                    <option
                                                                        {{ $payload->service_id == $s->id ? 'selected' : '' }}
                                                                        value="{{ $s->id }}">
                                                                        {{ $s->service_name }}</option>
                                                                @endif
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                                <div class="mb-3 col-md-6">
                                                    <label class="form-label" for="" >Select
                                                        Destination Country<span
                                                            class="req">*</span></label>
                                                    <select required
                                                        class=" form-control form-control-lg form-select country_id form-control form-control-lg-lg input_field "
                                                        id="country_id" data-toggle="select2" name="country_id"
                                                        size="1" label="Select Destination Country"
                                                        data-placeholder="Select Destination Country"
                                                        data-allow-clear="1">
                                                        <option value="">Select Destination Country</option>
                                                        @foreach ($countries as $country)
                                                            <option value="{{ $country->id }}"
                                                                {{ isset($payload->destination_country) && $country->id == $payload->destination_country ? 'selected' : '' }}>
                                                                {{ $country->country_name }} </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="mb-3 col-md-6">
                                                    <label class="form-label" for="" >
                                                        Select Destination City<span
                                                            class="req">*</span></label>
                                                    <select required
                                                        class="form-control form-select city_id form-control-lg input_field"
                                                         data-toggle="select2" name="destination"
                                                        size="1" label="Select Destination"
                                                        data-placeholder="Select Destination" data-allow-clear="1">
                                                        <option value="">Select Destination</option>
                                                        @if (isset($payload->destination_city_id))
                                                            @foreach ($cities as $city)
                                                                <option  {{ $payload->destination_city_id == $city->id ? 'selected' : '' }} value="{{ $city->id }}">{{ $city->city }}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                                {{--<div class="mb-3 col-md-6">
                                                    <label class="form-label" for="service" id="payment_method">
                                                        Select Payment method<span
                                                            class="req">*</span></label>
                                                    <select required
                                                        class="form-control form-select payment_method form-control-lg input_field "
                                                        id="payment_method_id" data-toggle="select2"
                                                        name="payment_method_id" size="1" label="Payment method"
                                                        data-placeholder="Select Payment method" data-allow-clear="1">
                                                        <option value="">Select Payment method</option>
                                                        <option
                                                            {{ isset($payload->payment_method_id) && $payload->payment_method_id == 1 ? 'selected' : '' }}
                                                            value="1">COD </option>
                                                        <option
                                                            {{ isset($payload->payment_method_id) && $payload->payment_method_id == 2 ? 'selected' : '' }}
                                                            value="2">CC</option>
                                                    </select>
                                                </div>--}}
                                                <input type="hidden" name="payment_method_id" value="1" />
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Product Detail<span
                                                            class="req">*</span></label>
                                                    <input type="text" class="form-control form-control-lg"
                                                        id="product_detail" name="product_detail"
                                                        placeholder="Enter Product Detail"
                                                        value="{{ isset($payload->parcel_detail) ? $payload->parcel_detail : '' }}"
                                                        required="true">
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label" for="amount">COD Ammount<span class="req">*</span></label>
                                                    <input class="form-control form-control-lg float"
                                                        {{ isset($payload->payment_method_id) && $payload->payment_method_id == 2 ? 'disabled' : '' }}
                                                        id="amount" name="order_amount"
                                                        placeholder="Enter COD Ammount" required
                                                        data-parsley-validate="number"
                                                        value="{{ isset($payload->orignal_order_amt) ? $payload->orignal_order_amt : '' }}"
                                                        minlength="0" maxlength="10">
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label" for="" >
                                                        Select Currency<span
                                                            class="req">*</span></label>
                                                    <select required
                                                        class="form-control form-control-lg form-select form-control form-control-lg-lg input_field "
                                                        id="currency_id" data-toggle="select2" name="base_currency"
                                                        size="1" label="Select Currency"
                                                        data-placeholder="Select Currency" data-allow-clear="1">
                                                        <option value="">Select Currency</option>
                                                        @foreach ($currencies as $currency)
                                                            @if (in_array($currency->code, ['PKR', 'AED', 'USD','SAR']))
                                                                <option value="{{ $currency->code }}"
                                                                    {{ isset($payload->orignal_currency_code) && $currency->code == $payload->orignal_currency_code ? 'selected' : '' }}>
                                                                    {{ $currency->name }} ({{ $currency->code }})
                                                                </option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label" for="peices">Peices<span class="req">*</span></label>
                                                    <input class="form-control form-control-lg number" id="peices"
                                                        name="peices" data-parsley-validate="number"
                                                        placeholder="Enter Peices"
                                                        value="{{ isset($payload->peices) ? $payload->peices : '' }}"
                                                        required="true" minlength="1" maxlength="5">
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Weight (Kg)<span
                                                            class="req">*</span></label>
                                                    <input data-parsley-validate="number"
                                                        class="form-control form-control-lg float" id="weight"
                                                        name="weight" placeholder="Enter Weight (Kg) "
                                                        value="{{ isset($payload->weight) ? $payload->weight : '' }}"
                                                        required="true" minlength="1" maxlength="5">
                                                </div>
                                                <div class="mb-3 col-md-6">
                                                    <label class="form-label" for="fragile" >
                                                        Fragile<span
                                                            class="req">*</span></label>
                                                    <select required
                                                        class=" form-control form-select fragile form-control-lg input_field "
                                                        id="fragile_select" data-toggle="select2" name="fragile"
                                                        size="1" label="Select Fragile"
                                                        data-placeholder="Select Fragile" data-allow-clear="1">
                                                        <option value="">Select Fragile</option>
                                                        <option value="0"
                                                            {{ isset($payload->fragile) && $payload->fragile == 0 ? 'selected' : '' }}>
                                                            No</option>
                                                        <option value="1"
                                                            {{ isset($payload->fragile) && $payload->fragile == 1 ? 'selected' : '' }}>
                                                            Yes</option>
                                                    </select>
                                                </div>
                                                <div class="mb-3 col-md-6">
                                                    <label class="form-label" for="insurance_select" >
                                                        Select Insurance<span
                                                            class="req">*</span></label>
                                                    <select required
                                                        class=" form-control form-select insurance_select form-control-lg input_field "
                                                        id="insurance_select" data-toggle="select2" name="insurance"
                                                        size="1" label="Select Insurance"
                                                        data-placeholder="Select Insurance" data-allow-clear="1">
                                                        <option value="">Select Insurance</option>
                                                        <option value="0"
                                                            {{ isset($payload->insurance) && $payload->insurance == 0 ? 'selected' : '' }}>
                                                            No</option>
                                                        <option value="1"
                                                            {{ isset($payload->insurance) && $payload->insurance == 1 ? 'selected' : '' }}>
                                                            Yes</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-6 mb-3 d-none">
                                                    <label class="form-label">Insurance AMT<span class="req">*</span></label>
                                                    <input data-parsley-validate="number"
                                                        class="form-control form-control-lg float" id="insurance_amt"
                                                        name="insurance_amt" placeholder="Insurance AMT" value="" minlength="1" maxlength="5">
                                                        <input type="hidden" name="cn_number" value="{{ isset($payload->consignment_no) ? $payload->consignment_no : '' }}">
                                                </div>
                                                <div class="mb-3 col-md-12">
                                                    <label class="form-label">Shipper
                                                        Comments</label>
                                                    <textarea class="form-control form-control-lg" id="comments" name="comments" placeholder="Comments">{{ isset($payload->shipper_comment) ? $payload->shipper_comment : '' }}</textarea>
                                                </div>
                                                <div class="col-md-12 mb-3 mt-2 text-right">
                                                    <button type="button" class="btn btn-orio ml-auto"
                                                        id="addCustomer">Save</button>
                                                </div>
                                            </div>
                                        </form>
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
        var sessionType = "{{ session('type') }}";
        var pageType = "addEdit";
        var sub_id = null;
        if (sessionType == 'customer-subaccount') {
            var sub_id = "{{ session('logged_id') }}";
        }
    </script>
    @if ($type == 'edit')
        <script>
            var id = {{ isset($payload->id) ? $payload->id : '' }};
            var storeUrl = "{{ route('admin.add_edit_bookings', ['id' => ':id']) }}".replace(':id', id);
        </script>
    @endif
    @if ($type == 'add')
        <script>
            var storeUrl = "{{ route('admin.add_edit_bookings') }}";
        </script>
    @endif
@section('scripts')
    <script src="{{ asset('assets/js/shipments/manual_booking.js') }}"></script>
@endsection
@endsection
