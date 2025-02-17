@extends('layout.main')
@section('content')
    <div class="app-content">
        <div class="app-content--inner">
            <div class="pb-4 text-center text-xl-left">
                <div class="row">
                    <div class="col-xl-7">
                         <div>
                            <h5 class="title-text mb-1">Bulk Booking</h5>
                             <p class="sub-title-text mb-0">upload bulk shipments via excel</p>
                        </div>
                    </div>
                </div>
            </div>
            <form role="form" id="excel_upload" data-parsley-validate method="POST" enctype="multipart/form-data">
                <div class="orders-reporting-wrapper">
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card card-box mb-5">
                                <div class="card-header bg-light">
                                    <div class="card-header--title">
                                        <small class="d-block text-uppercase mt-1">Upload Orders</small>
                                        <b>Upload your all orders via xls file.</b>
                                    </div>
                                </div>
                                <div class="no-gutters row">
                                    <div class="col-lg-7 p-4">
                                        <div class="divider-v divider-v-lg"></div>
                                        <div class="row">
                                            {{-- @if (is_portal())
                                                <div class="mb-3 col-md-6">
                                                    <label class="form-label" for="" id="">Make for Sub
                                                        account</label>
                                                    <select class=" form-control form-select form-control-lg    "
                                                        id="is-sub-account" data-toggle="select2" name=""
                                                        size="1" label="Make for Sub account"
                                                        data-placeholder="Make for Sub account" data-allow-clear="1">
                                                        <option value="0">NO</option>
                                                        <option value="1">YES</option>
                                                    </select>
                                                </div>
                                                <input type="hidden" id="account_id" value="{{ session('acno') }}">
                                                <div class="mb-3 col-md-6 d-none" id="sub_account">
                                                    <label class="form-label" for="account_id" id="">Select Sub
                                                        Account</label>
                                                    <select class="form-control form-select account_id form-control-lg"
                                                        id="sub-acc-select" data-toggle="select2" name="sub_account"
                                                        size="1" label="Select Sub Account"
                                                        data-placeholder="Select Sub Account" data-allow-clear="1">
                                                        <option value="">Select Sub Account</option>
                                                        @foreach ($sub_accounts as $sub_account)
                                                            <option value="{{ $sub_account->id }}"
                                                                {{ isset($payload->sub_account_id) && $sub_account->id == $payload->sub_account_id ? 'selected' : '' }}>
                                                                {{ $sub_account->name }} </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            @elseif(is_customer_sub())
                                                <input type="hidden" class="account_id" name="sub_account" id="account_id"
                                                    value="{{ session('acno') }}">
                                            @endif --}}
                                        </div>

                                        <div class="form-row">
                                            <div class="form-group col-md-12">
                                                <label for="customFile">Booking Upload</label>
                                                <fieldset>
                                                    <div class="custom-file w-100">
                                                        <input type="file" required
                                                            class="form-control custom-file-input uploadFile" name="file"
                                                            id="file">
                                                        <label class="custom-file-label" for="file"
                                                            id="outputFile">Choose file...</label>
                                                    </div>
                                                </fieldset>
                                            </div>
                                        </div>
                                        <div class="form-row justify-content-center">
                                            <div class="form-group col-md-6 text-center">
                                                <button type="button" class="btn btn-orio"
                                                    id="uploadorder">Upload</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-5 p-4">
                                        <div class="divider-v divider-v-lg"></div>
                                        <div class="instruction-text-content">
                                            <h5 class="font-weight-bold text-uppercase">Uploading Format Information:</h5>
                                            <ul>
                                                <li>Upload the 'xls' Format File !</li>
                                                <li>Download Your Uploading File Format Here! <a
                                                        href="{{ asset('sample/Orio_BulkOrder.xls') }}">Click Here to
                                                        Download!</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            
            <div class="orders-reporting-wrapper">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card card-box mb-5">
                            <div class="no-gutters row">
                                <div class="col-lg-12 p-4">
                                    <div class="table-tab-content-wrapper">
                                        <ul class="nav nav-line nav-line-alt" id="myTab2" role="tablist">
                                            <li class="nav-item">
                                                <a class="nav-link text-uppercase font-size-xs active" id="home1-tab"
                                                    data-toggle="tab" href="#home1" role="tab" aria-controls="home"
                                                    aria-selected="true">
                                                    Upload Orders <span
                                                        class="badge badge-primary badge-pill d-none upload-badge">1</span>
                                                    <div class="divider"></div>
                                                </a>
                                            </li>

                                            <li class="nav-item">
                                                <a class="nav-link text-uppercase font-size-xs" id="profile1-tab"
                                                    data-toggle="tab" href="#profile1" role="tab"
                                                    aria-controls="profile" aria-selected="false">
                                                    Error Orders <span
                                                        class="badge rounded-pill bg-danger text-white d-none"
                                                        id="error_count"></span>
                                                    <div class="divider"></div>
                                                </a>
                                            </li>
                                        </ul>
                                        <div class="tab-content p-0 pt-3">
                                            <div class="tab-pane fade active show" id="home1" role="tabpanel"
                                                aria-labelledby="home1-tab">
                                                <table id="order_detail_tbl"
                                                    class="table table-hover table-striped table-bordered mb-5 table-responsive">
                                                    <thead style="width: 100% !important">
                                                        <tr>
                                                            <th>Consignment No</th>
                                                            <th>Customer Name</th>
                                                            <th>Customer Email</th>
                                                            <th>Customer Address</th>
                                                            <th>Customer Contact</th>
                                                            <th>Destination City</th>
                                                            <th>Shipment Ref</th>
                                                            <th>Order Amount</th>
                                                            <th>Total Peices</th>
                                                            <th>Total Weight</th>
                                                            <th>Print</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody style="width: 100% !important" id="order_detail">
                                                        <tr>
                                                            <td colspan="15">No Order has been uploaded</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="tab-pane fade" id="profile1" role="tabpanel"
                                                aria-labelledby="profile1-tab">
                                                <div class="form-row justify-content-right">
                                                    <div class="form-group col-md-6">
                                                        <button type="button" class="btn btn-secondary-orio d-none"
                                                            id="push_orders">Push Orders</button>
                                                    </div>
                                                </div>
                                                <table id="error_orders"
                                                    class="table table-hover table-striped table-bordered mb-5 table-responsive">
                                                    <thead>
                                                        <tr>
                                                            <th></th>
                                                            <th style="width: 100px">Flag</th>
                                                            <th>Customer Name</th>
                                                            <th>Customer Email</th>
                                                            <th>Customer Address</th>
                                                            <th>Customer Contact</th>
                                                            <th>Destination City</th>
                                                            <th>Shipment Ref</th>
                                                            <th>Order Amount</th>
                                                            <th>Total Peices</th>
                                                            <th>Total Weight</th>
                                                            <th>Comment</th>
                                                            <th>Insurance</th>
                                                            <th>Fragile</th>
                                                            <th>Product details</th>
                                                            <th>payment method</th>
                                                            <th>Service</th>
                                                            <th>Currency</th>
                                                            <th>Pickup location</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="error_order_detail">
                                                        <tr>
                                                            <td colspan="15">No Error Order has been uploaded</td>
                                                        </tr>
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

       {{-- pushed result modal --}}
        <div class="modal fade" id="push_modal" role="dialog" aria-labelledby="editsucessModal" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered w-800" role="document">
                <div class="modal-content">
                    <div class="modal-header border-0">
                        <h6 class="modal-title" id="modal-title-default">Pushed Shipments</h6>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="card card-box mb-5">
                                    <div class="no-gutters row">
                                        <div class="col-lg-12 p-4">
                                            <div class="table-tab-content-wrapper">
                                                <ul class="nav nav-line nav-line-alt" id="myTab2" role="tablist">
                                                    <li class="nav-item">
                                                        <a class="nav-link text-uppercase font-size-xs active"
                                                            id="success-tab" data-toggle="tab" href="#success"
                                                            role="tab" aria-controls="home" aria-selected="true">
                                                            Successful shipments <span
                                                                class="badge badge-primary badge-pill d-none upload-badge">1</span>
                                                            <div class="divider"></div>
                                                        </a>
                                                    </li>

                                                    <li class="nav-item">
                                                        <a class="nav-link text-uppercase font-size-xs" id="error-tab"
                                                            data-toggle="tab" href="#error" role="tab"
                                                            aria-controls="profile" aria-selected="false">
                                                            Error shipments<span
                                                                class="badge rounded-pill bg-danger text-white d-none"
                                                                id="error_count"></span>
                                                            <div class="divider"></div>
                                                        </a>
                                                    </li>
                                                </ul>
                                                <div class="tab-content p-0 pt-3">
                                                    <div class="tab-pane fade active show" id="success" role="tabpanel"
                                                        aria-labelledby="success-tab">
                                                        <div class="table-responsive"
                                                            style="min-height: 250px;max-height: 250px;overflow-y: auto;">
                                                            <table id="order_detail_tbl"
                                                                class="table table-hover table-striped table-bordered mb-5">
                                                                <thead>
                                                                    <tr>
                                                                        <th width="10%">#</th>
                                                                        <th width="25%">Shipment Referance</th>
                                                                        <th width="25%">Consignment No</th>
                                                                        <th width="20%">Message</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody id="display-success">

                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                    <div class="tab-pane fade" id="error" role="tabpanel"
                                                        aria-labelledby="error-tab">
                                                        <div class="table-responsive"
                                                            style="min-height: 250px;max-height: 250px;overflow-y: auto;">
                                                            <table id="error_orders"
                                                                class="table table-hover table-striped table-bordered mb-5">
                                                                <thead>
                                                                    <tr>
                                                                        <th width="10%">#</th>
                                                                        <th width="25%">Shipment Referance</th>
                                                                        <th width="20%">Message</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody id="display-error">

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
                        <div class="col-md-12 text-center mt-1">
                            <div class="d-flex justify-content-center w-100">
                                <button type="button" class="btn btn-sm btn-secondary-orio mr-3 my-3"
                                    data-dismiss="modal" aria-label="Close">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @section('scripts')
        <script src="{{ asset('assets/js/shipments/bulkUpload.js') }}"></script>
    @endsection
@endsection
