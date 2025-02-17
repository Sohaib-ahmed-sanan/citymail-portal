@extends('layout.main')

@section('content')
    {{-- cn_void modal --}}
    <div class="modal fade" id="cn_void_modal" role="dialog" aria-labelledby="editsucessModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered w-800" role="document">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <h6 class="modal-title" id="modal-title-default">Consignment void</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">
                            <svg viewBox="0 0 24 24" width="26" height="26" stroke="currentColor" stroke-width="2"
                                fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">
                                <line x1="18" y1="6" x2="6" y2="18"></line>
                                <line x1="6" y1="6" x2="18" y2="18"></line>
                            </svg>
                        </span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <form class="cancle-form" action="#" data-parsley-validate id="cancle-form" method="post">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="col-sm-12">
                                            <label for="cn_no">Consignment no<span class="req">*</span></label>
                                            <input required name="cn_no" type="text"
                                                class="form-control form-control-lg" id="cn_no" data-role="tagsinput"
                                                id="">
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-12 text-center mt-1">
                            <div class="d-flex justify-content-center w-100">
                                <button type="button" class="btn btn-sm btn-secondary-orio mr-3 my-3" data-dismiss="modal"
                                    aria-label="Close">Close</button>
                                <button type="button" id="cancle-btn" href="#"
                                    class="btn btn-orio my-3">Submit</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- filter modal --}}
    <div class="modal fade" id="filter_modal" role="dialog" aria-labelledby="filterModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered w-800" role="document">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <h6 class="modal-title" id="modal-title-default">Apply Filter</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">
                            <svg viewBox="0 0 24 24" width="26" height="26" stroke="currentColor" stroke-width="2"
                                fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">
                                <line x1="18" y1="6" x2="6" y2="18"></line>
                                <line x1="6" y1="6" x2="18" y2="18"></line>
                            </svg>
                        </span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <form id="filter_form" method="post">
                                <div class="form-row flex-column justify-content-center align-items-center">
                                    @if (is_ops())
                                        <div class="col-md-10 mb-3 px-3">
                                            <select
                                                class=" form-control form-select customer_filter form-control-lg input_field "
                                                id="customer_filter" data-toggle="select2" name="customer_filter"
                                                size="1" label="Select Customer" data-placeholder="Select Customer"
                                                data-allow-clear="1">
                                                <option value="">Select Customer</option>
                                                @foreach ($customers as $customer)
                                                    <option value="{{ $customer->acno }}">{{ $customer->business_name }}
                                                        ({{ $customer->acno }})
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    @endif
                                    {{-- @if (is_portal())
                                        <div class="col-md-12 mb-3" data-select2-id="26">
                                            <select
                                                class=" form-control form-select customer_filter form-control-lg input_field "
                                                id="sub_acc_filter" data-toggle="select2" name="sub_acc_id"
                                                size="1" label="Select Sub Account" data-placeholder="Select Sub Account"
                                                data-allow-clear="1">
                                                <option value="">Select Sub Account</option>
                                                @foreach ($sub_accounts as $sub_account)
                                                    <option value="{{ $sub_account->id }}">{{ $sub_account->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    @endif --}}
                                    <div class="mb-3 col-md-10 px-3">
                                        <select required
                                            class=" form-control form-control-lg form-select country_id form-control form-control-lg-lg input_field "
                                            id="country_id" data-toggle="select2" name="country_id" size="1"
                                            label="Select Destination Country"
                                            data-placeholder="Select Destination Country" data-allow-clear="1">
                                            <option value="">Select Destination Country</option>
                                            @foreach ($countries as $country)
                                                <option value="{{ $country->id }}"
                                                    {{ isset($payload->destination_country) && $country->id == $payload->destination_country ? 'selected' : '' }}>
                                                    {{ $country->country_name }} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-10 mb-3 px-3">
                                        <select class=" form-control form-select city_id form-control-lg input_field "
                                            id="destination_id" data-toggle="select2" name="destination_id"
                                            size="1" label="Select Destination City"
                                            data-placeholder="Select Destination City" data-allow-clear="1">
                                            <option value="">Select Destination City</option>
                                            @foreach ($cities as $city)
                                                <option value="{{ $city->id }}">{{ $city->city }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-10 mb-3 px-3">
                                        <select class=" form-control form-select country_id form-control-lg input_field "
                                            id="status_id" data-toggle="select2" name="status_id" size="1"
                                            label="Select Delivery Status" data-placeholder="Select Delivery Status"
                                            data-allow-clear="1">
                                            <option value="">Select Delivery Status</option>
                                            @foreach (session('status') as $status)
                                                <option value="{{ $status->id }}">
                                                    {{ $status->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="col-md-12 text-center mt-1">
                            <div class="d-flex justify-content-center w-100">
                                <button type="button" class="btn btn-secondary-orio mr-3 my-3" id="resetFilter">Reset
                                    Filter</button>
                                <button type="button" class="btn btn-orio my-3" id="apply_filters"
                                    data-startdate="2024-01-21" data-enddate="2024-01-24">Apply Filter</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
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
                        <button class="btn btn-sm btn-custom mr-2" data-toggle="modal" data-target="#filter_modal">
                            <img src="{{ asset('assets/icons/Apply Filter.svg') }}">
                        </button>
                        <button class="btn btn-sm btn-custom mr-2" data-toggle="modal" data-target="#cn_void_modal">
                         <img src="{{ asset('assets/icons/Delete.svg') }}">
                        </button>
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

            <div class="card card-box mb-3">
                <div class="card-header">
                    <div class="card-header--title">
                        <b>List of {{ strtolower($title) }}</b>
                    </div>
                </div>

                <div id="append_btn_div" class="d-none">
                    <div class="btn-group btn-group-split px-2 py-3" id="append_btn_div">
                        <div id="create-btn-div" class="icn-container float-left pl-4">
                            <div class="hover-icon" id="hover-icon-1-584">
                                @if (session('is_loadsheet') == 1)
                                    <a href="javascript:void(0);" id="generate_loadSheet"
                                        class="btn btn-sm btn-secondary-sm mr-2 " style="background-color: #e4e6eb"
                                        data-toggle="tooltip" data-original-title="Generate LoadSheet"><i
                                            class="fa-solid fa-sheet-plastic"></i></a>
                                @endif
                                <a href="javascript:void(0);" id="print_airway" class="btn btn-sm btn-secondary-sm mr-2 "
                                    style="background-color: #e4e6eb" data-toggle="tooltip"
                                    data-original-title="Print Bulk AirwayBills"><i class="fas fa-print"></i></a>
                            </div>
                        </div>
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
                            <th>ACNO</th>
                            <th>Customer Name</th>
                            <th>Consignment No</th>
                            @if (is_ops())
                                <th>TPL No</th>
                            @endif
                            <th>CONSIGNEE NAME</th>
                            <th>CONSIGNEE EMAIL</th>
                            <th>CONSIGNEE PHONE</th>
                            <th>SHIPMENT REF</th>
                            <th>Destination Country</th>
                            <th>Destination City</th>
                            <th>CONSIGNEE ADDRESS</th>
                            <th>PARCEL DETAIL</th>
                            <th>AMOUNT</th>
                            <th>CURRENCY</th>
                            <th>CONVERTED AMOUNT</th>
                            <th>CONVERTED CURRENCY</th>
                            <th>PEICES</th>
                            <th>WEIGHT</th>
                            <th>Booked At</th>
                             <th>LAST STATUS AT</th>
                            <th>STATUS</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div>

        @section('scripts')
            <script>
                var listRoute = "{{ Route('admin.manualBooking') }}";
                var sessionType = "{{ session('type') }}";
                var route = "{{ route('admin.cancle_cn') }}";
                var pageType = "";
            </script>
            <script src="{{ asset('assets/js/shipments/manual_booking.js') }}"></script>
            <script src="https://cdn.datatables.net/fixedcolumns/4.0.1/js/fixedColumns.bootstrap4.min.js"></script>
        	<script src="https://cdn.datatables.net/fixedcolumns/4.0.1/js/dataTables.fixedColumns.min.js"></script>
            <script src="https://cdn.datatables.net/fixedheader/4.0.1/js/dataTables.fixedHeader.js"></script>
            <script src="https://cdn.datatables.net/fixedheader/4.0.1/js/fixedHeader.dataTables.js"></script>
        @endsection

    @endsection
