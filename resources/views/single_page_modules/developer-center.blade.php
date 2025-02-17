@extends('layout.main')
@section('content')
<style>
     a.active{
        color: white !important 
    }
</style>
    <div class="app-content">
        <div class="app-content--inner">
            <div class="pb-4 text-center text-xl-left">
                <div class="row align-items-center">
                    <div class="col-xl-12">
                        <div>
                            <h5 class="display-4 mt-1 mb-1 font-weight-bold text-black Heebo-SemiBold text-uppercase"
                                id="heads">Development Center</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-12">
                    <div class="card card-box mb-3">
                        <div class="no-gutters row">
                            <div class="col-lg-12 p-4">
                                <div class="table-tab-content-wrapper">
                                    <ul class="nav nav-line nav-line-alt" id="myTab2" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link text-uppercase font-size-xs active" id="open-api-tab"
                                                data-toggle="tab" href="#open-api" role="tab" aria-controls="messages"
                                                aria-selected="false"> OPEN API <div class="divider"></div></a>
                                        </li>
                                    </ul>
                                    <div class="row p-3" id="heads">
                                        <div class="col-md-6 pl-0">
                                            <form>
                                                <div class="form-group">
                                                    <label class="creat-lable" for="admin_user_id" id="api-key">API
                                                        Key</label>
                                                    <div class="cp">
                                                        <input type="url" class="form-control form-control-lg"
                                                            id="api_key" readonly placeholder="API key"
                                                            value="{{ base64_encode(session('type')) . '%' . session('secret_key') . '!' . session('company_id') . ':' . time() }}">
                                       
                                                    </div>
                                                </div>
                                            </form>
                                        </div>

                                        <div class="col-md-6 pr-0">
                                            <form>
                                                <div class="form-group">
                                                    <label class="creat-lable" for="admin_user_id">Client-Id</label>
                                                    <div class="cp">
                                                        <input type="url" class="form-control form-control-lg"
                                                            id="client_id" readonly placeholder="Client-Id"
                                                            value="{{ session('logged_id') }}">
                                                        <!--<a href="Javascript:;" data-toggle="tooltip" title="Copy"-->
                                                        <!--    onclick="copyToClipboard('#client_id')">-->
                                                        <!--    <i class="fas fa-copy"></i>-->
                                                        <!--</a>-->
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="col-12 px-0">
                                            <h5>Header Parameters</h5>
                                            <div class="Parameter">
                                                <table class="table table-bordered">
                                                    <tbody>
                                                        <tr>
                                                            <td>
                                                                <p>
                                                                    <strong>S.no.</strong>
                                                                </p>
                                                            </td>
                                                            <td>
                                                                <p>
                                                                    <strong>Key</strong>
                                                                </p>
                                                            </td>
                                                            <td>
                                                                <p>
                                                                    <strong>Value</strong>
                                                                </p>
                                                            </td>
                                                            <td>
                                                                <p>
                                                                    <strong>Condition</strong>
                                                                </p>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <p>1</p>
                                                            </td>
                                                            <td>
                                                                <p>Api-Key</p>
                                                            </td>
                                                            <td>
                                                                <p>{{ base64_encode(session('type')) . '%' . session('secret_key') . '!' . session('company_id') . ':' . time() }}</p>
                                                            </td>
                                                            <td>
                                                                <p>Mandatory</p>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <p>2</p>
                                                            </td>
                                                            <td>
                                                                <p>Shopify-Api-Key</p>
                                                            </td>
                                                            <td>
                                                                <p>{{ session('secret_key') }}</p>
                                                            </td>
                                                            <td>
                                                                <p>Mandatory</p>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <p>3</p>
                                                            </td>
                                                            <td>
                                                                <p>Client-Id</p>
                                                            </td>
                                                            <td>
                                                                <p>{{ session('logged_id') }}</p>
                                                            </td>
                                                            <td>
                                                                <p>Mandatory</p>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <a download class="d-flex justify-content-end w-100 mt-3 text-primary text-underline" href="{{ asset('sample/Citymail-OpenAPI.pdf') }}">Click Here To Download The Docs</a>
                                       @if(session('type') == '6')
                                           <p>If using shoppify then use this webhook for creating shipments.</p>
                                            <input type="url" class="form-control form-control-lg"
                                            id="webhook" readonly placeholder="webhook"
                                            value="{{  config('app.api_url').'webhooks/shipment-create?company_id='.session('company_id').'&acno='.session('acno') }}">
                                        @endif
                                    <hr class="m-0">
                                    <div class="tab-content p-0 pt-3">
                                        <div class="tab-pane fade active show" id="open-api" role="tabpanel"
                                            aria-labelledby="open-api-tab">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-3 m-0 p-0">
                                                        <div class="nav flex-column nav-pills" role="tablist"
                                                            aria-orientation="vertical">
                                                            <a class="nav-link active" data-toggle="pill"
                                                                href="#v-pills-open-api-pickuplocations" role="tab"
                                                                aria-controls="v-pills-open-api-track"
                                                                aria-selected="false">Pickup Locations</a>
                                                            <a class="nav-link" data-toggle="pill"
                                                                href="#v-pills-open-api-cities" role="tab"
                                                                aria-controls="v-pills-open-api-track"
                                                                aria-selected="false">Cities </a>
                                                            <a class="nav-link" data-toggle="pill"
                                                                href="#v-pills-open-api-services" role="tab"
                                                                aria-controls="v-pills-open-api-services"
                                                                aria-selected="true">Get Services</a>
                                                            <a class="nav-link" data-toggle="pill"
                                                                href="#v-pills-open-api-order" role="tab"
                                                                aria-controls="v-pills-open-api-order"
                                                                aria-selected="true">Create Shipments</a>
                                                            <a class="nav-link" data-toggle="pill"
                                                                href="#v-pills-open-api-void" role="tab"
                                                                aria-controls="v-pills-open-api-void"
                                                                aria-selected="true">Shipments Void</a>
                                                            <a class="nav-link" data-toggle="pill"
                                                                href="#v-pills-open-api-track" role="tab"
                                                                aria-controls="v-pills-open-api-track"
                                                                aria-selected="false">Track Order</a>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <div class="tab-content mt-0 m-0 p-0" id="v-pills-tabContent">
                                                         
                                                            {{-- Picup Locations --}}
                                                            <div class="tab-pane fade show active"
                                                                id="v-pills-open-api-pickuplocations" role="tabpanel">
                                                                <h4 class="mb-3">
                                                                    <b>Pickup Locations API</b>
                                                                </h4>
                                                                <div class="detail-bx mb-5">
                                                                    <h5 class="mb-3">
                                                                        <b>Pickup Locations List</b>
                                                                    </h5>
                                                                    <p>In order to get a pickup locations here is the
                                                                        link
                                                                        enable to get all information.</p>
                                                                    <div class="mb-3">
                                                                        <span>
                                                                            <b>METHOD :</b>
                                                                        </span>
                                                                        <span>POST</span>
                                                                    </div>
                                                                    <div class="url-box mb-1">
                                                                        <a href="javascript:;">URL:
                                                                            {{ config('app.api_url') . 'pickupLocation/index' }}</a>
                                                                    </div>
                                                                    <p class="mb-5"><b>Note:</b> Data should be in
                                                                        JSON
                                                                        Format</p>
                                                                </div>
                                                                <div class="detail-bx mb-5">
                                                                    <h4 class="mb-3">
                                                                        <b>PARAMETERS</b>
                                                                    </h4>
                                                                    <h5 class="mb-3">For Pickup Locations List</h5>
                                                                    <div class="Parameter">
                                                                        <table class="table table-bordered">
                                                                            <tbody>
                                                                                <tr>
                                                                                    <td>
                                                                                        <p>
                                                                                            <strong>S.no.</strong>
                                                                                        </p>
                                                                                    </td>
                                                                                    <td>
                                                                                        <p>
                                                                                            <strong>Parameter</strong>
                                                                                        </p>
                                                                                    </td>
                                                                                    <td>
                                                                                        <p>
                                                                                            <strong>Description</strong>
                                                                                        </p>
                                                                                    </td>
                                                                                    <td>
                                                                                        <p>
                                                                                            <strong>Condition</strong>
                                                                                        </p>
                                                                                    </td>
                                                                                    <td>
                                                                                        <p>
                                                                                            <strong>Format</strong>
                                                                                        </p>
                                                                                    </td>
                                                                                    <td>
                                                                                        <p>
                                                                                            <strong>Sample</strong>
                                                                                        </p>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>
                                                                                        <p>1</p>
                                                                                    </td>
                                                                                    <td>
                                                                                        <p>customer_acno</p>
                                                                                    </td>
                                                                                    <td>
                                                                                        <p>Customer Account No</p>
                                                                                    </td>
                                                                                    <td>
                                                                                        <p>Mandatory</p>
                                                                                    </td>
                                                                                    <td>
                                                                                        <p>integer</p>
                                                                                    </td>
                                                                                    <td>
                                                                                        <p>1000001</p>
                                                                                    </td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                                <div class="api-box">
                                                                    <h5 class="mb-3">
                                                                        <b>API Parameters</b>
                                                                    </h5>
                                                                    <div class="view-data mb-5">
                                                                        <p class="main-p">
                                                                            <span class="kurly_braces">{</span>
                                                                        </p>
                                                                        <p class="main-p">
                                                                            <span>&nbsp; &nbsp; &nbsp; &nbsp;
                                                                                &nbsp;</span>
                                                                            <span
                                                                                class="api_detail_text">&quot;customer_acno&quot;</span>
                                                                            <span class="colons">:&nbsp;</span>
                                                                            <span class="api_detail_text_1">1000001</span>
                                                                        </p>
                                                                        <p class="main-p">
                                                                            <span class="kurly_braces">}</span>
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                                <div class="api-box">
                                                                    <h5 class="mb-3">
                                                                        <b>Success Response</b>
                                                                    </h5>
                                                                    <div class="view-data mb-5">
                                                                        <p class="main-p">
                                                                            <span class="kurly_braces"> [</span>
                                                                        </p>
                                                                        <p class="main-p">
                                                                            <span class="kurly_braces">&nbsp; {</span>
                                                                        </p>

                                                                        <p class="main-p">
                                                                            <span>&nbsp; &nbsp; &nbsp; &nbsp;
                                                                                &nbsp;</span>
                                                                            <span
                                                                                class="api_detail_text">&quot;id&quot;</span>
                                                                            <span class="colons">:&nbsp;</span>
                                                                            <span
                                                                                class="api_detail_text_1">&quot;1&quot;</span>
                                                                            <span class="colons">,</span>
                                                                        </p>
                                                                        <p class="main-p">
                                                                            <span>&nbsp; &nbsp; &nbsp; &nbsp;
                                                                                &nbsp;</span>
                                                                            <span
                                                                                class="api_detail_text">&quot;company_id&quot;</span>
                                                                            <span class="colons">:&nbsp;</span>
                                                                            <span
                                                                                class="api_detail_text_1">&quot;100004&quot;</span>
                                                                            <span class="colons">,</span>
                                                                        </p>
                                                                        <p class="main-p">
                                                                            <span>&nbsp; &nbsp; &nbsp; &nbsp;
                                                                                &nbsp;</span>
                                                                            <span
                                                                                class="api_detail_text">&quot;customer_acno&quot;</span>
                                                                            <span class="colons">:&nbsp;</span>
                                                                            <span
                                                                                class="api_detail_text_1">&quot;1000001&quot;</span>
                                                                            <span class="colons">,</span>
                                                                        </p>
                                                                        <p class="main-p">
                                                                            <span>&nbsp; &nbsp; &nbsp; &nbsp;
                                                                                &nbsp;</span>
                                                                            <span
                                                                                class="api_detail_text">&quot;country_id&quot;</span>
                                                                            <span class="colons">:&nbsp;</span>
                                                                            <span
                                                                                class="api_detail_text_1">&quot;449&quot;</span>
                                                                            <span class="colons">,</span>
                                                                        </p>
                                                                        <p class="main-p">
                                                                            <span>&nbsp; &nbsp; &nbsp; &nbsp;
                                                                                &nbsp;</span>
                                                                            <span
                                                                                class="api_detail_text">&quot;city_id&quot;</span>
                                                                            <span class="colons">:&nbsp;</span>
                                                                            <span
                                                                                class="api_detail_text_1">&quot;655&quot;</span>
                                                                            <span class="colons">,</span>
                                                                        </p>
                                                                        <p class="main-p">
                                                                            <span>&nbsp; &nbsp; &nbsp; &nbsp;
                                                                                &nbsp;</span>
                                                                            <span
                                                                                class="api_detail_text">&quot;name&quot;</span>
                                                                            <span class="colons">:&nbsp;</span>
                                                                            <span
                                                                                class="api_detail_text_1">&quot;demo&quot;</span>
                                                                            <span class="colons">,</span>
                                                                        </p>
                                                                        <p class="main-p">
                                                                            <span>&nbsp; &nbsp; &nbsp; &nbsp;
                                                                                &nbsp;</span>
                                                                            <span
                                                                                class="api_detail_text">&quot;title&quot;</span>
                                                                            <span class="colons">:&nbsp;</span>
                                                                            <span class="api_detail_text_1">&quot;gulshan
                                                                                - pickup&quot;</span>
                                                                            <span class="colons">,</span>
                                                                        </p>
                                                                        <p class="main-p">
                                                                            <span>&nbsp; &nbsp; &nbsp; &nbsp;
                                                                                &nbsp;</span>
                                                                            <span
                                                                                class="api_detail_text">&quot;email&quot;</span>
                                                                            <span class="colons">:&nbsp;</span>
                                                                            <span
                                                                                class="api_detail_text_1">&quot;demo@demo.com&quot;</span>
                                                                            <span class="colons">,</span>
                                                                        </p>
                                                                        <p class="main-p">
                                                                            <span>&nbsp; &nbsp; &nbsp; &nbsp;
                                                                                &nbsp;</span>
                                                                            <span
                                                                                class="api_detail_text">&quot;phone&quot;</span>
                                                                            <span class="colons">:&nbsp;</span>
                                                                            <span
                                                                                class="api_detail_text_1">&quot;0000-0000000&quot;</span>
                                                                            <span class="colons">,</span>
                                                                        </p>
                                                                        <p class="main-p">
                                                                            <span>&nbsp; &nbsp; &nbsp; &nbsp;
                                                                                &nbsp;</span>
                                                                            <span
                                                                                class="api_detail_text">&quot;address&quot;</span>
                                                                            <span class="colons">:&nbsp;</span>
                                                                            <span class="api_detail_text_1">&quot;R-99
                                                                                Imaginary street karachi&quot;</span>
                                                                            <span class="colons">,</span>
                                                                        </p>
                                                                        <p class="main-p">
                                                                            <span>&nbsp; &nbsp; &nbsp; &nbsp;
                                                                                &nbsp;</span>
                                                                            <span
                                                                                class="api_detail_text">&quot;active&quot;</span>
                                                                            <span class="colons">:&nbsp;</span>
                                                                            <span
                                                                                class="api_detail_text_1">&quot;1&quot;</span>
                                                                            <span class="colons">,</span>
                                                                        </p>
                                                                        <p class="main-p">
                                                                            <span>&nbsp; &nbsp; &nbsp; &nbsp;
                                                                                &nbsp;</span>
                                                                            <span
                                                                                class="api_detail_text">&quot;is_deleted&quot;</span>
                                                                            <span class="colons">:&nbsp;</span>
                                                                            <span
                                                                                class="api_detail_text_1">&quot;N&quot;</span>
                                                                            <span class="colons">,</span>
                                                                        </p>
                                                                        <p class="main-p">
                                                                            <span>&nbsp; &nbsp; &nbsp; &nbsp;
                                                                                &nbsp;</span>
                                                                            <span
                                                                                class="api_detail_text">&quot;city&quot;</span>
                                                                            <span class="colons">:&nbsp;</span>
                                                                            <span
                                                                                class="api_detail_text_1">&quot;Karachi&quot;</span>
                                                                            <span class="colons">,</span>
                                                                        </p>
                                                                        <p class="main-p">
                                                                            <span>&nbsp; &nbsp; &nbsp; &nbsp;
                                                                                &nbsp;</span>
                                                                            <span
                                                                                class="api_detail_text">&quot;customer_business_name&quot;</span>
                                                                            <span class="colons">:&nbsp;</span>
                                                                            <span class="api_detail_text_1">&quot;demo
                                                                                Co&quot;</span>
                                                                            <span class="colons">,</span>
                                                                        </p>

                                                                        <p class="main-p">
                                                                            <span>&nbsp; &nbsp; &nbsp; &nbsp;
                                                                                &nbsp;</span>
                                                                            <span
                                                                                class="api_detail_text">&quot;created_at&quot;</span>
                                                                            <span class="colons">:&nbsp;</span>
                                                                            <span
                                                                                class="api_detail_text_1">&quot;2024-07-26
                                                                                15:50:25&quot;</span>
                                                                            <span class="colons">,</span>
                                                                        </p>
                                                                        <p class="main-p">
                                                                            <span class="kurly_braces">&nbsp; }</span>
                                                                        </p>
                                                                        <p class="main-p">
                                                                            <span class="kurly_braces"> ]</span>
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            {{-- cities --}}
                                                            <div class="tab-pane fade" id="v-pills-open-api-cities"
                                                                role="tabpanel">
                                                                {{-- countries --}}
                                                                <h4 class="mb-3">
                                                                    <b>Countries API</b>
                                                                </h4>
                                                                <div class="detail-bx mb-5">
                                                                    <h5 class="mb-3">
                                                                        <b>Countries List</b>
                                                                    </h5>
                                                                    <p>In order to get a countries here is the countries
                                                                        link
                                                                        enable to get all information.</p>
                                                                    <div class="mb-3">
                                                                        <span>
                                                                            <b>METHOD :</b>
                                                                        </span>
                                                                        <span>POST</span>
                                                                    </div>
                                                                    <div class="url-box mb-1">
                                                                        <a href="javascript:;">URL:
                                                                            {{ config('app.api_url') . 'countries' }}</a>
                                                                    </div>
                                                                </div>
                                                                <div class="api-box">
                                                                    <h5 class="mb-3">
                                                                        <b>Success Response</b>
                                                                    </h5>
                                                                    <div class="view-data mb-5">
                                                                        <p class="main-p">
                                                                            <span class="kurly_braces"> [</span>
                                                                        </p>
                                                                        <p class="main-p">
                                                                            <span class="kurly_braces">&nbsp; {</span>
                                                                        </p>

                                                                        <p class="main-p">
                                                                            <span>&nbsp; &nbsp; &nbsp; &nbsp;
                                                                                &nbsp;</span>
                                                                            <span
                                                                                class="api_detail_text">&quot;id&quot;</span>
                                                                            <span class="colons">:&nbsp;</span>
                                                                            <span
                                                                                class="api_detail_text_1">&quot;449&quot;</span>
                                                                            <span class="colons">,</span>
                                                                        </p>
                                                                        <p class="main-p">
                                                                            <span>&nbsp; &nbsp; &nbsp; &nbsp;
                                                                                &nbsp;</span>
                                                                            <span
                                                                                class="api_detail_text">&quot;country_name&quot;</span>
                                                                            <span class="colons">:&nbsp;</span>
                                                                            <span
                                                                                class="api_detail_text_1">&quot;Pakistan&quot;</span>
                                                                            <span class="colons">,</span>
                                                                        </p>
                                                                        <p class="main-p">
                                                                            <span>&nbsp; &nbsp; &nbsp; &nbsp;
                                                                                &nbsp;</span>
                                                                            <span
                                                                                class="api_detail_text">&quot;country_code&quot;</span>
                                                                            <span class="colons">:&nbsp;</span>
                                                                            <span
                                                                                class="api_detail_text_1">&quot;PK&quot;</span>
                                                                            <span class="colons">,</span>
                                                                        </p>
                                                                        <p class="main-p">
                                                                            <span class="kurly_braces">&nbsp; }</span>
                                                                        </p>
                                                                        <p class="main-p">
                                                                            <span class="kurly_braces"> ]</span>
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                                {{-- cities --}}
                                                                <h4 class="mb-3">
                                                                    <b>Cities API</b>
                                                                </h4>
                                                                <div class="detail-bx mb-5">
                                                                    <h5 class="mb-3">
                                                                        <b>Cities List</b>
                                                                    </h5>
                                                                    <p>In order to get a cities here is the cities link
                                                                        enable to get all information.</p>
                                                                    <div class="mb-3">
                                                                        <span>
                                                                            <b>METHOD :</b>
                                                                        </span>
                                                                        <span>POST</span>
                                                                    </div>
                                                                    <div class="url-box mb-1">
                                                                        <a href="javascript:;">URL:
                                                                            {{ config('app.api_url') . 'cities' }}</a>
                                                                    </div>
                                                                    <p class="mb-5"><b>Note:</b> Data should be in
                                                                        JSON
                                                                        Format</p>
                                                                </div>
                                                                <div class="detail-bx mb-5">
                                                                    <h4 class="mb-3">
                                                                        <b>PARAMETERS</b>
                                                                    </h4>
                                                                    <h5 class="mb-3">For Cities List</h5>
                                                                    <div class="Parameter">
                                                                        <table class="table table-bordered">
                                                                            <tbody>
                                                                                <tr>
                                                                                    <td>
                                                                                        <p>
                                                                                            <strong>S.no.</strong>
                                                                                        </p>
                                                                                    </td>
                                                                                    <td>
                                                                                        <p>
                                                                                            <strong>Parameter</strong>
                                                                                        </p>
                                                                                    </td>
                                                                                    <td>
                                                                                        <p>
                                                                                            <strong>Description</strong>
                                                                                        </p>
                                                                                    </td>
                                                                                    <td>
                                                                                        <p>
                                                                                            <strong>Condition</strong>
                                                                                        </p>
                                                                                    </td>
                                                                                    <td>
                                                                                        <p>
                                                                                            <strong>Format</strong>
                                                                                        </p>
                                                                                    </td>
                                                                                    <td>
                                                                                        <p>
                                                                                            <strong>Sample</strong>
                                                                                        </p>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>
                                                                                        <p>1</p>
                                                                                    </td>
                                                                                    <td>
                                                                                        <p>country_id</p>
                                                                                    </td>
                                                                                    <td>
                                                                                        <p>Country ID</p>
                                                                                    </td>
                                                                                    <td>
                                                                                        <p>Optional</p>
                                                                                    </td>
                                                                                    <td>
                                                                                        <p>integer</p>
                                                                                    </td>
                                                                                    <td>
                                                                                        <p>1</p>
                                                                                    </td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                                <div class="api-box">
                                                                    <h5 class="mb-3">
                                                                        <b>API Parameters</b>
                                                                    </h5>
                                                                    <div class="view-data mb-5">
                                                                        <p class="main-p">
                                                                            <span class="kurly_braces">{</span>
                                                                        </p>
                                                                        <p class="main-p">
                                                                            <span>&nbsp; &nbsp; &nbsp; &nbsp;
                                                                                &nbsp;</span>
                                                                            <span
                                                                                class="api_detail_text">&quot;country_id&quot;</span>
                                                                            <span class="colons">:&nbsp;</span>
                                                                            <span class="api_detail_text_1">449</span>
                                                                        </p>
                                                                        <p class="main-p">
                                                                            <span class="kurly_braces">}</span>
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                                <div class="api-box">
                                                                    <h5 class="mb-3">
                                                                        <b>Success Response</b>
                                                                    </h5>
                                                                    <div class="view-data mb-5">
                                                                        <p class="main-p">
                                                                            <span class="kurly_braces"> [</span>
                                                                        </p>
                                                                        <p class="main-p">
                                                                            <span class="kurly_braces">&nbsp; {</span>
                                                                        </p>

                                                                        <p class="main-p">
                                                                            <span>&nbsp; &nbsp; &nbsp; &nbsp;
                                                                                &nbsp;</span>
                                                                            <span
                                                                                class="api_detail_text">&quot;id&quot;</span>
                                                                            <span class="colons">:&nbsp;</span>
                                                                            <span
                                                                                class="api_detail_text_1">&quot;655&quot;</span>
                                                                            <span class="colons">,</span>
                                                                        </p>
                                                                        <p class="main-p">
                                                                            <span>&nbsp; &nbsp; &nbsp; &nbsp;
                                                                                &nbsp;</span>
                                                                            <span
                                                                                class="api_detail_text">&quot;city&quot;</span>
                                                                            <span class="colons">:&nbsp;</span>
                                                                            <span
                                                                                class="api_detail_text_1">&quot;Karachi&quot;</span>
                                                                            <span class="colons">,</span>
                                                                        </p>
                                                                        <p class="main-p">
                                                                            <span>&nbsp; &nbsp; &nbsp; &nbsp;
                                                                                &nbsp;</span>
                                                                            <span
                                                                                class="api_detail_text">&quot;country_id&quot;</span>
                                                                            <span class="colons">:&nbsp;</span>
                                                                            <span
                                                                                class="api_detail_text_1">&quot;1&quot;</span>
                                                                            <span class="colons">,</span>
                                                                        </p>
                                                                        <p class="main-p">
                                                                            <span>&nbsp; &nbsp; &nbsp; &nbsp;
                                                                                &nbsp;</span>
                                                                            <span
                                                                                class="api_detail_text">&quot;province_id&quot;</span>
                                                                            <span class="colons">:&nbsp;</span>
                                                                            <span
                                                                                class="api_detail_text_1">&quot;1&quot;</span>
                                                                            <span class="colons">,</span>
                                                                        </p>
                                                                        <p class="main-p">
                                                                            <span>&nbsp; &nbsp; &nbsp; &nbsp;
                                                                                &nbsp;</span>
                                                                            <span
                                                                                class="api_detail_text">&quot;zone&quot;</span>
                                                                            <span class="colons">:&nbsp;</span>
                                                                            <span
                                                                                class="api_detail_text_1">&quot;&quot;</span>
                                                                            <span class="colons">,</span>
                                                                        </p>
                                                                        <p class="main-p">
                                                                            <span>&nbsp; &nbsp; &nbsp; &nbsp;
                                                                                &nbsp;</span>
                                                                            <span
                                                                                class="api_detail_text">&quot;created_at&quot;</span>
                                                                            <span class="colons">:&nbsp;</span>
                                                                            <span
                                                                                class="api_detail_text_1">&quot;2024-07-26
                                                                                15:50:25&quot;</span>
                                                                            <span class="colons">,</span>
                                                                        </p>
                                                                        <p class="main-p">
                                                                            <span class="kurly_braces">&nbsp; }</span>
                                                                        </p>
                                                                        <p class="main-p">
                                                                            <span class="kurly_braces"> ]</span>
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            {{-- services --}}
                                                            <div class="tab-pane fade" id="v-pills-open-api-services"
                                                                role="tabpanel">
                                                                {{-- services --}}
                                                                <h4 class="mb-3">
                                                                    <b>Services API</b>
                                                                </h4>
                                                                <div class="detail-bx mb-5">
                                                                    <h5 class="mb-3">
                                                                        <b>Services List</b>
                                                                    </h5>
                                                                    <p>In order to get services here is the services link
                                                                        enable to get all information.</p>
                                                                    <div class="mb-3">
                                                                        <span>
                                                                            <b>METHOD :</b>
                                                                        </span>
                                                                        <span>POST</span>
                                                                    </div>
                                                                    <div class="url-box mb-1">
                                                                        <a href="javascript:;">URL:
                                                                            {{ config('app.api_url') . 'services' }}</a>
                                                                    </div>
                                                                    <p class="mb-5"><b>Note:</b> Data should be in
                                                                        JSON
                                                                        Format</p>
                                                                </div>
                                                                <div class="detail-bx mb-5">
                                                                    <h4 class="mb-3">
                                                                        <b>PARAMETERS</b>
                                                                    </h4>
                                                                    <h5 class="mb-3">For Services List</h5>
                                                                    <div class="Parameter">
                                                                        <table class="table table-bordered">
                                                                            <tbody>
                                                                                <tr>
                                                                                    <td>
                                                                                        <p>
                                                                                            <strong>S.no.</strong>
                                                                                        </p>
                                                                                    </td>
                                                                                    <td>
                                                                                        <p>
                                                                                            <strong>Parameter</strong>
                                                                                        </p>
                                                                                    </td>
                                                                                    <td>
                                                                                        <p>
                                                                                            <strong>Description</strong>
                                                                                        </p>
                                                                                    </td>
                                                                                    <td>
                                                                                        <p>
                                                                                            <strong>Condition</strong>
                                                                                        </p>
                                                                                    </td>
                                                                                    <td>
                                                                                        <p>
                                                                                            <strong>Format</strong>
                                                                                        </p>
                                                                                    </td>
                                                                                    <td>
                                                                                        <p>
                                                                                            <strong>Sample</strong>
                                                                                        </p>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>
                                                                                        <p>1</p>
                                                                                    </td>
                                                                                    <td>
                                                                                        <p>customer_acno</p>
                                                                                    </td>
                                                                                    <td>
                                                                                        <p>Customer Account No</p>
                                                                                    </td>
                                                                                    <td>
                                                                                        <p>Mandatory</p>
                                                                                    </td>
                                                                                    <td>
                                                                                        <p>integer</p>
                                                                                    </td>
                                                                                    <td>
                                                                                        <p>1000001</p>
                                                                                    </td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                                <div class="api-box">
                                                                    <h5 class="mb-3">
                                                                        <b>API Parameters</b>
                                                                    </h5>
                                                                    <div class="view-data mb-5">
                                                                        <p class="main-p">
                                                                            <span class="kurly_braces">{</span>
                                                                        </p>
                                                                        <p class="main-p">
                                                                            <span>&nbsp; &nbsp; &nbsp; &nbsp;
                                                                                &nbsp;</span>
                                                                            <span
                                                                                class="api_detail_text">&quot;customer_acno&quot;</span>
                                                                            <span class="colons">:&nbsp;</span>
                                                                            <span class="api_detail_text_1">1000001</span>
                                                                        </p>
                                                                        <p class="main-p">
                                                                            <span class="kurly_braces">}</span>
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                                <div class="api-box">
                                                                    <h5 class="mb-3">
                                                                        <b>Success Response</b>
                                                                    </h5>
                                                                    <div class="view-data mb-5">
                                                                        <p class="main-p">
                                                                            <span class="kurly_braces">&nbsp;
                                                                                {</span>
                                                                        </p>
                                                                        <p class="main-p">
                                                                            <span>&nbsp; &nbsp; &nbsp; &nbsp;
                                                                                &nbsp;</span>
                                                                            <span
                                                                                class="api_detail_text">&quot;status&quot;</span>
                                                                            <span class="colons">:&nbsp;</span>
                                                                            <span
                                                                                class="api_detail_text_1">&quot;1&quot;</span>
                                                                            <span class="colons">,</span>
                                                                        </p>
                                                                        <p class="main-p">
                                                                            <span>&nbsp; &nbsp; &nbsp; &nbsp;
                                                                                &nbsp;</span>
                                                                            <span
                                                                                class="api_detail_text">&quot;Message&quot;</span>
                                                                            <span class="colons">:&nbsp;</span>
                                                                            <span
                                                                                class="api_detail_text_1">&quot;Success&quot;</span>
                                                                            <span class="colons">,</span>
                                                                        </p>
                                                                        <p class="main-p">
                                                                            <span>&nbsp; &nbsp; &nbsp; &nbsp;
                                                                                &nbsp;</span>
                                                                            <span
                                                                                class="api_detail_text">&quot;payload&quot;</span>
                                                                            <span class="colons">:&nbsp;</span>
                                                                            <span class="api_detail_text_1">[</span>
                                                                        </p>
                                                                        <p class="main-p">
                                                                            <span>&nbsp; &nbsp; &nbsp; &nbsp;
                                                                                &nbsp;&nbsp; &nbsp; &nbsp; &nbsp;
                                                                                &nbsp;</span>
                                                                            <span class="api_detail_text">&quot;SD&quot;,</span>
                                                                        </p>
                                                                        <p class="main-p">
                                                                            <span>&nbsp; &nbsp; &nbsp; &nbsp;
                                                                                &nbsp;&nbsp; &nbsp; &nbsp; &nbsp;
                                                                                &nbsp;</span>
                                                                            <span class="api_detail_text">&quot;GCC&quot;,</span>
                                                                        </p>
                                                                        <p class="main-p">
                                                                            <span class="kurly_braces">&nbsp;
                                                                                &nbsp; &nbsp; &nbsp;]</span>
                                                                        </p>
                                                                        <p class="main-p">
                                                                            <span class="kurly_braces">&nbsp;
                                                                                }</span>
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                                <div class="api-box">
                                                                    <h5 class="mb-3">
                                                                        <b>Response with Errors</b>
                                                                    </h5>
                                                                    <div class="view-data mb-5">
                                                                        <p class="main-p">
                                                                            <span class="kurly_braces">&nbsp;
                                                                                {</span>
                                                                        </p>
                                                                        <p class="main-p">
                                                                            <span>&nbsp; &nbsp; &nbsp; &nbsp;
                                                                                &nbsp;</span>
                                                                            <span
                                                                                class="api_detail_text">&quot;status&quot;</span>
                                                                            <span class="colons">:&nbsp;</span>
                                                                            <span
                                                                                class="api_detail_text_1">&quot;0&quot;</span>
                                                                            <span class="colons">,</span>
                                                                        </p>
                                                                        <p class="main-p">
                                                                            <span>&nbsp; &nbsp; &nbsp; &nbsp;
                                                                                &nbsp;</span>
                                                                            <span
                                                                                class="api_detail_text">&quot;Message&quot;</span>
                                                                            <span class="colons">:&nbsp;</span>
                                                                            <span
                                                                                class="api_detail_text_1">&quot;Error&quot;</span>
                                                                            <span class="colons">,</span>
                                                                        </p>
                                                                        <p class="main-p">
                                                                            <span>&nbsp; &nbsp; &nbsp; &nbsp;
                                                                                &nbsp;</span>
                                                                            <span
                                                                                class="api_detail_text">&quot;payload&quot;</span>
                                                                            <span class="colons">:&nbsp;</span>
                                                                            <span class="api_detail_text_1">&quot;Please enter valid account number&quot;</span>
                                                                        </p>
                                                                        <p class="main-p">
                                                                            <span class="kurly_braces">&nbsp;
                                                                                }</span>
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            {{-- shipment create --}}
                                                            <div class="tab-pane fade" id="v-pills-open-api-order"
                                                                role="tabpanel" aria-labelledby="v-pills-home-tab">
                                                                <div>
                                                                    <h4 class="mb-3">
                                                                        <b>PLACE Shipments API</b>
                                                                    </h4>
                                                                    <div class="detail-bx mb-5">
                                                                        <h5 class="mb-3">
                                                                            <b>Process Shipments</b>
                                                                        </h5>
                                                                        <p>In order to book a shipment/shipments here is the
                                                                            booking link enable to put all information</p>
                                                                        <div class="mb-3">
                                                                            <span>
                                                                                <b>METHOD :</b>
                                                                            </span>
                                                                            <span>POST</span>
                                                                        </div>
                                                                        <div class="url-box mb-5">
                                                                            <a href="javascript:;">URL:
                                                                                {{ config('app.api_url').'shipment/add' }}</a>
                                                                        </div>
                                                                    </div>
                                                                    <div class="detail-bx mb-5">
                                                                        <h4 class="mb-3">
                                                                            <b>PARAMETERS</b>
                                                                        </h4>
                                                                        <h5 class="mb-3">For Process Order</h5>
                                                                        <div class="Parameter">
                                                                            <table class="table table-bordered">
                                                                                <tbody>
                                                                                    <tr>
                                                                                        <td>
                                                                                            <p>
                                                                                                <strong>S.no.</strong>
                                                                                            </p>
                                                                                        </td>
                                                                                        <td>
                                                                                            <p>
                                                                                                <strong>Parameter</strong>
                                                                                            </p>
                                                                                        </td>
                                                                                        <td>
                                                                                            <p>
                                                                                                <strong>Description</strong>
                                                                                            </p>
                                                                                        </td>
                                                                                        <td>
                                                                                            <p>
                                                                                                <strong>Condition</strong>
                                                                                            </p>
                                                                                        </td>
                                                                                        <td>
                                                                                            <p>
                                                                                                <strong>Format</strong>
                                                                                            </p>
                                                                                        </td>
                                                                                        <td>
                                                                                            <p>
                                                                                                <strong>Sample</strong>
                                                                                            </p>
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td>
                                                                                            <p>1</p>
                                                                                        </td>
                                                                                        <td>
                                                                                            <p>company_id</p>
                                                                                        </td>
                                                                                        <td>
                                                                                            <p>Company Id</p>
                                                                                        </td>
                                                                                        <td>
                                                                                            <p>Mandatory</p>
                                                                                        </td>
                                                                                        <td>
                                                                                            <p>integer</p>
                                                                                        </td>
                                                                                        <td>
                                                                                            <p>100004</p>
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td>
                                                                                            <p>2</p>
                                                                                        </td>
                                                                                        <td>
                                                                                            <p>customer_acno</p>
                                                                                        </td>
                                                                                        <td>
                                                                                            <p>Customer Account Number</p>
                                                                                        </td>
                                                                                        <td>
                                                                                            <p>Mandatory</p>
                                                                                        </td>
                                                                                        <td>
                                                                                            <p>integer</p>
                                                                                        </td>
                                                                                        <td>
                                                                                            <p>1000001</p>
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td>
                                                                                            <p>3</p>
                                                                                        </td>
                                                                                        <td>
                                                                                            <p>device</p>
                                                                                        </td>
                                                                                        <td>
                                                                                            <p>device id</p>
                                                                                        </td>
                                                                                        <td>
                                                                                            <p>Mandatory</p>
                                                                                        </td>
                                                                                        <td>
                                                                                            <p>string</p>
                                                                                        </td>
                                                                                        <td>
                                                                                            <p>
                                                                                                '2' => 'Wordpress',
                                                                                                '3' => 'Shopify',
                                                                                                '4' => 'Magento',
                                                                                                '5' => 'Others',
                                                                                            </p>
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td>
                                                                                            <p>4</p>
                                                                                        </td>
                                                                                        <td>
                                                                                            <p>shipment_ref</p>
                                                                                        </td>
                                                                                        <td>
                                                                                            <p>Shipment Referance (Must be
                                                                                                unique)</p>
                                                                                        </td>
                                                                                        <td>
                                                                                            <p>Mandatory</p>
                                                                                        </td>
                                                                                        <td>
                                                                                            <p>string</p>
                                                                                        </td>
                                                                                        <td>
                                                                                            <p>
                                                                                                ref--0001
                                                                                            </p>
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td>
                                                                                            <p>5</p>
                                                                                        </td>
                                                                                        <td>
                                                                                            <p>pickup_location</p>
                                                                                        </td>
                                                                                        <td>
                                                                                            <p>Pickup location id</p>
                                                                                        </td>
                                                                                        <td>
                                                                                            <p>Mandatory</p>
                                                                                        </td>
                                                                                        <td>
                                                                                            <p>string</p>
                                                                                        </td>
                                                                                        <td>
                                                                                            <p>
                                                                                                1
                                                                                            </p>
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td>
                                                                                            <p>6</p>
                                                                                        </td>
                                                                                        <td>
                                                                                            <p>name</p>
                                                                                        </td>
                                                                                        <td>
                                                                                            <p>Consignee Name</p>
                                                                                        </td>
                                                                                        <td>
                                                                                            <p>Mandatory</p>
                                                                                        </td>
                                                                                        <td>
                                                                                            <p>string</p>
                                                                                        </td>
                                                                                        <td>
                                                                                            <p>
                                                                                                Sydnee Meyers
                                                                                            </p>
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td>
                                                                                            <p>7</p>
                                                                                        </td>
                                                                                        <td>
                                                                                            <p>email</p>
                                                                                        </td>
                                                                                        <td>
                                                                                            <p>Consignee Email</p>
                                                                                        </td>
                                                                                        <td>
                                                                                            <p>Mandatory</p>
                                                                                        </td>
                                                                                        <td>
                                                                                            <p>string</p>
                                                                                        </td>
                                                                                        <td>
                                                                                            <p>
                                                                                                demo@demo.com
                                                                                            </p>
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td>
                                                                                            <p>8</p>
                                                                                        </td>
                                                                                        <td>
                                                                                            <p>phone</p>
                                                                                        </td>
                                                                                        <td>
                                                                                            <p>Consignee Phone</p>
                                                                                        </td>
                                                                                        <td>
                                                                                            <p>Mandatory</p>
                                                                                        </td>
                                                                                        <td>
                                                                                            <p>string</p>
                                                                                        </td>
                                                                                        <td>
                                                                                            <p>
                                                                                                0000-0000000
                                                                                            </p>
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td>
                                                                                            <p>9</p>
                                                                                        </td>
                                                                                        <td>
                                                                                            <p>address</p>
                                                                                        </td>
                                                                                        <td>
                                                                                            <p>Consignee Address</p>
                                                                                        </td>
                                                                                        <td>
                                                                                            <p>Mandatory</p>
                                                                                        </td>
                                                                                        <td>
                                                                                            <p>string</p>
                                                                                        </td>
                                                                                        <td>
                                                                                            <p>R-99 Imaginary street</p>
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td>
                                                                                            <p>10</p>
                                                                                        </td>
                                                                                        <td>
                                                                                            <p>destination_country</p>
                                                                                        </td>
                                                                                        <td>
                                                                                            <p>Destination Country</p>
                                                                                        </td>
                                                                                        <td>
                                                                                            <p>Mandatory</p>
                                                                                        </td>
                                                                                        <td>
                                                                                            <p>string</p>
                                                                                        </td>
                                                                                        <td>
                                                                                            <p>Saudi Arabia</p>
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td>
                                                                                            <p>11</p>
                                                                                        </td>
                                                                                        <td>
                                                                                            <p>destination_city</p>
                                                                                        </td>
                                                                                        <td>
                                                                                            <p>Destination City </p>
                                                                                        </td>
                                                                                        <td>
                                                                                            <p>Mandatory</p>
                                                                                        </td>
                                                                                        <td>
                                                                                            <p>string</p>
                                                                                        </td>
                                                                                        <td>
                                                                                            <p>Riyadh</p>
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td>
                                                                                            <p>12</p>
                                                                                        </td>
                                                                                        <td>
                                                                                            <p>product_detail</p>
                                                                                        </td>
                                                                                        <td>
                                                                                            <p>Product Details</p>
                                                                                        </td>
                                                                                        <td>
                                                                                            <p>Mandatory</p>
                                                                                        </td>
                                                                                        <td>
                                                                                            <p>string</p>
                                                                                        </td>
                                                                                        <td>
                                                                                            <p>printed t-shirt</p>
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td>
                                                                                            <p>13</p>
                                                                                        </td>
                                                                                        <td>
                                                                                            <p>service</p>
                                                                                        </td>
                                                                                        <td>
                                                                                            <p>Service Code</p>
                                                                                        </td>
                                                                                        <td>
                                                                                            <p>Mandatory</p>
                                                                                        </td>
                                                                                        <td>
                                                                                            <p>string</p>
                                                                                        </td>
                                                                                        <td>
                                                                                            <p>GCC</p>
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td>
                                                                                            <p>14</p>
                                                                                        </td>
                                                                                        <td>
                                                                                            <p>payment_method_id</p>
                                                                                        </td>
                                                                                        <td>
                                                                                            <p>Payment Method Id</p>
                                                                                        </td>
                                                                                        <td>
                                                                                            <p>Mandatory</p>
                                                                                        </td>
                                                                                        <td>
                                                                                            <p>string</p>
                                                                                        </td>
                                                                                        <td>
                                                                                            <p>1 => COD , 2 => CC</p>
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td>
                                                                                            <p>15</p>
                                                                                        </td>
                                                                                        <td>
                                                                                            <p>order_amount</p>
                                                                                        </td>
                                                                                        <td>
                                                                                            <p>Order Ammount</p>
                                                                                        </td>
                                                                                        <td>
                                                                                            <p>Mandatory</p>
                                                                                        </td>
                                                                                        <td>
                                                                                            <p>string</p>
                                                                                        </td>
                                                                                        <td>
                                                                                            <p>500</p>
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td>
                                                                                            <p>16</p>
                                                                                        </td>
                                                                                        <td>
                                                                                            <p>currency_code</p>
                                                                                        </td>
                                                                                        <td>
                                                                                            <p>Currency Code</p>
                                                                                        </td>
                                                                                        <td>
                                                                                            <p>Mandatory</p>
                                                                                        </td>
                                                                                        <td>
                                                                                            <p>string</p>
                                                                                        </td>
                                                                                        <td>
                                                                                            <p>PKR</p>
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td>
                                                                                            <p>17</p>
                                                                                        </td>
                                                                                        <td>
                                                                                            <p>peices</p>
                                                                                        </td>
                                                                                        <td>
                                                                                            <p>Peices</p>
                                                                                        </td>
                                                                                        <td>
                                                                                            <p>Mandatory</p>
                                                                                        </td>
                                                                                        <td>
                                                                                            <p>string</p>
                                                                                        </td>
                                                                                        <td>
                                                                                            <p>1</p>
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td>
                                                                                            <p>18</p>
                                                                                        </td>
                                                                                        <td>
                                                                                            <p>weight</p>
                                                                                        </td>
                                                                                        <td>
                                                                                            <p>Weight ( in kilo grams KG )
                                                                                            </p>
                                                                                        </td>
                                                                                        <td>
                                                                                            <p>Mandatory</p>
                                                                                        </td>
                                                                                        <td>
                                                                                            <p>string</p>
                                                                                        </td>
                                                                                        <td>
                                                                                            <p>2</p>
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td>
                                                                                            <p>19</p>
                                                                                        </td>
                                                                                        <td>
                                                                                            <p>fragile</p>
                                                                                        </td>
                                                                                        <td>
                                                                                            <p>Fragile</p>
                                                                                        </td>
                                                                                        <td>
                                                                                            <p>Mandatory</p>
                                                                                        </td>
                                                                                        <td>
                                                                                            <p>string</p>
                                                                                        </td>
                                                                                        <td>
                                                                                            <p>0 => NO , 1 => YES</p>
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td>
                                                                                            <p>20</p>
                                                                                        </td>
                                                                                        <td>
                                                                                            <p>insurance</p>
                                                                                        </td>
                                                                                        <td>
                                                                                            <p>Insurance</p>
                                                                                        </td>
                                                                                        <td>
                                                                                            <p>Mandatory</p>
                                                                                        </td>
                                                                                        <td>
                                                                                            <p>string</p>
                                                                                        </td>
                                                                                        <td>
                                                                                            <p>0 => NO , 1 => YES</p>
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td>
                                                                                            <p>20</p>
                                                                                        </td>
                                                                                        <td>
                                                                                            <p>insurance_amt</p>
                                                                                        </td>
                                                                                        <td>
                                                                                            <p>Insurance Ammount</p>
                                                                                        </td>
                                                                                        <td>
                                                                                            <p>Optional</p>
                                                                                        </td>
                                                                                        <td>
                                                                                            <p>string</p>
                                                                                        </td>
                                                                                        <td>
                                                                                            <p>10</p>
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td>
                                                                                            <p>21</p>
                                                                                        </td>
                                                                                        <td>
                                                                                            <p>comments</p>
                                                                                        </td>
                                                                                        <td>
                                                                                            <p>Comments</p>
                                                                                        </td>
                                                                                        <td>
                                                                                            <p>Optional</p>
                                                                                        </td>
                                                                                        <td>
                                                                                            <p>string</p>
                                                                                        </td>
                                                                                        <td>
                                                                                            <p>Any commnets</p>
                                                                                        </td>
                                                                                    </tr>
                                                                                </tbody>
                                                                            </table>
                                                                        </div>
                                                                    </div>
                                                                    <div class="api-box">
                                                                        <h5 class="mb-3">
                                                                            <b>API Parameters</b>
                                                                        </h5>
                                                                        <div class="view-data mb-5">
                                                                            <p class="main-p">
                                                                                <span class="kurly_braces">{</span>
                                                                            </p>
                                                                            <div class="main_veiw_1">
                                                                                <p class="main-p">
                                                                                    <span>&nbsp;</span>
                                                                                    <span
                                                                                        class="api_detail_text">&quot;company_id&quot;</span>
                                                                                    <span class="colons">:&nbsp;</span>
                                                                                    <span
                                                                                        class="api_detail_text_1">100004</span>
                                                                                    <span class="colons">,</span>
                                                                                </p>
                                                                                <p class="main-p">
                                                                                    <span>&nbsp; </span>
                                                                                    <span
                                                                                        class="api_detail_text">&quot;customer_acno&quot;</span>
                                                                                    <span class="colons">:&nbsp;</span>
                                                                                    <span
                                                                                        class="api_detail_text_1">1000001</span>
                                                                                    <span class="colons">,</span>
                                                                                </p>
                                                                                <p class="main-p">
                                                                                    <span>&nbsp;</span>
                                                                                    <span
                                                                                        class="api_detail_text">&quot;device&quot;</span>
                                                                                    <span class="colons">:&nbsp;</span>
                                                                                    <span
                                                                                        class="api_detail_text_1">&quot;1&quot;</span>
                                                                                    <span class="colons">,</span>
                                                                                </p>
                                                                                <p class="main-p">
                                                                                    <span>&nbsp; </span>
                                                                                    <span
                                                                                        class="api_detail_text">&quot;flag&quot;</span>
                                                                                    <span class="colons">:&nbsp;</span>
                                                                                    <span
                                                                                        class="api_detail_text_1">&quot;Bulk
                                                                                        Uploading&quot;</span>
                                                                                    <span class="colons">,</span>
                                                                                </p>
                                                                                <p class="main-p">
                                                                                    <span>&nbsp; </span>
                                                                                    <span
                                                                                        class="api_detail_text">&quot;shipments&quot;</span>
                                                                                    <span class="colons">:&nbsp;</span>
                                                                                    <span
                                                                                        class="api_detail_text_1">[</span>
                                                                                </p>
                                                                                <p class="main-p">
                                                                                    <span
                                                                                        class="kurly_braces">&nbsp;&nbsp;&nbsp;
                                                                                        &nbsp;&nbsp;&nbsp;{</span>
                                                                                </p>

                                                                                <p class="main-p">
                                                                                    <span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                                                                    <span
                                                                                        class="api_detail_text">&quot;shipment_ref&quot;</span>
                                                                                    <span class="colons">:&nbsp;</span>
                                                                                    <span
                                                                                        class="api_detail_text_1">&quot;ref--0001&quot;</span>
                                                                                    <span class="colons">,</span>
                                                                                </p>
                                                                                <p class="main-p">
                                                                                    <span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                                                                    <span
                                                                                        class="api_detail_text">&quot;pickup_location&quot;</span>
                                                                                    <span class="colons">:&nbsp;</span>
                                                                                    <span
                                                                                        class="api_detail_text_1">&quot;1&quot;</span>
                                                                                    <span class="colons">,</span>
                                                                                </p>
                                                                                <p class="main-p">
                                                                                    <span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                                                                    <span
                                                                                        class="api_detail_text">&quot;name&quot;</span>
                                                                                    <span class="colons">:&nbsp;</span>
                                                                                    <span
                                                                                        class="api_detail_text_1">&quot;Sydnee
                                                                                        Meyers&quot;</span>
                                                                                    <span class="colons">,</span>
                                                                                </p>
                                                                                <p class="main-p">
                                                                                    <span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                                                                    <span
                                                                                        class="api_detail_text">&quot;email&quot;</span>
                                                                                    <span class="colons">:&nbsp;</span>
                                                                                    <span
                                                                                        class="api_detail_text_1">&quot;demo@demo.com&quot;</span>
                                                                                    <span class="colons">,</span>
                                                                                </p>
                                                                                <p class="main-p">
                                                                                    <span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                                                                    <span
                                                                                        class="api_detail_text">&quot;phone&quot;</span>
                                                                                    <span class="colons">:&nbsp;</span>
                                                                                    <span
                                                                                        class="api_detail_text_1">&quot;0000-0000000&quot;</span>
                                                                                    <span class="colons">,</span>
                                                                                </p>
                                                                                <p class="main-p">
                                                                                    <span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                                                                    <span
                                                                                        class="api_detail_text">&quot;address&quot;</span>
                                                                                    <span class="colons">:&nbsp;</span>
                                                                                    <span
                                                                                        class="api_detail_text_1">&quot;R-99
                                                                                        Imaginary street&quot;</span>
                                                                                    <span class="colons">,</span>
                                                                                </p>
                                                                                <p class="main-p">
                                                                                    <span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                                                                    <span
                                                                                        class="api_detail_text">&quot;destination_country&quot;</span>
                                                                                    <span class="colons">:&nbsp;</span>
                                                                                    <span
                                                                                        class="api_detail_text_1">&quot;Saudi Arabia&quot;</span>
                                                                                    <span class="colons">,</span>
                                                                                </p>
                                                                                <p class="main-p">
                                                                                    <span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                                                                    <span
                                                                                        class="api_detail_text">&quot;destination_city&quot;</span>
                                                                                    <span class="colons">:&nbsp;</span>
                                                                                    <span
                                                                                        class="api_detail_text_1">&quot;Riyadh&quot;</span>
                                                                                    <span class="colons">,</span>
                                                                                </p>
                                                                                <p class="main-p">
                                                                                    <span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                                                                    <span
                                                                                        class="api_detail_text">&quot;product_detail&quot;</span>
                                                                                    <span class="colons">:&nbsp;</span>
                                                                                    <span
                                                                                        class="api_detail_text_1">&quot;printed
                                                                                        t-shirt&quot;</span>
                                                                                    <span class="colons">,</span>
                                                                                </p>
                                                                                <p class="main-p">
                                                                                    <span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                                                                    <span
                                                                                        class="api_detail_text">&quot;service&quot;</span>
                                                                                    <span class="colons">:&nbsp;</span>
                                                                                    <span
                                                                                        class="api_detail_text_1">&quot;GCC&quot;</span>
                                                                                    <span class="colons">,</span>
                                                                                </p>
                                                                                <p class="main-p">
                                                                                    <span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                                                                    <span
                                                                                        class="api_detail_text">&quot;payment_method_id&quot;</span>
                                                                                    <span class="colons">:&nbsp;</span>
                                                                                    <span
                                                                                        class="api_detail_text_1">&quot;1&quot;</span>
                                                                                    <span class="colons">,</span>
                                                                                </p>
                                                                                <p class="main-p">
                                                                                    <span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                                                                    <span
                                                                                        class="api_detail_text">&quot;order_amount&quot;</span>
                                                                                    <span class="colons">:&nbsp;</span>
                                                                                    <span
                                                                                        class="api_detail_text_1">&quot;500&quot;</span>
                                                                                    <span class="colons">,</span>
                                                                                </p>
                                                                                <p class="main-p">
                                                                                    <span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                                                                    <span
                                                                                        class="api_detail_text">&quot;currency_code&quot;</span>
                                                                                    <span class="colons">:&nbsp;</span>
                                                                                    <span
                                                                                        class="api_detail_text_1">&quot;AED&quot;</span>
                                                                                    <span class="colons">,</span>
                                                                                </p>
                                                                                <p class="main-p">
                                                                                    <span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                                                                    <span
                                                                                        class="api_detail_text">&quot;peices&quot;</span>
                                                                                    <span class="colons">:&nbsp;</span>
                                                                                    <span
                                                                                        class="api_detail_text_1">&quot;1&quot;</span>
                                                                                    <span class="colons">,</span>
                                                                                </p>
                                                                                <p class="main-p">
                                                                                    <span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                                                                    <span
                                                                                        class="api_detail_text">&quot;weight&quot;</span>
                                                                                    <span class="colons">:&nbsp;</span>
                                                                                    <span
                                                                                        class="api_detail_text_1">&quot;1&quot;</span>
                                                                                    <span class="colons">,</span>
                                                                                </p>
                                                                                <p class="main-p">
                                                                                    <span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                                                                    <span
                                                                                        class="api_detail_text">&quot;fragile&quot;</span>
                                                                                    <span class="colons">:&nbsp;</span>
                                                                                    <span
                                                                                        class="api_detail_text_1">&quot;0&quot;</span>
                                                                                    <span class="colons">,</span>
                                                                                </p>
                                                                                <p class="main-p">
                                                                                    <span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                                                                    <span
                                                                                        class="api_detail_text">&quot;insurance&quot;</span>
                                                                                    <span class="colons">:&nbsp;</span>
                                                                                    <span
                                                                                        class="api_detail_text_1">&quot;0&quot;</span>
                                                                                    <span class="colons">,</span>
                                                                                </p>
                                                                                <p class="main-p">
                                                                                    <span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                                                                    <span
                                                                                        class="api_detail_text">&quot;insurance_amt&quot;</span>
                                                                                    <span class="colons">:&nbsp;</span>
                                                                                    <span
                                                                                        class="api_detail_text_1">&quot;0&quot;</span>
                                                                                    <span class="colons">,</span>
                                                                                </p>

                                                                                <p class="main-p">
                                                                                    <span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                                                                    <span
                                                                                        class="api_detail_text">&quot;comments&quot;</span>
                                                                                    <span class="colons">:&nbsp;</span>
                                                                                    <span
                                                                                        class="api_detail_text_1">&quot;Any
                                                                                        comments&quot;</span>
                                                                                    <span class="colons">,</span>
                                                                                </p>


                                                                                <p class="main-p">
                                                                                    <span
                                                                                        class="kurly_braces">&nbsp;&nbsp;&nbsp;
                                                                                        &nbsp;&nbsp;&nbsp;}</span>
                                                                                </p>
                                                                                <p class="main-p">
                                                                                    <span class="kurly_braces">
                                                                                        &nbsp;
                                                                                        &nbsp;&nbsp;&nbsp;]</span>
                                                                                </p>
                                                                                <p class="main-p"
                                                                                    style="margin-left: -30px;">
                                                                                    <span class="kurly_braces">}</span>
                                                                                </p>
                                                                            </div>
                                                                        </div>
                                                                        <div class="api-box">
                                                                            <h5 class="mb-3">
                                                                                <b>Success Response</b>
                                                                            </h5>
                                                                            <div class="view-data mb-5">
                                                                                <p class="main-p">
                                                                                    <span class="kurly_braces">&nbsp;
                                                                                        {</span>
                                                                                </p>
                                                                                <p class="main-p">
                                                                                    <span>&nbsp; &nbsp; &nbsp; &nbsp;
                                                                                        &nbsp;</span>
                                                                                    <span
                                                                                        class="api_detail_text">&quot;status&quot;</span>
                                                                                    <span class="colons">:&nbsp;</span>
                                                                                    <span
                                                                                        class="api_detail_text_1">&quot;1&quot;</span>
                                                                                    <span class="colons">,</span>
                                                                                </p>
                                                                                <p class="main-p">
                                                                                    <span>&nbsp; &nbsp; &nbsp; &nbsp;
                                                                                        &nbsp;</span>
                                                                                    <span
                                                                                        class="api_detail_text">&quot;message&quot;</span>
                                                                                    <span class="colons">:&nbsp;</span>
                                                                                    <span
                                                                                        class="api_detail_text_1">&quot;Booking
                                                                                        has been created
                                                                                        successfully&quot;</span>
                                                                                    <span class="colons">,</span>
                                                                                </p>
                                                                                <p class="main-p">
                                                                                    <span>&nbsp; &nbsp; &nbsp; &nbsp;
                                                                                        &nbsp;</span>
                                                                                    <span
                                                                                        class="api_detail_text">&quot;payload&quot;</span>
                                                                                    <span class="colons">:&nbsp;</span>
                                                                                    <span
                                                                                        class="api_detail_text_1">{</span>
                                                                                </p>
                                                                                <p class="main-p">
                                                                                    <span>&nbsp; &nbsp; &nbsp; &nbsp;
                                                                                        &nbsp;</span>
                                                                                    <span
                                                                                        class="api_detail_text">&quot;success&quot;</span>
                                                                                    <span class="colons">:&nbsp;</span>
                                                                                    <span
                                                                                        class="api_detail_text_1">[</span>
                                                                                </p>
                                                                                <p class="main-p">
                                                                                    <span
                                                                                        class="kurly_braces">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                                        {</span>
                                                                                </p>
                                                                                <p class="main-p">
                                                                                    <span>&nbsp; &nbsp; &nbsp; &nbsp;
                                                                                        &nbsp;&nbsp; &nbsp; &nbsp; &nbsp;
                                                                                        &nbsp;</span>
                                                                                    <span
                                                                                        class="api_detail_text">&quot;status&quot;</span>
                                                                                    <span class="colons">:&nbsp;</span>
                                                                                    <span
                                                                                        class="api_detail_text_1">&quot;1&quot;</span>
                                                                                    <span class="colons">,</span>
                                                                                </p>
                                                                                <p class="main-p">
                                                                                    <span>&nbsp; &nbsp; &nbsp; &nbsp;
                                                                                        &nbsp;&nbsp; &nbsp; &nbsp; &nbsp;
                                                                                        &nbsp;</span>
                                                                                    <span
                                                                                        class="api_detail_text">&quot;message&quot;</span>
                                                                                    <span class="colons">:&nbsp;</span>
                                                                                    <span
                                                                                        class="api_detail_text_1">&quot;Booking
                                                                                        has been created&quot;</span>
                                                                                    <span class="colons">,</span>
                                                                                </p>
                                                                                <p class="main-p">
                                                                                    <span>&nbsp; &nbsp; &nbsp; &nbsp;
                                                                                        &nbsp;&nbsp; &nbsp; &nbsp; &nbsp;
                                                                                        &nbsp;</span>
                                                                                    <span
                                                                                        class="api_detail_text">&quot;shipment_ref&quot;</span>
                                                                                    <span class="colons">:&nbsp;</span>
                                                                                    <span
                                                                                        class="api_detail_text_1">&quot;ref--0001&quot;</span>
                                                                                    <span class="colons">,</span>
                                                                                </p>
                                                                                <p class="main-p">
                                                                                    <span>&nbsp; &nbsp; &nbsp; &nbsp;
                                                                                        &nbsp;&nbsp; &nbsp; &nbsp; &nbsp;
                                                                                        &nbsp;</span>
                                                                                    <span
                                                                                        class="api_detail_text">&quot;consignment_no&quot;</span>
                                                                                    <span class="colons">:&nbsp;</span>
                                                                                    <span
                                                                                        class="api_detail_text_1">&quot;111002020&quot;</span>
                                                                                </p>
                                                                                <p class="main-p">
                                                                                    <span
                                                                                        class="kurly_braces">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                                        }</span>
                                                                                </p>
                                                                                <p class="main-p">
                                                                                    <span
                                                                                        class="kurly_braces">&nbsp;&nbsp;&nbsp;&nbsp;
                                                                                        ]</span>
                                                                                </p>

                                                                                <p class="main-p">
                                                                                    <span>&nbsp; &nbsp; &nbsp; &nbsp;
                                                                                        &nbsp;</span>
                                                                                    <span
                                                                                        class="api_detail_text">&quot;error&quot;</span>
                                                                                    <span class="colons">:&nbsp;</span>
                                                                                    <span
                                                                                        class="api_detail_text_1">[</span>
                                                                                </p>
                                                                                <p class="main-p">
                                                                                    <span
                                                                                        class="kurly_braces">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                                        ]</span>
                                                                                </p>
                                                                                <p class="main-p">
                                                                                    <span
                                                                                        class="kurly_braces">&nbsp;&nbsp;&nbsp;&nbsp;
                                                                                        }</span>
                                                                                </p>
                                                                                <p class="main-p">
                                                                                    <span class="kurly_braces">&nbsp;
                                                                                        }</span>
                                                                                </p>
                                                                            </div>
                                                                        </div>
                                                                        <div class="api-box">
                                                                            <h5 class="mb-3">
                                                                                <b>Response with Errors</b>
                                                                            </h5>
                                                                            <div class="view-data mb-5">
                                                                                <p class="main-p">
                                                                                    <span class="kurly_braces">{</span>
                                                                                </p>
                                                                                <p class="main-p">
                                                                                    <span>&nbsp; &nbsp; &nbsp; &nbsp;
                                                                                        &nbsp;</span>
                                                                                    <span
                                                                                        class="api_detail_text">&quot;status&quot;</span>
                                                                                    <span class="colons">:&nbsp;</span>
                                                                                    <span
                                                                                        class="api_detail_text_1">&quot;0&quot;</span>
                                                                                    <span class="colons">,</span>
                                                                                </p>
                                                                                <p class="main-p">
                                                                                    <span>&nbsp; &nbsp; &nbsp; &nbsp;
                                                                                        &nbsp;</span>
                                                                                    <span
                                                                                        class="api_detail_text">&quot;message&quot;</span>
                                                                                    <span class="colons">:&nbsp;</span>
                                                                                    <span
                                                                                        class="api_detail_text_1">&quot;shipment
                                                                                        ref is duplicate&quot;</span>
                                                                                    <span class="colons">,</span>
                                                                                </p>
                                                                                <p class="main-p">
                                                                                    <span>&nbsp; &nbsp; &nbsp; &nbsp;
                                                                                        &nbsp;</span>
                                                                                    <span
                                                                                        class="api_detail_text">&quot;payload&quot;</span>
                                                                                    <span class="colons">:&nbsp;</span>
                                                                                    <span
                                                                                        class="api_detail_text_1">{</span>
                                                                                </p>
                                                                                <p class="main-p">
                                                                                    <span>&nbsp; &nbsp; &nbsp; &nbsp;&nbsp;
                                                                                        &nbsp;&nbsp; &nbsp;
                                                                                        &nbsp;</span>
                                                                                    <span
                                                                                        class="api_detail_text">&quot;success&quot;</span>
                                                                                    <span class="colons">:&nbsp;</span>
                                                                                    <span
                                                                                        class="api_detail_text_1">[</span>
                                                                                </p>
                                                                                <p class="main-p">
                                                                                    <span
                                                                                        class="kurly_braces">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                                        {</span>
                                                                                </p>

                                                                                <p class="main-p">
                                                                                    <span
                                                                                        class="kurly_braces">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                                        }</span>
                                                                                </p>
                                                                                <p class="main-p">
                                                                                    <span class="kurly_braces">&nbsp;
                                                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                                        ],</span>
                                                                                </p>
                                                                                <p class="main-p">
                                                                                    <span>&nbsp; &nbsp; &nbsp; &nbsp;
                                                                                        &nbsp;</span>
                                                                                    <span
                                                                                        class="api_detail_text">&quot;error&quot;</span>
                                                                                    <span class="colons">:&nbsp;</span>
                                                                                    <span
                                                                                        class="api_detail_text_1">[</span>
                                                                                </p>
                                                                                <p class="main-p">
                                                                                    <span
                                                                                        class="kurly_braces">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                                        {</span>
                                                                                </p>

                                                                                <p class="main-p">
                                                                                    <span>&nbsp; &nbsp; &nbsp; &nbsp;
                                                                                        &nbsp;&nbsp; &nbsp; &nbsp; &nbsp;
                                                                                        &nbsp;</span>
                                                                                    <span
                                                                                        class="api_detail_text">&quot;status&quot;</span>
                                                                                    <span class="colons">:&nbsp;</span>
                                                                                    <span
                                                                                        class="api_detail_text_1">&quot;0&quot;</span>
                                                                                    <span class="colons">,</span>
                                                                                </p>
                                                                                <p class="main-p">
                                                                                    <span>&nbsp; &nbsp; &nbsp; &nbsp;
                                                                                        &nbsp;&nbsp; &nbsp; &nbsp; &nbsp;
                                                                                        &nbsp;</span>
                                                                                    <span
                                                                                        class="api_detail_text">&quot;message&quot;</span>
                                                                                    <span class="colons">:&nbsp;</span>
                                                                                    <span
                                                                                        class="api_detail_text_1">&quot;shipment
                                                                                        ref is duplicate&quot;</span>
                                                                                    <span class="colons">,</span>
                                                                                </p>
                                                                                <p class="main-p">
                                                                                    <span>&nbsp; &nbsp; &nbsp; &nbsp;
                                                                                        &nbsp;&nbsp; &nbsp; &nbsp; &nbsp;
                                                                                        &nbsp;</span>
                                                                                    <span
                                                                                        class="api_detail_text">&quot;shipment_ref&quot;</span>
                                                                                    <span class="colons">:&nbsp;</span>
                                                                                    <span
                                                                                        class="api_detail_text_1">&quot;ref--0001&quot;</span>
                                                                                    <span class="colons">,</span>
                                                                                </p>
                                                                                <p class="main-p">
                                                                                    <span>&nbsp; &nbsp; &nbsp; &nbsp;
                                                                                        &nbsp;&nbsp; &nbsp; &nbsp; &nbsp;
                                                                                        &nbsp;</span>
                                                                                    <span
                                                                                        class="api_detail_text">&quot;consignment_no&quot;</span>
                                                                                    <span class="colons">:&nbsp;</span>
                                                                                    <span
                                                                                        class="api_detail_text_1">&quot;&quot;</span>
                                                                                </p>
                                                                                <p class="main-p">
                                                                                    <span
                                                                                        class="kurly_braces">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                                        }</span>
                                                                                </p>
                                                                                <p class="main-p">
                                                                                    <span
                                                                                        class="kurly_braces">&nbsp;&nbsp;&nbsp;&nbsp;
                                                                                        ]</span>
                                                                                </p>
                                                                                <p class="main-p">
                                                                                    <span class="kurly_braces">&nbsp;&nbsp;
                                                                                        }</span>
                                                                                </p>
                                                                                <p class="main-p">
                                                                                    <span class="kurly_braces">
                                                                                        }</span>
                                                                                </p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            {{-- void --}}
                                                            <div class="tab-pane fade" id="v-pills-open-api-void"
                                                                role="tabpanel">
                                                                <h4 class="mb-3">
                                                                    <b>Shipments Void API</b>
                                                                </h4>
                                                                <div class="detail-bx mb-5">
                                                                    <h5 class="mb-3">
                                                                        <b>Shipments Void List</b>
                                                                    </h5>
                                                                    <p>In order to get a shipments void here is the
                                                                        link
                                                                        enable to get all information.</p>
                                                                    <div class="mb-3">
                                                                        <span>
                                                                            <b>METHOD :</b>
                                                                        </span>
                                                                        <span>POST</span>
                                                                    </div>
                                                                    <div class="url-box mb-1">
                                                                        <a href="javascript:;">URL:
                                                                            {{ config('app.api_url') . 'shipment/cancle' }}</a>
                                                                    </div>
                                                                    <p class="mb-5"><b>Note:</b> Data should be in
                                                                        JSON
                                                                        Format</p>
                                                                </div>
                                                                <div class="detail-bx mb-5">
                                                                    <h4 class="mb-3">
                                                                        <b>PARAMETERS</b>
                                                                    </h4>
                                                                    <h5 class="mb-3">For Pickup Locations List</h5>
                                                                    <div class="Parameter">
                                                                        <table class="table table-bordered">
                                                                            <tbody>
                                                                                <tr>
                                                                                    <td>
                                                                                        <p>
                                                                                            <strong>S.no.</strong>
                                                                                        </p>
                                                                                    </td>
                                                                                    <td>
                                                                                        <p>
                                                                                            <strong>Parameter</strong>
                                                                                        </p>
                                                                                    </td>
                                                                                    <td>
                                                                                        <p>
                                                                                            <strong>Description</strong>
                                                                                        </p>
                                                                                    </td>
                                                                                    <td>
                                                                                        <p>
                                                                                            <strong>Condition</strong>
                                                                                        </p>
                                                                                    </td>
                                                                                    <td>
                                                                                        <p>
                                                                                            <strong>Format</strong>
                                                                                        </p>
                                                                                    </td>
                                                                                    <td>
                                                                                        <p>
                                                                                            <strong>Sample</strong>
                                                                                        </p>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>
                                                                                        <p>1</p>
                                                                                    </td>
                                                                                    <td>
                                                                                        <p>consignment_no</p>
                                                                                    </td>
                                                                                    <td>
                                                                                        <p>Consignment No</p>
                                                                                    </td>
                                                                                    <td>
                                                                                        <p>Mandatory</p>
                                                                                    </td>
                                                                                    <td>
                                                                                        <p>Array</p>
                                                                                    </td>
                                                                                    <td>
                                                                                        <p>["111001705"]</p>
                                                                                    </td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                                <div class="api-box">
                                                                    <h5 class="mb-3">
                                                                        <b>API Parameters</b>
                                                                    </h5>
                                                                    <div class="view-data mb-5">
                                                                        <p class="main-p">
                                                                            <span class="kurly_braces">{</span>
                                                                        </p>
                                                                        <p class="main-p">
                                                                            <span>&nbsp; &nbsp; &nbsp; &nbsp;
                                                                                &nbsp;</span>
                                                                            <span
                                                                                class="api_detail_text">&quot;consignment_no&quot;</span>
                                                                            <span class="colons">:&nbsp;</span>
                                                                            <span
                                                                                class="api_detail_text_1">[&quot;111001705&quot;]</span>
                                                                        </p>
                                                                        <p class="main-p">
                                                                            <span class="kurly_braces">}</span>
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                                <div class="api-box">
                                                                    <h5 class="mb-3">
                                                                        <b>Success Response</b>
                                                                    </h5>
                                                                    <div class="view-data mb-5">
                                                                        <p class="main-p">
                                                                            <span class="kurly_braces">&nbsp; {</span>
                                                                        </p>

                                                                        <p class="main-p">
                                                                            <span>&nbsp; &nbsp; &nbsp; &nbsp;
                                                                                &nbsp;</span>
                                                                            <span
                                                                                class="api_detail_text">&quot;status&quot;</span>
                                                                            <span class="colons">:&nbsp;</span>
                                                                            <span
                                                                                class="api_detail_text_1">&quot;1&quot;</span>
                                                                            <span class="colons">,</span>
                                                                        </p>
                                                                        <p class="main-p">
                                                                            <span>&nbsp; &nbsp; &nbsp; &nbsp;
                                                                                &nbsp;</span>
                                                                            <span
                                                                                class="api_detail_text">&quot;Message&quot;</span>
                                                                            <span class="colons">:&nbsp;</span>
                                                                            <span
                                                                                class="api_detail_text_1">&quot;Success&quot;</span>
                                                                            <span class="colons">,</span>
                                                                        </p>
                                                                        <p class="main-p">
                                                                            <span>&nbsp; &nbsp; &nbsp; &nbsp;
                                                                                &nbsp;</span>
                                                                            <span
                                                                                class="api_detail_text">&quot;payload&quot;</span>
                                                                            <span class="colons">:&nbsp;</span>
                                                                            <span class="api_detail_text_1">&quot;shipments
                                                                                are cancled&quot;</span>
                                                                        </p>
                                                                        <p class="main-p">
                                                                            <span class="kurly_braces">&nbsp; }</span>
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                                <div class="api-box">
                                                                    <h5 class="mb-3">
                                                                        <b>Response with Errors</b>
                                                                    </h5>
                                                                    <div class="view-data mb-5">
                                                                        <p class="main-p">
                                                                            <span class="kurly_braces">&nbsp;
                                                                                {</span>
                                                                        </p>
                                                                        <p class="main-p">
                                                                            <span>&nbsp; &nbsp; &nbsp; &nbsp;
                                                                                &nbsp;</span>
                                                                            <span
                                                                                class="api_detail_text">&quot;status&quot;</span>
                                                                            <span class="colons">:&nbsp;</span>
                                                                            <span
                                                                                class="api_detail_text_1">&quot;0&quot;</span>
                                                                            <span class="colons">,</span>
                                                                        </p>
                                                                        <p class="main-p">
                                                                            <span>&nbsp; &nbsp; &nbsp; &nbsp;
                                                                                &nbsp;</span>
                                                                            <span
                                                                                class="api_detail_text">&quot;Message&quot;</span>
                                                                            <span class="colons">:&nbsp;</span>
                                                                            <span
                                                                                class="api_detail_text_1">&quot;Error&quot;</span>
                                                                            <span class="colons">,</span>
                                                                        </p>
                                                                        <p class="main-p">
                                                                            <span>&nbsp; &nbsp; &nbsp; &nbsp;
                                                                                &nbsp;</span>
                                                                            <span
                                                                                class="api_detail_text">&quot;payload&quot;</span>
                                                                            <span class="colons">:&nbsp;</span>
                                                                            <span class="api_detail_text_1">&quot;Invalid
                                                                                consignment no&quot;</span>
                                                                        </p>
                                                                        <p class="main-p">
                                                                            <span class="kurly_braces">&nbsp;
                                                                                }</span>
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            {{-- track --}}
                                                            <div class="tab-pane fade" id="v-pills-open-api-track"
                                                                role="tabpanel">
                                                                <h4 class="mb-3">
                                                                    <b>TRACK ORDER API</b>
                                                                </h4>
                                                                <div class="detail-bx mb-5">
                                                                    <h5 class="mb-3">
                                                                        <b>TRACK ORDER</b>
                                                                    </h5>
                                                                    <p>In order to track a shipment/shipments here is
                                                                        the
                                                                        tracking link enable to put all information</p>
                                                                    <div class="mb-3">
                                                                        <span>
                                                                            <b>METHOD :</b>
                                                                        </span>
                                                                        <span>POST</span>
                                                                    </div>
                                                                    <div class="url-box mb-1">
                                                                        <a href="javascript:;">URL:
                                                                            {{ config('app.api_url') . 'tracking/index' }}</a>
                                                                    </div>
                                                                    <p class="mb-5"><b>Note:</b> Data should be in
                                                                        JSON
                                                                        Format</p>
                                                                    <h5 class="mb-3">
                                                                        <b>HEADERS</b>
                                                                    </h5>
                                                                    <table class="table no-footer table-bordered">
                                                                        <tbody>
                                                                            <tr>
                                                                                <th>Input</th>
                                                                                <th>Description</th>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>Authorization</td>
                                                                                <td><a href="#heads"> API Key to be
                                                                                        provided individually</a></td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                                <div class="detail-bx mb-5">
                                                                    <h4 class="mb-3">
                                                                        <b>PARAMETERS</b>
                                                                    </h4>
                                                                    <h5 class="mb-3">For Track Order</h5>
                                                                    <div class="Parameter">
                                                                        <table class="table table-bordered">
                                                                            <tbody>
                                                                                <tr>
                                                                                    <td>
                                                                                        <p>
                                                                                            <strong>S.no.</strong>
                                                                                        </p>
                                                                                    </td>
                                                                                    <td>
                                                                                        <p>
                                                                                            <strong>Parameter</strong>
                                                                                        </p>
                                                                                    </td>
                                                                                    <td>
                                                                                        <p>
                                                                                            <strong>Description</strong>
                                                                                        </p>
                                                                                    </td>
                                                                                    <td>
                                                                                        <p>
                                                                                            <strong>Condition</strong>
                                                                                        </p>
                                                                                    </td>
                                                                                    <td>
                                                                                        <p>
                                                                                            <strong>Format</strong>
                                                                                        </p>
                                                                                    </td>
                                                                                    <td>
                                                                                        <p>
                                                                                            <strong>Sample</strong>
                                                                                        </p>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>
                                                                                        <p>1</p>
                                                                                    </td>
                                                                                    <td>
                                                                                        <p>cn_numbers</p>
                                                                                    </td>
                                                                                    <td>
                                                                                        <p>Consignment Number</p>
                                                                                    </td>
                                                                                    <td>
                                                                                        <p>Mandatory</p>
                                                                                    </td>
                                                                                    <td>
                                                                                        <p>String</p>
                                                                                    </td>
                                                                                    <td>
                                                                                        <p>111001985</p>
                                                                                    </td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                                <div class="api-box">
                                                                    <h5 class="mb-3">
                                                                        <b>API Parameters</b>
                                                                    </h5>
                                                                    <div class="view-data mb-5">
                                                                        <p class="main-p">
                                                                            <span class="kurly_braces">{</span>
                                                                        </p>
                                                                        <p class="main-p">
                                                                            <span>&nbsp; &nbsp; &nbsp; &nbsp;
                                                                                &nbsp;</span>
                                                                            <span
                                                                                class="api_detail_text">&quot;cn_numbers&quot;</span>
                                                                            <span class="colons">:&nbsp;</span>
                                                                            <span
                                                                                class="api_detail_text_1">"111001985"</span>
                                                                            <span class="colons">,</span>
                                                                        </p>
                                                                        <p class="main-p">
                                                                            <span class="kurly_braces">}</span>
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                                <div class="api-box">
                                                                    <h5 class="mb-3">
                                                                        <b>Success Response</b>
                                                                    </h5>
                                                                    <div class="view-data mb-5">
                                                                        <p class="main-p">
                                                                            <span class="kurly_braces">&nbsp; {</span>
                                                                        </p>
                                                                        <p class="main-p">
                                                                            <span>&nbsp; &nbsp; &nbsp; &nbsp;
                                                                                &nbsp;</span>
                                                                            <span
                                                                                class="api_detail_text">&quot;status&quot;</span>
                                                                            <span class="colons">:&nbsp;</span>
                                                                            <span class="api_detail_text_1">1</span>
                                                                            <span class="colons">,</span>
                                                                        </p>
                                                                        <p class="main-p">
                                                                            <span>&nbsp; &nbsp; &nbsp; &nbsp;
                                                                                &nbsp;</span>
                                                                            <span
                                                                                class="api_detail_text">&quot;message&quot;</span>
                                                                            <span class="colons">:&nbsp;</span>
                                                                            <span
                                                                                class="api_detail_text_1">&quot;Success&quot;</span>
                                                                            <span class="colons">,</span>
                                                                        </p>
                                                                        <p class="main-p">
                                                                            <span>&nbsp; &nbsp; &nbsp; &nbsp;
                                                                                &nbsp;</span>
                                                                            <span
                                                                                class="api_detail_text">&quot;payload&quot;</span>
                                                                            <span class="kurly_braces">:&nbsp;[</span>
                                                                        </p>
                                                                        <div class="main_view_1">
                                                                            <p class="main-p">
                                                                                <span>&nbsp; &nbsp; &nbsp; &nbsp;
                                                                                    &nbsp;</span>
                                                                                <span class="kurly_braces">&nbsp;
                                                                                    {</span>
                                                                            </p>
                                                                            <p class="main-p">
                                                                                <span>&nbsp; &nbsp; &nbsp; &nbsp;
                                                                                    &nbsp;</span>
                                                                                <span
                                                                                    class="api_detail_text">&nbsp;&nbsp;&nbsp;&nbsp;&quot;shipment_no&quot;</span>
                                                                                <span class="colons">:&nbsp;</span>
                                                                                <span
                                                                                    class="api_detail_text_1">111001985</span>
                                                                                <span class="colons">,</span>
                                                                            </p>
                                                                            <p class="main-p">
                                                                                <span>&nbsp; &nbsp; &nbsp; &nbsp;
                                                                                    &nbsp;</span>
                                                                                <span
                                                                                    class="api_detail_text">&nbsp;&nbsp;&nbsp;&nbsp;&quot;booking_date&quot;</span>
                                                                                <span class="colons">:&nbsp;</span>
                                                                                <span
                                                                                    class="api_detail_text_1">&quot;2024-09-18
                                                                                    17:59:37&quot;</span>
                                                                                <span class="colons">,</span>
                                                                            </p>
                                                                            <p class="main-p">
                                                                                <span>&nbsp; &nbsp; &nbsp; &nbsp;
                                                                                    &nbsp;</span>
                                                                                <span
                                                                                    class="api_detail_text">&nbsp;&nbsp;&nbsp;&nbsp;&quot;customer_account&quot;</span>
                                                                                <span class="colons">:&nbsp;</span>
                                                                                <span
                                                                                    class="api_detail_text_1">1000001</span>
                                                                                <span class="colons">,</span>
                                                                            </p>
                                                                            <p class="main-p">
                                                                                <span>&nbsp; &nbsp; &nbsp; &nbsp;
                                                                                    &nbsp;</span>
                                                                                <span
                                                                                    class="api_detail_text">&nbsp;&nbsp;&nbsp;&nbsp;&quot;customer_name&quot;</span>
                                                                                <span class="colons">:&nbsp;</span>
                                                                                <span class="api_detail_text_1">&quot;demo
                                                                                    Co&quot;</span>
                                                                                <span class="colons">,</span>
                                                                            </p>
                                                                            <p class="main-p">
                                                                                <span>&nbsp; &nbsp; &nbsp; &nbsp;
                                                                                    &nbsp;</span>
                                                                                <span
                                                                                    class="api_detail_text">&nbsp;&nbsp;&nbsp;&nbsp;&quot;pickup_address&quot;</span>
                                                                                <span class="colons">:&nbsp;</span>
                                                                                <span
                                                                                    class="api_detail_text_1">&quot;Cillum
                                                                                    esse dignissimos incididunt
                                                                                    dolore&quot;</span>
                                                                                <span class="colons">,</span>
                                                                            </p>
                                                                            <p class="main-p">
                                                                                <span>&nbsp; &nbsp; &nbsp; &nbsp;
                                                                                    &nbsp;</span>
                                                                                <span
                                                                                    class="api_detail_text">&nbsp;&nbsp;&nbsp;&nbsp;&quot;pickup_phone&quot;</span>
                                                                                <span class="colons">:&nbsp;</span>
                                                                                <span
                                                                                    class="api_detail_text_1">&quot;00000000000000&quot;</span>
                                                                                <span class="colons">,</span>
                                                                            </p>
                                                                            <p class="main-p">
                                                                                <span>&nbsp; &nbsp; &nbsp; &nbsp;
                                                                                    &nbsp;</span>
                                                                                <span
                                                                                    class="api_detail_text">&nbsp;&nbsp;&nbsp;&nbsp;&quot;consignee_name&quot;</span>
                                                                                <span class="colons">:&nbsp;</span>
                                                                                <span
                                                                                    class="api_detail_text_1">&quot;ali&quot;</span>
                                                                                <span class="colons">,</span>
                                                                            </p>
                                                                            <p class="main-p">
                                                                                <span>&nbsp; &nbsp; &nbsp; &nbsp;
                                                                                    &nbsp;</span>
                                                                                <span
                                                                                    class="api_detail_text">&nbsp;&nbsp;&nbsp;&nbsp;&quot;consignee_phone&quot;</span>
                                                                                <span class="colons">:&nbsp;</span>
                                                                                <span
                                                                                    class="api_detail_text_1">&quot;32323233232&quot;</span>
                                                                                <span class="colons">,</span>
                                                                            </p>
                                                                            <p class="main-p">
                                                                                <span>&nbsp; &nbsp; &nbsp; &nbsp;
                                                                                    &nbsp;</span>
                                                                                <span
                                                                                    class="api_detail_text">&nbsp;&nbsp;&nbsp;&nbsp;&quot;consignee_address&quot;</span>
                                                                                <span class="colons">:&nbsp;</span>
                                                                                <span class="api_detail_text_1">&quot;house
                                                                                    #a692&quot;</span>
                                                                                <span class="colons">,</span>
                                                                            </p>
                                                                            <p class="main-p">
                                                                                <span>&nbsp; &nbsp; &nbsp; &nbsp;
                                                                                    &nbsp;</span>
                                                                                <span
                                                                                    class="api_detail_text">&nbsp;&nbsp;&nbsp;&nbsp;&quot;origin_city&quot;</span>
                                                                                <span class="colons">:&nbsp;</span>
                                                                                <span
                                                                                    class="api_detail_text_1">&quot;Karachi&quot;</span>
                                                                                <span class="colons">,</span>
                                                                            </p>
                                                                            <p class="main-p">
                                                                                <span>&nbsp; &nbsp; &nbsp; &nbsp;
                                                                                    &nbsp;</span>
                                                                                <span
                                                                                    class="api_detail_text">&nbsp;&nbsp;&nbsp;&nbsp;&quot;destination_city&quot;</span>
                                                                                <span class="colons">:&nbsp;</span>
                                                                                <span
                                                                                    class="api_detail_text_1">&quot;Makkah&quot;</span>
                                                                                <span class="colons">,</span>
                                                                            </p>
                                                                            <p class="main-p">
                                                                                <span>&nbsp; &nbsp; &nbsp; &nbsp;
                                                                                    &nbsp;</span>
                                                                                <span
                                                                                    class="api_detail_text">&nbsp;&nbsp;&nbsp;&nbsp;&quot;service&quot;</span>
                                                                                <span class="colons">:&nbsp;</span>
                                                                                <span
                                                                                    class="api_detail_text_1">&quot;GCC&quot;</span>
                                                                                <span class="colons">,</span>
                                                                            </p>
                                                                            <p class="main-p">
                                                                                <span>&nbsp; &nbsp; &nbsp; &nbsp;
                                                                                    &nbsp;</span>
                                                                                <span
                                                                                    class="api_detail_text">&nbsp;&nbsp;&nbsp;&nbsp;&quot;peices&quot;</span>
                                                                                <span class="colons">:&nbsp;</span>
                                                                                <span class="api_detail_text_1">20</span>
                                                                                <span class="colons">,</span>
                                                                            </p>
                                                                            <p class="main-p">
                                                                                <span>&nbsp; &nbsp; &nbsp; &nbsp;
                                                                                    &nbsp;</span>
                                                                                <span
                                                                                    class="api_detail_text">&nbsp;&nbsp;&nbsp;&nbsp;&quot;weight&quot;</span>
                                                                                <span class="colons">:&nbsp;</span>
                                                                                <span class="api_detail_text_1">1</span>
                                                                                <span class="colons">,</span>
                                                                            </p>
                                                                            <p class="main-p">
                                                                                <span>&nbsp; &nbsp; &nbsp; &nbsp;
                                                                                    &nbsp;</span>
                                                                                <span
                                                                                    class="api_detail_text">&nbsp;&nbsp;&nbsp;&nbsp;&quot;fragile&quot;</span>
                                                                                <span class="colons">:&nbsp;</span>
                                                                                <span
                                                                                    class="api_detail_text_1">&quot;Yes&quot;</span>
                                                                                <span class="colons">,</span>
                                                                            </p>
                                                                            <p class="main-p">
                                                                                <span>&nbsp; &nbsp; &nbsp; &nbsp;
                                                                                    &nbsp;</span>
                                                                                <span
                                                                                    class="api_detail_text">&nbsp;&nbsp;&nbsp;&nbsp;&quot;insurance&quot;</span>
                                                                                <span class="colons">:&nbsp;</span>
                                                                                <span
                                                                                    class="api_detail_text_1">&quot;Yes&quot;</span>
                                                                                <span class="colons">,</span>
                                                                            </p>
                                                                            <p class="main-p">
                                                                                <span>&nbsp; &nbsp; &nbsp; &nbsp;
                                                                                    &nbsp;</span>
                                                                                <span
                                                                                    class="api_detail_text">&nbsp;&nbsp;&nbsp;&nbsp;&quot;shipment_referance&quot;</span>
                                                                                <span class="colons">:&nbsp;</span>
                                                                                <span class="api_detail_text_1">1290</span>
                                                                                <span class="colons">,</span>
                                                                            </p>
                                                                            <p class="main-p">
                                                                                <span>&nbsp; &nbsp; &nbsp; &nbsp;
                                                                                    &nbsp;</span>
                                                                                <span
                                                                                    class="api_detail_text">&nbsp;&nbsp;&nbsp;&nbsp;&quot;shipper_comment&quot;</span>
                                                                                <span class="colons">:&nbsp;</span>
                                                                                <span class="api_detail_text_1">&quot;No
                                                                                    comment&quot;</span>
                                                                                <span class="colons">,</span>
                                                                            </p>
                                                                            <p class="main-p">
                                                                                <span>&nbsp; &nbsp; &nbsp; &nbsp;
                                                                                    &nbsp;</span>
                                                                                <span
                                                                                    class="api_detail_text">&nbsp;&nbsp;&nbsp;&nbsp;&quot;tracking_info&quot;</span>
                                                                                <span class="colons">:&nbsp;</span>
                                                                                <span class="api_detail_text_1">[</span>
                                                                            </p>
                                                                            <p class="main-p">
                                                                                <span
                                                                                    class="kurly_braces">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{</span>
                                                                            </p>
                                                                            <p class="main-p">
                                                                                <span>&nbsp; &nbsp; &nbsp; &nbsp;
                                                                                    &nbsp;</span>
                                                                                <span
                                                                                    class="api_detail_text">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&quot;created_datetime&quot;</span>
                                                                                <span class="colons">:&nbsp;</span>
                                                                                <span
                                                                                    class="api_detail_text_1">&quot;2024-09-18
                                                                                    17:59:37&quot;</span>
                                                                                <span class="colons">,</span>
                                                                            </p>
                                                                            <p class="main-p">
                                                                                <span>&nbsp; &nbsp; &nbsp; &nbsp;
                                                                                    &nbsp;</span>
                                                                                <span
                                                                                    class="api_detail_text">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&quot;status_name&quot;</span>
                                                                                <span class="colons">:&nbsp;</span>
                                                                                <span
                                                                                    class="api_detail_text_1">&quot;Booked&quot;</span>
                                                                                <span class="colons">,</span>
                                                                            </p>
                                                                            <p class="main-p">
                                                                                <span>&nbsp; &nbsp; &nbsp; &nbsp;
                                                                                    &nbsp;</span>
                                                                                <span
                                                                                    class="api_detail_text">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&quot;status_message&quot;</span>
                                                                                <span class="colons">:&nbsp;</span>
                                                                                <span
                                                                                    class="api_detail_text_1">&quot;Shipment
                                                                                    Is Booked&quot;</span>
                                                                            </p>
                                                                            <p class="main-p">
                                                                                <span
                                                                                    class="kurly_braces">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                                    }</span>
                                                                            </p>
                                                                        </div>
                                                                        <p class="main-p">
                                                                            <span class="kurly_braces">&nbsp; ]</span>
                                                                        </p>
                                                                        <p class="main-p">
                                                                            <span class="kurly_braces">]</span>
                                                                        </p>
                                                                    </div>

                                                                    <div class="api-box">
                                                                        <h5 class="mb-3">
                                                                            <b>Response with Errors</b>
                                                                        </h5>
                                                                        <div class="view-data mb-5">
                                                                            <p class="main-p">
                                                                                <span class="kurly_braces">&nbsp;
                                                                                    {</span>
                                                                            </p>
                                                                            <p class="main-p">
                                                                                <span>&nbsp; &nbsp; &nbsp; &nbsp;
                                                                                    &nbsp;</span>
                                                                                <span
                                                                                    class="api_detail_text">&quot;status&quot;</span>
                                                                                <span class="colons">:&nbsp;</span>
                                                                                <span
                                                                                    class="api_detail_text_1">&quot;0&quot;</span>
                                                                                <span class="colons">,</span>
                                                                            </p>
                                                                            <p class="main-p">
                                                                                <span>&nbsp; &nbsp; &nbsp; &nbsp;
                                                                                    &nbsp;</span>
                                                                                <span
                                                                                    class="api_detail_text">&quot;Message&quot;</span>
                                                                                <span class="colons">:&nbsp;</span>
                                                                                <span
                                                                                    class="api_detail_text_1">&quot;Error&quot;</span>
                                                                                <span class="colons">,</span>
                                                                            </p>
                                                                            <p class="main-p">
                                                                                <span>&nbsp; &nbsp; &nbsp; &nbsp;
                                                                                    &nbsp;</span>
                                                                                <span
                                                                                    class="api_detail_text">&quot;payload&quot;</span>
                                                                                <span class="colons">:&nbsp;</span>
                                                                                <span
                                                                                    class="api_detail_text_1">&quot;Invalid
                                                                                    consignment no&quot;</span>
                                                                            </p>
                                                                            <p class="main-p">
                                                                                <span class="kurly_braces">&nbsp;
                                                                                    }</span>
                                                                            </p>
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>
            var storeUrl = "{{ route('admin.updateProfile') }}";
            var returnUrl = "{{ route('admin.company_settings') }}";
        </script>
    @section('scripts')
        <script src="{{ asset('assets/js/auth/profile.js') }}"></script>
    @endsection
@endsection
