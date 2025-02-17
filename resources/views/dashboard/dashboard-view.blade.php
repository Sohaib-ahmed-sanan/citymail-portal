<div class="pb-4 text-center text-xl-left">
    <div class="row">
        <div class="col-xl-7">
            <div>
                <h5 class="title-text mb-1">DASHBOARD -
                    {{ is_ops() ? 'OPS ' : 'PORTAL' }}</h5>
                @if (session('company_name') != '')
                    <p class="sub-title-text mb-0">Welcome To {{ strtoupper(session('company_name')) ?? '' }}</p>
                @endif
            </div>
        </div>
        <div class="col-xl-5 d-flex align-items-center justify-content-start mt-4 mt-xl-0 justify-content-xl-end">
            <div class="card-header--actions">
                <div class="mx-auto mx-xl-0">
                    <div class="d-inline-block btn-group btn btn-primary coursor-pointer">
                        <div id="datepicker">
                            <span class="date_title"></span>
                            <span class="date_range mr-2"></span>
                            <i class="fa fa-caret-down"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- sparkline --}}
<div class="orders-reporting-wrapper mb-5">
    <div class="row">
        <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-lg-0 mb-4">
            <div class="dashboard-graphs-box h-100">
                <h6 class="mb-2">Outstanding</h6>
                <p class="mb-0"><span class="total_outstandings">AED 0</span></p>
                <div id="sparklines-outstanding"
                    class="ml-auto max-w-48 d-flex justify-content-center align-items-center pb-3 pr-2"></div>
                <a href="{{ Route('admin.outstanding_details') }}"
                    class="btn btn-pill btn-sm pl-4 pr-4 btn-outline-primary shadow-none w-100">View
                    details</a>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-lg-0 mb-4">
            <div class="dashboard-graphs-box h-100">
                <h6 class="mb-2">Shipments</h6>
                <p class="mb-0"><span id="total_shipments">0</span></p>
                <div id="sparklines-shipments-count"
                    class="ml-auto max-w-48 d-flex justify-content-center align-items-center pb-3 pr-2"></div>
                <a href="#shipment-details"
                    class="btn btn-pill btn-sm pl-4 pr-4 btn-outline-primary shadow-none w-100">View
                    details</a>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-lg-0 mb-4">
            <div class="dashboard-graphs-box h-100">
                <h6 class="mb-2">Revenue</h6>
                <p class="mb-0" id="total_revenue"><span>AED 0</span></p>
                <div id="sparklines-revenue"
                    class="ml-auto max-w-48 d-flex justify-content-center align-items-center pb-3 pr-2"></div>
                <a href="{{ Route('admin.revenue_details') }}"
                    class="btn btn-pill btn-sm pl-4 pr-4 btn-outline-primary shadow-none w-100">View details</a>
            </div>
        </div>
        @if (is_ops())
            <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-lg-0 mb-4">
            <div class="dashboard-graphs-box h-100">
                <h6 class="mb-2">Customers</h6>
                <p class="mb-0"><span id="total_customer">0</span></p>
                <div id="sparklines-customers"
                    class="ml-auto max-w-48 d-flex justify-content-center align-items-center pb-3 pr-2"></div>
                <a href="#customers" class="btn btn-pill btn-sm pl-4 pr-4 btn-outline-primary shadow-none w-100">View
                    details</a>
            </div>
        </div>
        @endif
    </div>
</div>
<div class="row mb-5">
    @if(is_ops())
        <div class="col-6">
        <h6 class="fs-18 mb-18 font-weight-bold heading-text ">{{ is_ops() ? 'Customer' : 'Sub Accounts' }}
            Summary</h6>
        <div class="revenue-status-box">
            <div class="row">
                <div class="col-12">
                    <div>
                        <h6 class="mb-2">Shipments Distribution By Location</h6>
                    </div>
                    <div id="location_order_donut"></div>
                </div>
            <div class="col-12 {{ is_ops() ? '' : 'd-none' }}">
                    <div>
                        <h6 class="mb-3">{{ is_ops() ? 'Customer' : 'Sub Accounts' }}</h6>
                    </div>
                    <div class="slick-slider">
                        <div class="card-body p-0">
                            <div class="return-summary-status-list">
                                <div class="scroll-area-md" style="overflow-x:scroll">
                                    <table class="table table-hover mb-5">
                                        <thead class="thead-light">
                                            <tr>
                                                <th width="20%"
                                                    class=" border-0 border-tl-radius-4 border-bl-radius-4"
                                                    style="background-color: #f3f6f9 !important;">
                                                    <b class="th-text-gray text-uppercase fs-12 ">Name</b>
                                                </th>
                                                <th class="border-0" width="20%"
                                                    style="background-color: #f3f6f9 !important;">
                                                    <b class="th-text-gray text-uppercase fs-12 ">Phone</b>
                                                </th>
                                                <th class="border-0" width="20%"
                                                    style="background-color: #f3f6f9 !important;">
                                                    <b class="th-text-gray text-uppercase fs-12 ">Email</b>
                                                </th>
                                                <th class="border-0" width="20%"
                                                    style="background-color: #f3f6f9 !important;">
                                                    <b class="th-text-gray text-uppercase fs-12 ">Value</b>
                                                </th>
                                                <th class="border-0 border-tr-radius-4 border-br-radius-4"
                                                    width="20%" style="background-color: #f3f6f9 !important;">
                                                    <b class="th-text-gray text-uppercase fs-12 ">Quantity</b>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody id="top_customers">
                                            <tr>
                                                <td colspan="15"><b class="text-black-50">No data available</b></td>
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
    @endif
    <div class="col-6">
        <h6 class="fs-18 mb-18 font-weight-bold heading-text ">Shipment Status Summary</h6>
        <div class="order-status-box">
            <div class="row">
                <div class="col-12">
                    <div>
                        <h6 class="mb-2">Shipments</h6>
                    </div>
                    <div id="shipments-status-donut"></div>
                </div>

                <div class="col-12">
                    <div>
                        <h6 class="mb-3">Shipment Status Summary</h6>
                    </div>
                    <div class="row">
                        <div class="col-6 pr-2">
                            <div>
                                <ul class="list-group list-group-flush" id="order-status-summary-1">
                                    <li class="list-group-item pt-2 pb-2 px-0">
                                        <div class="align-box-row mb-1">
                                            <h5 class="mb-0">Booked</h5>
                                            <p>Qty. <span class="text-booked">0</span></p>
                                            {{-- <p>Rs. 0.00 Qty. 0</p> --}}
                                        </div>
                                        <div class="progress-bar-sm progress-bar-animated-alt progress">
                                            <div class="progress-bar booked-progress-bar bg-success-summary" role="progressbar"
                                                aria-valuemax="100" style="width: 0%;"></div>
                                        </div>
                                    </li>
                                    <li class="list-group-item pt-2 pb-2 px-0">
                                        <div class="align-box-row mb-1">
                                            <h5 class="mb-0">Pickup</h5>
                                            <p>Qty. <span class="text-pickup">0</span></p>
                                        </div>
                                        <div class="progress-bar-sm progress-bar-animated-alt progress">
                                            <div class="progress-bar pickup-progress-bar bg-success-summary" role="progressbar"
                                                aria-valuemax="100" style="width: 0%;"></div>
                                        </div>
                                    </li>
                                    <li class="list-group-item pt-2 pb-2 px-0">
                                        <div class="align-box-row mb-1">
                                            <h5 class="mb-0">Arrival</h5>
                                            <p>Qty. <span class="text-arival">0</span></p>
                                        </div>
                                        <div class="progress-bar-sm progress-bar-animated-alt progress">
                                            <div class="progress-bar arival-progress-bar bg-success-summary" role="progressbar"
                                                aria-valuemax="100" style="width: 0%;"></div>
                                        </div>
                                    </li>
                                    <li class="list-group-item pt-2 pb-2 px-0">
                                        <div class="align-box-row mb-1">
                                            <h5 class="mb-0">On Hold</h5>
                                            <p>Qty. <span class="text-on-hold">0</span></p>
                                        </div>
                                        <div class="progress-bar-sm progress-bar-animated-alt progress">
                                            <div class="progress-bar on-hold-progress-bar bg-success-summary" role="progressbar"
                                                aria-valuemax="100" style="width: 0%;"></div>
                                        </div>
                                    </li>
                                    <li class="list-group-item pt-2 pb-2 px-0">
                                        <div class="align-box-row mb-1">
                                            <h5 class="mb-0">On Route</h5>
                                            <p>Qty. <span class="text-on-route">0</span></p>
                                        </div>
                                        <div class="progress-bar-sm progress-bar-animated-alt progress">
                                            <div class="progress-bar on-route-progress-bar bg-success-summary" role="progressbar"
                                                aria-valuemax="100" style="width: 0%;"></div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-6 pl-2">
                            <div>
                                <ul class="list-group list-group-flush" id="order-status-summary-2">
                                    <li class="list-group-item pt-2 pb-2 px-0">
                                        <div class="align-box-row mb-1">
                                            <h5 class="mb-0">In Transit</h5>
                                            <p>Qty. <span class="text-in-transit">0</span></p>
                                        </div>
                                        <div class="progress-bar-sm progress-bar-animated-alt progress">
                                            <div class="progress-bar in-transit-progress-bar bg-success-summary" role="progressbar"
                                                aria-valuemax="100" style="width: 0%;"></div>
                                        </div>
                                    </li>
                                    <li class="list-group-item pt-2 pb-2 px-0">
                                        <div class="align-box-row mb-1">
                                            <h5 class="mb-0">Delivered</h5>
                                            <p>Qty. <span class="text-delivered">0</span></p>
                                        </div>
                                        <div class="progress-bar-sm progress-bar-animated-alt progress">
                                            <div class="progress-bar delivered-progress-bar bg-success-summary" role="progressbar"
                                                aria-valuemax="100" style="width: 0%;"></div>
                                        </div>
                                    </li>
                                    <li class="list-group-item pt-2 pb-2 px-0">
                                        <div class="align-box-row mb-1">
                                            <h5 class="mb-0">Return To Shipper</h5>
                                            <p>Qty. <span class="text-return-to-shipper">0</span></p>
                                        </div>
                                        <div class="progress-bar-sm progress-bar-animated-alt progress">
                                            <div class="progress-bar return-to-shipper-progress-bar bg-success-summary" role="progressbar"
                                                aria-valuemax="100" style="width: 0%;"></div>
                                        </div>
                                    </li>
                                    <li class="list-group-item pt-2 pb-2 px-0">
                                        <div class="align-box-row mb-1">
                                            <h5 class="mb-0">Cancelled</h5>
                                            <p>Qty. <span class="text-cancelled">0</span></p>
                                        </div>
                                        <div class="progress-bar-sm progress-bar-animated-alt progress">
                                            <div class="progress-bar cancelled-progress-bar bg-success-summary" role="progressbar"
                                                aria-valuemax="100" style="width: 0%;"></div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@if (is_ops())
<div class="row mb-5 d-none" id="tpl-section">
    <div class="col-lg-12">
        <h6 class="fs-18 mb-18 font-weight-bold heading-text ">3PL Status</h6>
    </div>
    <div class="col-lg-12">
        <div class="three_pl_container">
            <div class="row justify-content-start gap-x-30" id="thirparty-status">
                
            </div>
        </div>
    </div>
</div>
@endif
