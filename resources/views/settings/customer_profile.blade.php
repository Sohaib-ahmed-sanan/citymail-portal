@extends('layout.main')
@section('content')
    <div class="app-content">
        <div class="app-content--inner order-detail-wrapper">
            <div class="pb-4 text-center text-xl-left">
                <div class="row align-items-center">
                    <div class="col-xl-7">
                       <div>
                            <h5 class="title-text mb-1">{{ $title }}</h5>
                             <p class="sub-title-text mb-0">Manage {{ strtolower($title) }} below</p>
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
                                    <b>{{ $title }}</b>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="no-gutters row">
                                    <div class="col-md-12">
                                        <form class="profile_form" action="#" data-parsley-validate id="profile_form"
                                            method="post" novalidate="">
                                            @csrf
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label for="Customer_name">Name<span class="req">*</span></label>
                                                    <input type="text" class="form-control" id="name" name="name"
                                                        placeholder="Enter Name"
                                                        value="{{ isset($payload->name) ? $payload->name : '' }}"
                                                        required="true">
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label for="Customer_name">Email<span class="req">*</span></label>
                                                    <input readonly type="email" class="form-control" id="email"
                                                        name="email" placeholder="Enter Email"
                                                        value="{{ isset($payload->email) ? $payload->email : '' }}"
                                                        required="true">
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label for="Customer_name">Phone<span class="req">*</span></label>
                                                    <input minlength="11" data-parsley-type="integer" maxlength="13"
                                                        type="tel" class="form-control number" id="phone"
                                                        name="phone" placeholder="Enter Phone"
                                                        value="{{ isset($payload->phone) ? $payload->phone : '' }}"
                                                        required="true">
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label for="Customer_name">Address<span class="req">*</span></label>
                                                    <input type="text" class="form-control" id="address" name="address"
                                                        placeholder="Enter Address"
                                                        value="{{ isset($payload->address) ? $payload->address : '' }}"
                                                        required="true">
                                                </div>
                                                <div class="mb-3 col-md-6">
                                                    <label class="form-label" for="" id="">Select
                                                        Country</label>
                                                    <select required
                                                        class=" form-control form-control-lg form-select country_id form-control form-control-lg-lg input_field "
                                                        id="country_id" data-toggle="select2" name="country_id" size="1"
                                                        label="Select Country" data-placeholder="Select Country"
                                                        data-allow-clear="1">
                                                        <option value="">Select Country</option>
                                                        @foreach ($countries as $country)
                                                            <option {{ isset($payload->country_id) && $payload->country_id == $country->id ? 'selected' : '' }} value="{{ $country->id }}">
                                                                {{ $country->country_name }} </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="mb-3 col-md-6">
                                                    <label class="form-label" for="city_id" id="">
                                                        Select City</label>
                                                    <select required
                                                        class=" form-control form-select city_id form-control-lg input_field "
                                                        id="" data-toggle="select2" name="city_id" size="1"
                                                        label="Select City" data-placeholder="Select city" data-allow-clear="1">
                                                        <option value="">Select City</option>
                                                        @if (isset($cities))
                                                            @foreach ($cities as $cities)
                                                                <option {{ isset($payload->city_id) && $payload->city_id == $cities->id ? 'selected' : '' }} value="{{ $cities->id }}">
                                                                    {{ $cities->city }} </option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label for="business_name">Business Name<span
                                                            class="req">*</span></label>
                                                    <input type="text" class="form-control" id="business_name"
                                                        name="business_name" placeholder="Enter Business Name"
                                                        value="{{ isset($payload->business_name) ? $payload->business_name : '' }}"
                                                        required="true">
                                                </div>
                                                @if (session('type') != '7')
                                                    <div class="col-md-6 mb-3">
                                                        <label for="business_address">Business Address<span
                                                                class="req">*</span></label>
                                                        <input type="text" class="form-control" id="business_address"
                                                            name="business_address" placeholder="Enter Business Address"
                                                            value="{{ isset($payload->business_address) ? $payload->business_address : '' }}"
                                                            required="true">
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <label for="other_name">Other Name</label>
                                                        <input type="text" class="form-control" id="other_name"
                                                            name="other_name" placeholder="Enter Other Name"
                                                            value="{{ isset($payload->other_name) ? $payload->other_name : '' }}">
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <label for="other_phone">Other Phone</label>
                                                        <input type="tel" data-parsley-type="integer" minlength="11"
                                                            maxlength="13" class="form-control number" id="other_phone"
                                                            name="other_phone" placeholder="Enter Other Phone"
                                                            value="{{ isset($payload->other_phone) ? $payload->other_phone : '' }}">
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <label class="form-label" for="bank" id="bank">
                                                            Bank</label>
                                                        <select required
                                                            class="form-control form-select service form-control-lg input_field "
                                                            id="bank" data-toggle="select2" name="bank"
                                                            size="1" label="bank" data-placeholder="Select bank"
                                                            data-allow-clear="1">
                                                            <option value="">Select Bank</option>
                                                            @foreach (session('banks') as $bank)
                                                                <option
                                                                    {{ isset($payload->bank) && $payload->bank == $bank->id ? 'selected' : '' }}
                                                                    value="{{ $bank->id }}"> {{ $bank->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                <div class="col-md-6 mb-3">
                                                    <label for="account_number">Account Title<span
                                                            class="req">*</span></label>
                                                    <input type="text" class="form-control" id="account_title"
                                                        name="account_title" placeholder="Enter Account Title"
                                                        value="{{ isset($payload->account_title) ? $payload->account_title : '' }}"
                                                        required="true">
                                                </div>
                                                    <div class="col-md-6 mb-3">
                                                        <label for="Customer_name">Account Number<span
                                                                class="req">*</span></label>
                                                        <input type="integer" data-parsley-type="integer"
                                                            class="form-control" id="account_number"
                                                            name="account_number" placeholder="Enter Account Number"
                                                            value="{{ isset($payload->account_number) ? $payload->account_number : '' }}"
                                                            required="true">
                                                    </div>
                                                @endif
                                                <div class="col-md-6 mb-3">
                                                    <label for="cnic">CNIC<span class="req">*</span></label>
                                                    <input type="integer" data-parsley-type="integer"
                                                        class="form-control number" id="cnic" name="cnic"
                                                        minlength="13" maxlength="13" placeholder="Enter CNIC"
                                                        value="{{ isset($payload->cnic) ? $payload->cnic : '' }}"
                                                        required="true">
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label for="ntn">NTN<span class="req"></span></label>
                                                    <input type="integer" data-parsley-type="integer" minlength="13"
                                                        maxlength="13" class="form-control" id="ntn"
                                                        name="ntn" placeholder="Enter NTN"
                                                        value="{{ isset($payload->ntn) ? $payload->ntn : '' }}">
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label for="user_name">User Name<span class="req">*</span></label>
                                                    <input type="string" class="form-control" id="user_name"
                                                        name="user_name" readonly placeholder="Enter User Name"
                                                        value="{{ isset($payload->user_name) ? $payload->user_name : '' }}"
                                                        required="true">
                                                    <input type="hidden" name="old_user_name"
                                                        value="{{ isset($payload->user_name) ? $payload->user_name : '' }}">
                                                </div>
                                                @if (session('type') != '7')
                                                    <div class="col-md-6">
                                                        <label for="inputZip">Upload CNIC<span
                                                                class="req">*</span></label>
                                                        <div class="dropzone dropzone-single dz-clickable dz-max-files-reached"
                                                        data-toggle="dropzone-image-1"
                                                        data-dropzone-url="{{ route('admin.uploadProfileData') }}">
                                                            <div class="fallback">
                                                                <div class="custom-file">
                                                                    <input type="file" class="custom-file-input"
                                                                        id="dropzoneBasicUpload">
                                                                    <label class="custom-file-label"
                                                                        for="dropzoneBasicUpload"><i
                                                                            class="fad fa-image"></i></label>
                                                                </div>
                                                            </div>
                                                            <div class="dz-preview dz-preview-single">
                                                                <div class="dz-preview-cover">
                                                                    <img class="dz-preview-img" src=""
                                                                        alt="..." data-dz-thumbnail>
                                                                </div>
                                                            </div>
                                                            @if ($payload->cnic_image != '')
                                                                <div id="pr_image_db" style="z-index:0"
                                                                    class="pr_image_uploaded">
                                                                    <img class="dz-preview-img"
                                                                        src="{{ asset('images/' . session('company_id') . '/' . session('acno') . '/' . $payload->cnic_image) }}"
                                                                        alt="" data-dz-thumbnail>
                                                                </div>
                                                            @endif
                                                        </div>
                                                        <input type="hidden" name="cnic_image" id="image_1">
                                                        <input type="hidden" name="old_cnic_image" value="{{ $payload->cnic_image }}">
                                                    </div>
                                                @endif
                                                <div class="col-md-12 mb-3 mt-2 text-right">
                                                    <button class="btn btn-orio" id="submit-btn" type="button">Update
                                                        Profile</button>
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
        var storeUrl = "{{ route('admin.customerProfile') }}";
        var returnUrl = "{{ route('admin.customerProfile') }}";
    </script>

@section('scripts')
    <script src="{{ asset('assets/js/auth/profile.js') }}"></script>
@endsection
@endsection
