@extends('layout.main')

@section('content')
    <div class="app-content">
        {{-- Edit modal --}}
        <div class="modal fade" id="edit_modal" role="dialog" aria-labelledby="editsucessModal" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered w-800" role="document">
                <div class="modal-content">
                    <div class="modal-header border-0">
                        <h6 class="modal-title" id="modal-title-default">Edit Sales Person</h6>
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
                            <div class="col-md-12 py-3">
                                <div id="edit_form_append" class="p-0">
                                </div>
                            </div>
                            <div class="col-md-12 text-center mt-1">
                                <div class="d-flex justify-content-center w-100">
                                    <input type="hidden" value="startDate=&amp;endDate=" id="selected_filter_date">
                                    <button type="button" class="btn btn-secondary-orio mr-3 my-3" data-dismiss="modal"
                                        aria-label="Close">Close</button>
                                    <a href="javascript:;" class="btn btn-orio my-3" data-form-id="edit_sales_men_from"
                                        id="updateBtn">Edit Sales Person</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- Add modal --}}
        <div class="modal fade" id="add_modal" role="dialog" aria-labelledby="editsucessModal" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered w-800" role="document">
                <div class="modal-content">
                    <div class="modal-header pb-0 border-0">
                        <h6 class="modal-title" id="modal-title-default">Add Sales Person</h6>
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
                            <div class="col-md-12 px-4">
                                <form id="add_sales_men_from" method="POST" enctype="multipart/form-data"
                                    data-parsley-validate>
                                    @csrf
                                    <div class="form-row">
                                        <div class="col-md-6 px-3">
                                            <label for="inputEmail4">First Name<span class="req">*</span></label>
                                            <input type="text" name="first_name" value=""
                                                class="form-control form-control-lg" id="first_name" label="First name"
                                                required placeholder="First Name">
                                            <label id="error_first_name"></label>
                                        </div>
                                        <div class="col-md-6 px-3">
                                            <label for="inputEmail4">Last Name<span class="req">*</span></label>
                                            <input type="text" name="last_name" value=""
                                                class="form-control form-control-lg" id="last_name" label="Last name"
                                                required placeholder="Last Name">
                                        </div>
                                        <div class="col-md-6 px-3">
                                            <label for="inputEmail4">Email<span class="req">*</span></label>
                                            <input type="email" name="email" value=""
                                                class="form-control form-control-lg" id="email" label="Email"
                                                required placeholder="Email">
                                        </div>
                                        <div class="col-md-6 px-3">
                                            <label for="inputEmail4">Phone<span class="req">*</span></label>
                                            <input minlength="10" maxlength="12" type="tel" name="phone"
                                                class="form-control form-control-lg mobilenumber" id="phone"
                                                label="Phone" required placeholder="03xx-xxxxxxx"
                                                data-inputmask="'mask': '0399-9999999'">
                                        </div>
                                        <div class="mb-3 col-md-6 mt-3 px-3">
                                            <label class="form-label" for="" id="">Select
                                                Country</label>
                                            <select required
                                                class=" form-control form-control-lg form-select country_id form-control form-control-lg-lg input_field "
                                                id="country_id" data-toggle="select2" name="country_id" size="1"
                                                label="Select Country" data-placeholder="Select Country"
                                                data-allow-clear="1">
                                                <option value="">Select Country</option>
                                                @foreach ($countries as $country)
                                                    <option value="{{ $country->id }}">
                                                        {{ $country->country_name }} </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3 col-md-6 mt-3 px-3">
                                            <label class="form-label" for="" id="">
                                                Select City</label>
                                            <select required class=" form-control form-select city_id input_field "
                                                id="city_id" data-toggle="select2" name="city_id" size="1"
                                                label="Select city" data-placeholder="Select city" data-allow-clear="1">
                                                <option value="">Select City</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 px-3">
                                            <label for="inputEmail4">Username<span class="req">*</span></label>
                                            <input minlength="4" maxlength="18" name="username" type="text"
                                                value="" class="form-control form-control-lg" id="user_name"
                                                label="Username" required placeholder="Enter Username">
                                        </div>
                                        <div class="col-md-6 px-3">
                                            <div class="d-flex justify-content-between">
                                                <label for="inputEmail4">Password<span class="req">*</span></label>
                                                <label data-toggle="tooltip" title="Click to generate password" class="gen-pass mb-0">Generate password</label>
                                            </div>
                                            <input type="password" name="password" value=""
                                                class="form-control form-control-lg passwordField" id="password"
                                                label="Password" required placeholder="Password">
                                            <span class="show_pass_btn"><i class="fa-regular fa-eye"></i></span>
                                        </div>
                                        <div class="col-md-6 mt-3 px-3">
                                            <label for="inputEmail4">Confirm Password<span class="req">*</span></label>
                                            <input type="password" data-parsley-equalto="#password"
                                                name="confirm_password" value=""
                                                class="form-control form-control-lg passwordField" id="confirm_password"
                                                label="Confirm Password" required placeholder="Confirm Password">
                                            <span class="show_pass_btn"><i class="fa-regular fa-eye"></i></span>
                                        </div>
                                        {{-- <div class="mt-5">
                                            <button class="btn btn-sm btn-secondary-orio gen-pass" type="button">Generate
                                                password</button>
                                        </div> --}}
                                    </div>
                                    <input type="hidden" id="add_url"
                                        value="{{ route('admin.add_edit_salePerson') }}">
                                </form>
                            </div>
                            <div class="col-md-12 text-center mt-1">
                                <div class="d-flex justify-content-center w-100">
                                    <input type="hidden" value="startDate=&amp;endDate=" id="selected_filter_date">
                                    <button type="button" class="btn btn-secondary-orio mr-3 my-3" data-dismiss="modal"
                                        aria-label="Close">Close</button>
                                    <a href="javascript:;" class="btn btn-orio my-3" data-form-id="add_sales_men_from"
                                        id="add-btn">Add Sales Person</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

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
                        <div class="mx-auto mx-xl-0  btn-wrapper" style="margin-right: 16px !important;">
                            <button class="btn btn-secondary-orio" data-toggle="modal" data-target="#add_modal">Add
                                Sales
                                Person</button>
                        </div>
                        <div class="mx-auto mx-xl-0">
                            <div class="d-inline-block btn-group btn btn-primary coursor-pointer">
                                <div id="datepicker">
                                    <span class="date_title"></span>
                                    <span class="date_range"></span>
                                    <i class="fa fa-caret-down"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card card-box mb-3">
                <div class="card-header">
                    <div class="card-header--title">
                        <b>List of sales persons</b>
                    </div>
                </div>
                <table id="example" class="example2 display nowrap table table-hover" width="100%">
                    <thead class="thead">
                        <tr>
                            <th>SNO</th>
                            <th>FIRSTNAME</th>
                            <th>LASTNAME</th>
                            <th>EMAIL</th>
                            <th>PHONE</th>
                            <th>ACTIVE</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        @section('scripts')
            <script src="{{ asset('assets/js/admin/modules.js') }}"></script>
        @endsection

    @endsection
