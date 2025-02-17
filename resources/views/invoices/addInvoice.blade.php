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
                                        <form action="#" data-parsley-validate id="invoice_form" method="post">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <label for="invoice_date">Select Invoice Date<span
                                                            class="req">*</span></label>
                                                    <input type="text" class="form-control form-control-lg" readonly
                                                        placeholder="1-01-2000" data-toggle="datepicker" required
                                                        name="invoice_date" id="invoice_date">
                                                </div>
                                                @if (session('company_type') == 'D')
                                                    <div class="col-md-3">
                                                        <label for="cheque_no">Cheque No<span
                                                                class="req">*</span></label>
                                                        <input minlength="3" maxlength="8" data-parsley-type="integer"
                                                            type="int" class="form-control form-control-lg number"
                                                            id="cheque_no" name="cheque_no" placeholder="Enter Cheque No"
                                                            value="" required="true">
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label for="cheque_title">Cheque Title<span
                                                                class="req">*</span></label>
                                                        <input minlength="2" maxlength="10" type="text"
                                                            class="form-control form-control-lg" id="cheque_title"
                                                            name="cheque_title" placeholder="Enter Cheque Title"
                                                            value="" required="true">
                                                    </div>
                                                @elseif (session('company_type') == 'I')
                                                    <div class="col-md-3" data-select2-id="5">
                                                        <label for="riders_id">Select Payment Type<spanclass="req">*</span></label>
                                                        <select required
                                                            class=" form-control form-select payment_type form-control-lg input_field "
                                                            id="payment_type" data-toggle="select2" name="payment_type"
                                                            size="1" label="Select Payment Type"
                                                            data-placeholder="Select Payment Type" data-allow-clear="1">
                                                            <option value="">Select Payment Type</option>
                                                            <option value="bank">Bank</option>
                                                            <option value="cash">Cash</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label for="cheque_title">Referance<span class="req">*</span></label>
                                                        <input minlength="2" maxlength="20" type="text"
                                                            class="form-control form-control-lg" id="referance"
                                                            name="referance" placeholder="Enter Referance"
                                                            value="" required="true">
                                                    </div>
                                                @endif
                                                <div class="col-md-3" data-select2-id="5">
                                                    <label for="riders_id">Select Customer<span
                                                            class="req">*</span></label>
                                                    <select required
                                                        class=" form-control form-select customer_filter form-control-lg input_field "
                                                        id="customer_acno" data-toggle="select2" name="customer_acno"
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
                                            </div>
                                            <div class="row mt-3">
                                                <div class="col-md-3">
                                                    <label for="from_date">Select From Date<span
                                                            class="req">*</span></label>
                                                    <input type="text" readonly class="date_picker form-control form-control-lg"
                                                        placeholder="1-01-2000" data-toggle="datepicker" required
                                                        name="from_date" id="from_date">
                                                </div>
                                                <div class="col-md-3">
                                                    <label for="to_date">Select To Date<span
                                                            class="req">*</span></label>
                                                    <input type="text" placeholder="1-01-2000" required
                                                        class="date_picker form-control form-control-lg" readonly
                                                        data-toggle="datepicker" name="to_date" id="to_date">
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <button type="button"
                                                    class="btn btn-secondary-orio my-2 float-right"
                                                    id="search-btn">Search</button>
                                            </div>
                                            <div class="col-md-12">
                                                <button type="button"
                                                    class="d-none btn btn-orio my-2 float-right mr-3" id="save-btn">Save</button>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="col-md-12">
                                        <div style="overflow-x: scroll">
                                            <table class="invoiceTabel display nowrap table table-hover mt-4" width="100%">
                                                <thead class="thead">
                                                    <tr>
                                                        <th></th>
                                                        <th>SNO</th>
                                                        <th>Consignment No</th>
                                                        <th>Booking Date</th>
                                                        <th>Consignee Name</th>
                                                        <th>Reference</th>
                                                        <th>Destination City</th>
                                                        <th>Status</th>
                                                        <th>COD Value</th>
                                                        <th>Service Charges</th>
                                                        <th>RTO Charges</th>
                                                        <th>Cash Handling Charges</th>
                                                        <th>GST Charges</th>
                                                        <th>SST Charges</th>
                                                        <th>BAC Charges</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="display-details">
                                                    <tr id="def_msg" class="text-center">
                                                        <td colspan="12">No Records Found</td>
                                                    </tr>
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <td>Total </td>
                                                        <td class="total-row"></td>
                                                        <td colspan="6"></td>
                                                        <td class="total-cod"></td>
                                                        <td class="total-service"></td>
                                                        <td class="total-rto"></td>
                                                        <td class="total-cash"></td>
                                                        <td class="total-gst"></td>
                                                        <td class="total-sst"></td>
                                                        <td class="total-bac"></td>
                                                    </tr>
                                                </tfoot>
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
    </div>
    <script>
        var listRoute = "";
        var searchUrl = "{{ route('admin.fetch_invoice_data') }}";
        var storeUrl = "{{ route('admin.store_invoice_data') }}";
    </script>

@section('scripts')
    <script src="{{ asset('assets/js/Invoices/Invoice.js') }}"></script>
@endsection
@endsection
