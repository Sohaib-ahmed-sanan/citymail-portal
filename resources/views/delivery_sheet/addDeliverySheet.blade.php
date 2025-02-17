@extends('layout.main')
@section('content')
    <div class="app-content">
        <div class="app-content--inner">
            <div class="pb-4 text-center text-xl-left">
                <div class="row align-items-center">
                    <div class="col-xl-6">
                        <div>
                            <h5 class="title-text mb-1">{{ $title }}</h5>
                             <p class="sub-title-text mb-0">{{ $title }} below by filling the form</p>
                        </div>
                    </div>
                    @if ($type == 'edit')
                        <div
                            class="col-xl-6 d-flex align-items-center justify-content-start mt-xl-0 justify-content-xl-end">
                            <div class="mx-auto mx-xl-0 mt-3 btn-wrapper">
                                <button type="button" class="btn btn-secondary-orio float-right" id="update-btn">Update</button>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            <div class="catalogue-wrapper">
                <div class="row">
                    <div class="col-12">
                        <div class="card card-box mb-5">
                            <div class="card-header">
                                <div class="card-header--title">
                                    <b>{{ $title }}: {{ $type == 'edit' ? ' ' . $sheet_no : '' }}</b>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="no-gutters row">
                                    <div class="col-md-12">
                                        @if ($type != 'edit')
                                            <div class="order-filter-wrapper p-3 mb-3 border-bottom">
                                                <form action="#" data-parsley-validate id="search_form" method="post">
                                                    <div class="row">
                                                        <div class="col-md-4" data-select2-id="5">
                                                            <label for="riders_id">Select Rider<span
                                                                    class="req">*</span></label>
                                                            <select required
                                                                class=" form-control form-select riders_id form-control-lg input_field "
                                                                id="riders_id" data-toggle="select2" name="riders_id"
                                                                size="1" label="Select Rider"
                                                                data-placeholder="Select Rider" data-allow-clear="1">
                                                                <option value="">Select Rider</option>
                                                                @foreach ($riders as $rider)
                                                                    <option value="{{ $rider->id }}">
                                                                        {{ $rider->first_name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-4" data-select2-id="5">
                                                            <label for="route_id">Select Routes<span
                                                                    class="req">*</span></label>
                                                            <select required
                                                                class=" form-control form-select riders_id form-control-lg input_field"
                                                                id="route_id" data-toggle="select2" name="route_id"
                                                                size="1" label="Select Routes"
                                                                data-placeholder="Select Routes" data-allow-clear="1">
                                                                <option value="">Select Routes</option>
                                                                @foreach ($rouets as $route)
                                                                    <option value="{{ $route->id }}">
                                                                        {{ $route->address }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-4 ">
                                                            <label for="shipment_no">Consignment No<span
                                                                    class="req">*</span></label>
                                                            <input minlength="8" maxlength="9" data-parsley-type="integer"
                                                                type="int" class="form-control form-control-lg number"
                                                                id="shipment_no" name="shipment_no"
                                                                placeholder="Enter Consignment No" value="">
                                                        </div>
                                                        <div class="col-md-4 mt-2" >
                                                            <label for="status_all">Select Status</label>
                                                            <select
                                                                class=" form-control form-select status_all form-control-lg input_field"
                                                                id="status_all" data-toggle="select2" name="status_all"
                                                                size="1" label="Select Status"
                                                                data-placeholder="Select Status" data-allow-clear="1">
                                                                <option value="">Select Status</option>
                                                                @foreach (session('status') as $status)
                                                                    @if (!in_array($status->id, [1, 4, 2, 21, 22, 23, 17]))
                                                                        <option value="{{ $status->id }}">
                                                                            {{ $status->name }}</option>
                                                                    @endif
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-4 offset-8">
                                                            <button type="button"
                                                                class="btn btn-secondary-orio my-2 float-right d-none"
                                                                id="save-btn">Save</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        @endif
                                        <div style="overflow-x: scroll">
                                            <table id="display_tabel" class="example2 nowrap table table-hover"
                                                width="100%">
                                                <thead class="thead">
                                                    <tr>
                                                        <th>Consignment No #</th>
                                                        <th>CUSTOMER NAME</th>
                                                        <th>SHIPPER NAME</th>
                                                        <th>CONSIGNEE NAME</th>
                                                        <th>SHIPMENT REFERANCE</th>
                                                        <th>DESTINATION</th>
                                                        <th>PEICES CHARGED</th>
                                                        <th>WEIGHT CHARGED</th>
                                                        <th>CURRENCY CODE</th>
                                                        <th>ORDER AMMOUNT</th>
                                                        <th>STATUS</th>
                                                        <th>Remarks</th>
                                                        @if ($type != 'edit')
                                                            <th>ACTION</th>
                                                        @endif
                                                    </tr>
                                                </thead>
                                                <tbody id="delivery_list">
                                                    @if ($type == 'edit')
                                                        <form action="#" data-parsley-validate method="post"
                                                            id="update_delivery_sheet">
                                                            @foreach ($details as $row)
                                                                <tr>
                                                                    <td class="cn_no">{{ $row->consignment_no }}</td>
                                                                    <td>{{ $row->business_name . ' (' . $row->acno . ')' }}</td>
                                                                    <td>{{ $row->shipper_name }}</td>
                                                                    <td>{{ $row->consignee_name }}</td>
                                                                    <td>{{ $row->shipment_referance }}</td>
                                                                    <td>{{ $row->destination_city }}</td>
                                                                    <td>{{ $row->peices_charged }}</td>
                                                                    <td>{{ $row->weight_charged }}</td>
                                                                    <td>{{ $row->orignal_currency_code }}</td>
                                                                    <td>{{ $row->orignal_order_amt }}</td>
                                                                    <td>
                                                                        <select
                                                                            class=" form-control form-select status_id form-control-lg input_field"
                                                                            id="status_id{{ $loop->iteration }}"
                                                                            data-toggle="select2" name="status_id[]"
                                                                            size="1{{ $loop->iteration }}"
                                                                            label="Select Delivery Status"
                                                                            data-placeholder="Select Delivery Status"
                                                                            data-allow-clear="1" required
                                                                            {{ in_array($row->status, ['14', '16']) ? 'disabled' : '' }}>
                                                                            <option value="">Select Delivery Status
                                                                            </option>
                                                                            @foreach (session('status') as $status)
                                                                                @if (!in_array($status->id, [1, 4, 2, 21, 22, 23, 17]))
                                                                                    <option
                                                                                        {{ $row->details_status == $status->id ? 'selected' : '' }}
                                                                                        value="{{ $status->id }}">
                                                                                        {{ $status->name }}
                                                                                    </option>
                                                                                @endif
                                                                            @endforeach
                                                                        </select>
                                                                    </td>
                                                                    <td>
                                                                        <input style="width: 200px" data-parsley-type="srting" type="text"
                                                                            class="form-control" id="remarks"
                                                                            required="true" name="remarks[]"
                                                                            placeholder="Enter Remarks"
                                                                            value="{{ $row->sheet_remarks }}"
                                                                            {{ in_array($row->status, ['14', '16']) ? 'disabled' : '' }}>
                                                                    </td>
                                                                    <td class="d-none">
                                                                        <input type="hidden" name="current_status[]"
                                                                            value="{{ $row->status }}">
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </form>
                                                    @else
                                                        <tr id="def_msg" class="text-center">
                                                            <td colspan="12">No Records Found</td>
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
    </div>
    <script>
        var listRoute = "";
    </script>
    @if ($type == 'add')
        <script>
            var storeUrl = "{{ route('admin.add_edit_deliverySheet') }}";
        </script>
    @endif
    @if ($type == 'edit')
        <script>
            var id = {{ isset($sheet_no) ? $sheet_no : '' }};
            var storeUrl = "{{ route('admin.add_edit_deliverySheet', ['id' => ':id']) }}".replace(':id', id);
        </script>
    @endif
@section('scripts')
    <script src="{{ asset('assets/js/delivery_sheet/delivery_sheet.js') }}"></script>
@endsection
@endsection
