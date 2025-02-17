@extends('layout.main')
@section('content')
    <div class="app-content">
        {{-- Edit modal --}}
        <div class="modal fade" id="edit_modal" role="dialog" aria-labelledby="editsucessModal" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered w-800" role="document">
                <div class="modal-content">
                    <div class="modal-header border-0">
                        <h6 class="modal-title" id="modal-title-default">Edit {{ $title }}</h6>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
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
                                    <button type="button" class="btn btn-secondary-orio mr-3 my-3" data-dismiss="modal"
                                        aria-label="Close">Close</button>
                                    <a href="javascript:;" class="btn btn-sm btn-orio my-3"
                                        data-form-id="edit_sales_men_from" id="updateBtn">Edit {{ $title }}</a>
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
                    <div class="modal-header border-0">
                        <h6 class="modal-title" id="modal-title-default">Add {{ $title }}</h6>
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
                                <form id="add_sales_men_from" method="POST" enctype="multipart/form-data"
                                    data-parsley-validate>
                                    @csrf
                                    <div class="form-row">
                                        <div class="mb-3 col-md-6 px-3">
                                            <label class="form-label" for="city_id" id="">Select Courier<span
                                                    class="req">*</span></label>
                                            <select required
                                                class="form-control form-select city_id form-control-lg input_field "
                                                id="courier_id" data-toggle="select2" name="courier_id" size="1"
                                                label="Select Courier" data-placeholder="Select Courier"
                                                data-allow-clear="1">
                                                <option value="">Select Courier</option>
                                                @foreach ($couriers as $courier)
                                                    @if (in_array($courier->id, ['22', '23','24']))
                                                        <option value="{{ $courier->id }}">{{ $courier->courier_name }}
                                                        </option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6 px-3">
                                            <label for="inputEmail4">Account Title<span class="req">*</span></label>
                                            <input type="text" name="account_title" value=""
                                                class="form-control form-control-lg" id="account_title"
                                                label="Account Title" required placeholder="Account Title">
                                        </div>
                                        <div class="col-md-6 px-3">
                                            <label for="inputEmail4">Account No<span class="req">*</span></label>
                                            <input type="text" name="account_no" value=""
                                                class="form-control form-control-lg" id="account_no" label="Account No"
                                                required placeholder="Account No">
                                        </div>
                                        <div class="col-md-6 px-3">
                                            <label for="inputEmail4">User<span class="req">*</span></label>
                                            <input type="text" name="user" value=""
                                                class="form-control form-control-lg" id="user" label="user"
                                                required placeholder="User">
                                        </div>
                                        <div class="col-md-6 mt-3 px-3">
                                            <label for="inputEmail4">Password<span class="req">*</span></label>
                                            <input type="password" name="password" value=""
                                                class="form-control form-control-lg" id="password" label="Password"
                                                required placeholder="Password">
                                        </div>
                                        <div class="col-md-6 mt-3 px-3">
                                            <label for="inputEmail4">API Key</label>
                                            <input type="text" name="api_Key" value=""
                                                class="form-control form-control-lg passwordField" id="api_Key"
                                                label="API Key" placeholder="API Key">
                                        </div>
                                    </div>
                                    <input type="hidden" id="add_url" value="{{ route('admin.add_edit_couriers') }}">
                                </form>
                            </div>
                            <div class="col-md-12 text-center mt-1">
                                <div class="d-flex justify-content-center w-100">
                                    <button type="button" class="btn btn-secondary-orio mr-3 my-3" data-dismiss="modal"
                                        aria-label="Close">Close</button>
                                    <a href="javascript:;" class="btn btn-sm btn-orio my-3" id="add-btn">Add
                                        {{ $title }}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- courier code Add  --}}
        <div class="modal fade" id="code_modal" role="dialog" aria-labelledby="editsucessModal" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered w-800" role="document">
                <div class="modal-content">
                    <div class="modal-header border-0">
                        <h6 class="modal-title" id="modal-title-default">Add Couriers Code</h6>
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
                                <form id="add_code_form" method="POST" enctype="multipart/form-data"
                                    data-parsley-validate>
                                    @csrf
                                    <div class="form-row">
                                        <div class="col-md-6 px-3">
                                            <label class="form-label" for="country_id" id="">
                                                Select Courier Account</label>
                                            <select required
                                                class=" form-control form-select country_id form-control-lg input_field "
                                                id="" data-toggle="select2" name="account_id" size="1"
                                                label="Sales Courier " data-placeholder="Select Courier Account"
                                                data-allow-clear="1">
                                                <option value="">Select Courier Account</option>
                                                @foreach ($accounts as $account)
                                                    <option value="{{ $account->id }}">
                                                        {{ $account->account_title }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6 px-3">
                                            <label for="inputEmail4">Code<span class="req">*</span></label>
                                            <input type="text" name="code" value=""
                                                class="form-control form-control-lg" id="code" label="code"
                                                required placeholder="Code">
                                        </div>
                                    </div>
                                    <input type="hidden" id="add_code_url"
                                        value="{{ route('admin.add_edit_courier_code') }}">
                                    <input type="hidden" id="type" value="add">
                                </form>
                            </div>
                            <div class="col-md-12 text-center mt-1">
                                <div class="d-flex justify-content-center w-100">
                                    <button type="button" class="btn btn-secondary-orio mr-3 my-3" data-dismiss="modal"
                                        aria-label="Close">Close</button>
                                    <a href="javascript:;" class="btn btn-sm btn-orio my-3"
                                        data-form-id="edit_sales_men_from" id="add-code-btn">Add Couriers Code</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- courier code edit  --}}
        <div class="modal fade" id="code_edit_modal" role="dialog" aria-labelledby="editsucessModal"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered w-800" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6 class="modal-title" id="modal-title-default">View Couriers Code</h6>
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
                        <div id="append">

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-secondary-orio" data-dismiss="modal"
                            aria-label="Close">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="app-content--inner">
            <div class="pb-4 text-center text-xl-left">
                <div class="row align-items-center">
                    <div class="col-xl-5">
                       <div>
                            <h5 class="title-text mb-1">{{ $title }}</h5>
                             <p class="sub-title-text mb-0">Please see list of {{ strtolower($title) }} below</p>
                        </div>
                    </div>
                    <div class="col-xl-7 d-flex align-items-center justify-content-start mt-xl-0 justify-content-xl-end">
                        <button class="btn btn-secondary-orio mr-2" data-toggle="modal" data-target="#add_modal"> Add
                            {{ $title }}</button>
                        <button class="btn btn-sm btn-secondary py-2 mr-2" data-toggle="modal" data-target="#code_modal">
                            <svg data-toggle="tooltip" title="Add courier code" fill="#000000" height="30px" width="30px" version="1.1" id="Layer_1"
                                xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                viewBox="0 0 64 64" enable-background="new 0 0 64 64" xml:space="preserve">
                                <g id="SVGRepo_bgCarrier" stroke-width="10%"></g>
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                <g id="SVGRepo_iconCarrier">
                                    <g id="Bulleted-list-frame_1_">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M50.5556602,0.00975H13.4443502 c-2.9970999,0-5.4345999,2.4756-5.4345999,5.5195003v52.9413986c0,3.0439987,2.4375,5.5195999,5.4345999,5.5195999h37.1113091 c2.9970894,0,5.4345894-2.4756012,5.4345894-5.5195999V5.5292501C55.9902496,2.4853499,53.5527496,0.00975,50.5556602,0.00975z M54.0097504,58.4706497c0,1.9511986-1.5498009,3.5391006-3.4540901,3.5391006H13.4443502 c-1.9042997,0-3.4540997-1.5879021-3.4540997-3.5391006V5.5292501c0-1.9511001,1.5497999-3.539,3.4540997-3.539h37.1113091 c1.9042892,0,3.4540901,1.5879,3.4540901,3.539V58.4706497z">
                                        </path>
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M45.9999504,17.0136509h-16 c-0.5449009,0-0.9862919,0.4413986-0.9862919,0.9862995c0,0.5450001,0.441391,0.9863987,0.9862919,0.9863987h16 c0.5449982,0,0.9864006-0.4413986,0.9864006-0.9863987C46.986351,17.4550495,46.5449486,17.0136509,45.9999504,17.0136509z">
                                        </path>
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M45.9999504,31.0136509h-16 c-0.5449009,0-0.9862919,0.4413986-0.9862919,0.9862995c0,0.5449982,0.441391,0.9864006,0.9862919,0.9864006h16 c0.5449982,0,0.9864006-0.4414024,0.9864006-0.9864006C46.986351,31.4550495,46.5449486,31.0136509,45.9999504,31.0136509z">
                                        </path>
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M45.9999504,45.013649h-16c-0.5449009,0-0.9862919,0.4414024-0.9862919,0.9863014 c0,0.5449982,0.441391,0.9864006,0.9862919,0.9864006h16c0.5449982,0,0.9864006-0.4414024,0.9864006-0.9864006 C46.986351,45.4550514,46.5449486,45.013649,45.9999504,45.013649z">
                                        </path>
                                        <circle fill-rule="evenodd" clip-rule="evenodd" cx="19.9999504" cy="17.9999008"
                                            r="2.9999499"></circle>
                                        <circle fill-rule="evenodd" clip-rule="evenodd" cx="19.9999504" cy="31.9999504"
                                            r="3"></circle>
                                        <circle fill-rule="evenodd" clip-rule="evenodd" cx="19.9999504" cy="45.9999504"
                                            r="3"></circle>
                                    </g>
                                </g>
                            </svg>
                        </button>
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
                        <b>List of <span class="text-lowercase">{{ $title }}</span></b>
                    </div>
                </div>
                <table id="example" class="example2 display nowrap table table-hover" width="100%">
                    <thead class="thead">
                        <tr>
                            <th>SNO</th>
                            <th>courier</th>
                            <th>account title</th>
                            <th>account no</th>
                            <th>USER</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>

    @section('scripts')
        <script src="{{ asset('assets/js/admin/modules.js') }}"></script>
        <script src="{{ asset('assets/js/courier_code/code.js') }}"></script>
    @endsection
@endsection
