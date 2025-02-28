@extends('layout.main')
@section('content')
    <div class="app-content">
        <div class="app-content--inner">
            <div class="pb-4 text-center text-xl-left">
                <div class="row align-items-center">
                    <div class="col-xl-6">
                        <div>
                            <h5 class="title-text mb-1">{{ $title }}</h5>
                             <p class="sub-title-text mb-0">{{ ucfirst(strtolower($title)) }} by filling the form below</p>
                        </div>
                    </div>
                    <div class="col-6">
                        <button class="btn btn-orio  float-right mb-3 update_sheet_btn"
                        id="update_sheet" type="submit">Update Sheet</button>
                    </div>
                </div>
            </div>
            <div class="card card-box mb-3">
                <div class="card-header">
                    <div class="card-header--title">
                        <b>List of {{ strtolower($title) }}</b>
                    </div>
                </div>
                <div class="card-body">
                    <div class="no-gutter">
                        <div class="col-md-12">
                            
                            <table class="example2 table table-hover" width="100%">
                                <thead class="thead">
                                    <tr>
                                        <th>consignment no</th>
                                        <th>SHIPPER NAME</th>
                                        <th>CONSIGNEE NAME</th>
                                        <th>DESTINATION CITY</th>
                                        <th>REFERANCE</th>
                                        <th>PEICES</th>
                                        <th>WEIGHT</th>
                                    </tr>
                                </thead>
                                <tbody id="arrival_list">
                                    <form action="#" method="post" id="edit_sheet_form" data-parsley-validate>
                                        @foreach ($arrivals as $arrival)
                                            <tr>
                                                <td>{{ $arrival->cn_numbers }}</td>
                                                <input type="hidden" name="cn_no[]" value="{{ $arrival->cn_numbers }}">
                                                <input type="hidden" name="flag[]" value="{{ $arrival->shipment_type }}">
                                                <input type="hidden" name="service_id[]" value="{{ $arrival->service_id }}">
                                                <input type="hidden" name="cod_amt[]" value="{{ $arrival->cod_amt }}">
                                                <input type="hidden" name="origin_country[]" value="{{ $arrival->origin_country }}">
                                                <input type="hidden" name="origin_city[]" value="{{ $arrival->origin_city }}">
                                                <td>
                                                    <input disabled type="text" required name="shipper_name" disabled class="form-control"
                                                        value="{{ $arrival->shipper_name }}">
                                                </td>
                                                <td>
                                                    <input type="text" required name="consignee_name" disabled class="form-control"
                                                        value="{{ $arrival->consignee_name }}">
                                                </td>
                                                <td style="width: 16%;">
                                                    <select required
                                                        class="form-control form-select form-control-lg input_field"
                                                        id="" data-toggle="select2" name=""
                                                        size="1" label="Select Destination"
                                                        data-placeholder="Select Destination" disabled data-allow-clear="1">
                                                        <option value="">Select Destination</option>
                                                        @foreach ($cities as $city)
                                                            <option value="{{ $city->id }}"
                                                                {{ $arrival->destination_city == $city->id ? 'selected' : '' }}>
                                                                {{ $city->city }}</option>
                                                        @endforeach
                                                    </select>
                                                    <input type="hidden" name="destination_country[]" value="{{ $arrival->destination_country }}">
                                                    <input type="hidden" name="destination_city[]" value="{{ $arrival->destination_city }}">
                                                </td>
                                                <td>
                                                    <input type="text" required name="shipment_referance" disabled class="form-control"
                                                        value="{{ $arrival->shipment_referance }}">
                                                </td>
                                                <td width="15%">
                                                    <input type="text" required name="peices[]" class="form-control float"
                                                        value="{{ $arrival->peices }}">
                                                </td>
                                                <td width="15%">
                                                    <input type="text" required name="weight[]" class="form-control float"
                                                        value="{{ $arrival->weight }}">
                                                </td>
                                            </tr>
                                        @endforeach
                                    </form>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <script>
                var page_type = "edit"; 
                var storeUrl = "{{ Route('admin.add_edit_arrivals') }}"; 
            </script>
        @section('scripts')
            <script src="{{ asset('assets/js/arrivals/arrivals.js') }}"></script>
        @endsection
    @endsection
