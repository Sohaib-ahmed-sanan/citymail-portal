@extends('layout.main')
@section('content')
    <div class="app-content">
        <div class="app-content--inner order-detail-wrapper">
            <div class="pb-4 text-center text-xl-left">
                <div class="row align-items-center">
                    <div class="col-xl-7">
                        <div>
                            <ol class="d-inline-block breadcrumb text-uppercase font-size-xs p-0">
                                <li class="d-inline-block breadcrumb-item"><a href="{{ Route('admin.index') }}">Dashboard</a>
                                </li>
                                <li class="d-inline-block breadcrumb-item"><a href="javascript::void(0)">Admin</a></li>
                                <li class="d-inline-block breadcrumb-item"><a
                                        href="{{ Route('customer.sub_accounts') }}">List Sub Accounts</a></li>
                                <li class="d-inline-block breadcrumb-item active">{{ $title }}</li>
                            </ol>
                            <h5 class="display-4 mt-1 mb-2 font-weight-bold text-uppercase">{{ $title }}</h5>
                            <p class="text-black-50 mb-0">{{ $title }} below by filling the form</p>
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
                                    <small class="d-block text-uppercase mt-1">{{ $title }}</small>
                                    <b>{{ $title }}:</b>
                                </div>
                            </div>
                            <div class="card-body">
                                <form class="sub_account_form" action="#" data-parsley-validate id="sub_account_form"
                                    method="post" novalidate="" id="remove_data">
                                    <div class="no-gutters row">
                                        <div class="col-md-6">
                                            <div class="card-header--title mb-3">
                                                <small class="d-block text-uppercase mt-1">Sub Account Information</small>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12 mb-3">
                                                    <label for="name">Name<span class="req">*</span></label>
                                                    <input type="text" class="form-control form-control-lg"
                                                        id="name" name="name" placeholder="Enter Name"
                                                        value="{{ isset($payload->name) ? $payload->name : '' }}"
                                                        required="true">
                                                </div>
                                                <div class="col-md-12 mb-3">
                                                    <label for="Email">Email<span class="req">*</span></label>
                                                    <input type="email" class="form-control form-control-lg"
                                                        id="email" name="email" placeholder="Enter Email"
                                                        value="{{ isset($payload->email) ? $payload->email : '' }}"
                                                        required="true">
                                                </div>
                                                <div class="col-md-12 mb-3">
                                                    <label for="Phone">Phone<span class="req">*</span></label>
                                                    <input minlength="10" maxlength="12" type="tel" name="phone"
                                                        class="form-control form-control-lg mobilenumber" id="phone"
                                                        label="Phone" required placeholder="03xx-xxxxxxx"
                                                        data-inputmask="'mask': '0399-9999999'" value="{{ isset($payload->phone) ? $payload->phone : '' }}">
                                                </div>
                                                <div class="mb-3 col-md-12">
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
                                                <div class="mb-3 col-md-12">
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
                                                <div class="col-md-12 mb-3">
                                                    <label for="Address">Address<span class="req">*</span></label>
                                                    <input type="text" class="form-control form-control-lg"
                                                        id="address" name="address" placeholder="Enter Address"
                                                        value="{{ isset($payload->address) ? $payload->address : '' }}"
                                                        required="true">
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label for="Customer_name">CNIC<span class="req">*</span></label>
                                                    <input type="integer" data-parsley-type="integer" minlength="13"
                                                        maxlength="13" class="form-control form-control-lg number"
                                                        id="cnic" name="cnic" placeholder="Enter CNIC"
                                                        value="{{ isset($payload->cnic) ? $payload->cnic : '' }}"
                                                        required="true">
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label for="Customer_name">NTN<span class="req">*</span></label>
                                                    <input type="integer" minlength="5" maxlength="13"
                                                        data-parsley-type="integer"
                                                        class="form-control form-control-lg number" id="ntn"
                                                        name="ntn" placeholder="Enter NTN" class="ntnNumber"
                                                        value="{{ isset($payload->ntn) ? $payload->ntn : '' }}">
                                                </div>
                                                <div class="col-md-12 mb-3">
                                                    <label for="business_name">Business Name<span class="req">*</span></label>
                                                    <input type="text" class="form-control form-control-lg"
                                                        id="business_name" name="business_name" placeholder="Enter Address"
                                                        value="{{ isset($payload->business_name) ? $payload->business_name : '' }}"
                                                        required="true">
                                                </div>
                                                <div class="col-md-12 mb-3">
                                                    <label for="user_name">User Name<span class="req">*</span></label>
                                                    <input type="string" class="form-control form-control-lg"
                                                        id="user_name" name="user_name" placeholder="Enter User Name"
                                                        value="{{ isset($payload->user_name) ? $payload->user_name : '' }}"
                                                        required="true">
                                                    <input type="hidden" name="old_user_name"
                                                        value="{{ isset($payload->user_name) ? $payload->user_name : '' }}">
                                                </div>
                                                <div class="col-md-12 mb-3">
                                                    <label for="password">Password<span class="req">*</span></label>
                                                    <input type="password" minlength="6" maxlength="16"
                                                        class="form-control form-control-lg passwordField" id="password"
                                                        name="password" placeholder="Enter Password" value=""
                                                        {{ isset($type) && $type == 'edit' ? '' : 'required="true"' }}>
                                                    <span class="show_pass_btn" style="right: 33px !important;"><i
                                                            class="fa-regular fa-eye"></i></span>
                                                </div>
                                                <div class="col-md-12 mb-3">
                                                    <label for="password">Confirm Password<span
                                                            class="req">*</span></label>
                                                    <input type="password" minlength="6" ata-parsley-equalto="#password"
                                                        maxlength="16" class="form-control form-control-lg passwordField"
                                                        id="password" name="password" placeholder="Confirm Password"
                                                        value=""
                                                        {{ isset($type) && $type == 'edit' ? '' : 'required="true"' }}>
                                                    <span class="show_pass_btn" style="right: 33px !important;"><i
                                                            class="fa-regular fa-eye"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="card-header--title mb-3">
                                                <small class="d-block text-uppercase mt-1">Sub Account Rights</small>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <ul class="menu-list" style="list-style-type: none">
                                                        @foreach (session('menues') as $mainMenu)
                                                            @if ($mainMenu->parent_id === null && !in_array($mainMenu->id, [23]))
                                                                <li>
                                                                    <input type="checkbox"
                                                                        {{ isset($payload->menue) && $payload->menue != '' && in_array($mainMenu->id, json_decode($payload->menue)) ? 'checked' : '' }}
                                                                        id="{{ $mainMenu->id }}" class="main_menu"
                                                                        data-main-id="{{ $mainMenu->id }}"
                                                                        value="{{ $mainMenu->id }}" name="rights_main[]">
                                                                    <label for="main_check_{{ $mainMenu->id }}">
                                                                        @if (is_portal() && $mainMenu->title == 'Admin')
                                                                            {{ 'Account' }}
                                                                        @elseif (is_portal() && $mainMenu->title == 'Operations')
                                                                            {{ 'Shipments' }}
                                                                        @else
                                                                            {{ $mainMenu->title }}
                                                                        @endif
                                                                    </label>
                                                                    <ul class="sub-menu" style="list-style-type: none">
                                                                        @foreach (session('menues') as $subMenu)
                                                                            @if ($subMenu->parent_id !== null && $subMenu->parent_id == $mainMenu->id && !in_array($subMenu->id, [21, 23]))
                                                                                <li>
                                                                                    <input type="checkbox"
                                                                                        {{ isset($payload->menue) && $payload->menue != '' && in_array($subMenu->id, json_decode($payload->menue)) ? 'checked' : '' }}
                                                                                        data-parent-id="{{ $subMenu->parent_id }}"
                                                                                        id="{{ $subMenu->id }}"
                                                                                        value="{{ $subMenu->id }}"
                                                                                        class="sub_menu"
                                                                                        name="rights_sub[]">
                                                                                    <label
                                                                                        for="sub_check_{{ $subMenu->id }}">{{ $subMenu->title }}</label>
                                                                                </li>
                                                                            @endif
                                                                        @endforeach
                                                                    </ul>
                                                                </li>
                                                            @endif
                                                        @endforeach
                                                    </ul>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="col-md-12 mb-3 mt-2 text-right">
                                <button type="button" class="btn btn-orio ml-auto" id="addAccount">Save</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <script>
        var storeUrl = "{{ route('customer.add_edit_sub_account') }}";
    </script>
    @if ($type == 'edit')
        <script>
            var acno = {{ isset($payload->acno) ? $payload->acno : '' }};
            var storeUrl = "{{ route('customer.add_edit_sub_account', ['id' => ':acno']) }}".replace(':acno', acno);
        </script>
    @endif
@section('scripts')
    <script src="{{ asset('assets/js/customers/sub_accounts.js') }}"></script>
@endsection
@endsection
