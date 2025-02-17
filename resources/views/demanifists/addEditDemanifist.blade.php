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
                                    <b>{{ $title }}:</b>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="no-gutters row">
                                    <div class="col-md-12">
                                        @if ($type != 'edit')
                                            <div class="order-filter-wrapper p-3 mb-3 border-bottom">
                                                <form action="#" data-parsley-validate id="search_form" method="post">
                                                    <div class="row">
                                                        <div class="col-md-3" data-select2-id="5">
                                                            <label for="riders_id">Select Station<span
                                                                    class="req">*</span></label>
                                                            <select required
                                                                class=" form-control form-select station_id form-control-lg input_field "
                                                                id="station_id" data-toggle="select2" name="station_id"
                                                                size="1" label="Select Station"
                                                                data-placeholder="Select Station" required
                                                                data-allow-clear="1">
                                                                <option value="">Select Station</option>
                                                                @foreach ($stations as $station)
                                                                    <option value="{{ $station->id }}"
                                                                        {{ isset($manifists[0]->station_id) && $manifists[0]->station_id == $station->id ? 'selected' : '' }}>
                                                                        {{ $station->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        {{-- <div class="col-md-3" data-select2-id="5">
                                                            <label for="rider_id">Select Rider<span
                                                                    class="req">*</span></label>
                                                            <select required
                                                                class=" form-control form-select riders_id form-control-lg input_field "
                                                                id="rider_id" data-toggle="select2" name="rider_id"
                                                                size="1" label="Select Rider"
                                                                data-placeholder="Select Rider" data-allow-clear="1">
                                                                <option value="">Select Rider</option>
                                                                @foreach ($riders as $rider)
                                                                    <option
                                                                        {{ isset($manifists[0]->rider_id) && $manifists[0]->rider_id == $rider->id ? 'selected' : '' }}
                                                                        value="{{ $rider->id }}">
                                                                        {{ $rider->first_name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div> --}}
                                                        <div class="col-md-3" data-select2-id="5">
                                                            <label for="seal_no">Seal No<span
                                                                    class="req">*</span></label>
                                                            <input minlength="5" maxlength="20" type="text"
                                                                class="form-control form-control-lg" id="seal_no"
                                                                name="seal_no" placeholder="Enter Seal No" value=""
                                                                required="true">
                                                        </div>
                                                        <div class="col-md-3 d-none" data-select2-id="5">
                                                            <label for="batch_name">Batch Name<span
                                                                    class="req">*</span></label>
                                                            <input type="text" readonly
                                                                class="form-control form-control-lg" id="batch_name">
                                                        </div>
                                                        <div class="col-md-3" data-select2-id="5">
                                                            <label for="shipment_no">Consignment No</label>
                                                            <input minlength="8" maxlength="9" data-parsley-type="integer"
                                                                type="int" class="form-control form-control-lg number"
                                                                id="shipment_no" name="shipment_no"
                                                                placeholder="Enter Consignment No" value="">
                                                        </div>
                                                        <div class="col-md-8 mt-4 offset-md-4">
                                                            <button type="button"
                                                                class="d-none btn btn-orio my-2 float-right"
                                                                id="save-btn">Save</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        @endif
                                        <table class="example2 display nowrap table table-hover" width="100%">
                                            <thead class="thead">
                                                <tr>
                                                    <th>Consignment #</th>
                                                    <th>CUSTOMER NAME</th>
                                                    <th>SHIPPER NAME</th>
                                                    <th>CONSIGNEE NAME</th>
                                                    <th>DESTINATION CITY</th>
                                                    <th>REFERANCE</th>
                                                    @if ($type != 'edit')
                                                        <th>ACTION</th>
                                                    @endif
                                                </tr>
                                            </thead>
                                            <tbody id="demanifist_list">
                                                @if ($type == 'edit')
                                                    @foreach ($de_manifist as $data)
                                                        <tr>
                                                            <td>
                                                                {{ $data->consignment_no }}
                                                            </td>
                                                            <td>
                                                                {{ $data->customer_name }}
                                                            </td>
                                                            <td>
                                                                {{ $data->shipper_name }}
                                                            </td>
                                                            <td>
                                                                {{ $data->consignee_name }}
                                                            </td>
                                                            <td>
                                                                {{ $data->destination_city }}
                                                            </td>
                                                            <td>
                                                                {{ $data->ref }}
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @else
                                                    <tr id="def_msg" class="text-center">
                                                        <td colspan="8">No Records Found</td>
                                                    </tr>
                                                @endif
                                            </tbody>
                                            <tfoot class="mt-3">
                                                <tr>
                                                    <td>Total</td>
                                                    <td id="total">{{ $type == 'edit' ? count($de_manifist) : '' }}
                                                    </td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                        <form action="" method="post" id="insert_de_manifist">
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
    </script>
    @if ($type == 'edit')
        <script>
            var id = {{ isset($manifists[0]->manifist_id) ? $manifists[0]->manifist_id : '' }};
            var storeUrl = "{{ route('admin.add_edit_de_manifist', ['id' => ':id']) }}".replace(':id', id);
        </script>
    @endif
    @if ($type == 'add')
        <script>
            var storeUrl = "{{ route('admin.add_edit_de_manifist') }}";
        </script>
    @endif
@section('scripts')
    <script src="{{ asset('assets/js/de_manifists/de_manifist.js') }}"></script>
@endsection
@endsection
