@extends('layout.main')
@section('content')
    <div class="app-content">
        <div class="app-content--inner">
            <div class="pb-4 text-center text-xl-left">
                <div class="row align-items-center">
                    <div class="col-xl-6">
                       <div>
                            <h5 class="title-text mb-1">{{ $title }}</h5>
                             <p class="sub-title-text mb-0">Please see list of {{ strtolower($title) }} below</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card card-box mb-3">
                <div class="card-header">
                    <div class="card-header--title">
                        <b>Here you can create &amp; manage Automation Rules</b>
                    </div>
                </div>
                <div class="card-body">
                    <form class="needs-validation" method="" novalidate="" id="">
                        <input type="hidden" value="1" id="rulescount">
                        <div class="row justify-content-center">
                            <div class="col-md-12" id="rules_div">
                                <div class="row">
                                    <div class="col fl-0">
                                        <label>Rule Title</label>
                                    </div>
                                    <div class="col mb-3">
                                        <input type="text" class="form-control" id="rule_title"
                                            placeholder="Enter Rule Title">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col fl-0">
                                        <label>If Trigger</label>
                                    </div>
                                    <div class="col mb-3">
                                        <select id="trigger_status" size="1" class="form-control"
                                            data-toggle="select2" placeholder="Order Status is set to.."
                                            data-allow-clear="1" data-select2-id="trigger_status" tabindex="-1"
                                            aria-hidden="true">
                                            <option value="4">Arrival</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row" id="rule_value_1" style="">
                                    <div class="col fl-0">
                                        <label>Condition</label>
                                    </div>
                                    <div class="col-md-3 mb-3" id="rule_html_1_1">
                                        <select select onchange="rule_select_condition(1);" id="rule_select_condition_1"
                                            class="form-control field_1_1 maindropdown activedropdown is-valid select2-hidden-accessible"
                                            selectcondition="1" data-toggle="select2" placeholder="Select Condition"
                                            data-allow-clear="1" data-select2-id="rule_select_condition_1" tabindex="-1"
                                            aria-hidden="true" data-parsley-id="3">
                                            <option value="" selected>Select Condition</option>
                                            <option value="Weight">Weight</option>
                                            <option value="Payment method">Payment method</option>
                                            @if (session('company_type') == 'I')
                                                <option value="Countries">Country List</option>
                                            @elseif(session('company_type') == 'D')
                                                <option value="Cities">City List</option>
                                            @endif
                                            <option value="Order value">Order value</option>
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-md-3 mb-3" id="rule_html_1_2"> </div>
                                    <div class="col-md-3 mb-3" id="rule_html_1_3"> </div>
                                    <div class="col-md-2 mb-3" id="rule_html_1_4"> </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="row" id="rule_value_122222">
                                    <div class="col fl-0">
                                        <label>Then</label>
                                    </div>
                                    {{-- <div class="col-3 mb-6">
                                        <select id="rule_generatecn_1" class="form-control select2-hidden-accessible"
                                            data-toggle="select2" placeholder="Select Condition" data-allow-clear="1"
                                            data-select2-id="rule_generatecn_1" tabindex="-1" aria-hidden="true">
                                            <option value="with 3PL" data-select2-id="5">with 3PL</option>
                                        </select>
                                    </div> --}}
                                    <div class="col-3 mb-3">
                                        <select required
                                            class="form-control form-select courier_acc_id form-control-lg input_field "
                                            id="courier_acc_id" onchange="" data-toggle="select2" name="courier_acc_id"
                                            size="1" label="Select Account" data-service-id="service_id"
                                            data-placeholder="Select Courier" data-allow-clear="1">
                                            <option value="">Select Courier Account</option>
                                            @foreach ($accounts as $account)
                                                <option value="{{ $account->id }}"
                                                    data-courier-id="{{ $account->courier_id }}">
                                                    {{ $account->account_title }} (
                                                    {{ $account->courier_name }} ) </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-3 mb-3 w-100">
                                        <select id="service_id" class="form-control" data-placeholder="Choose Service Code"
                                            data-toggle="select2" data-allow-clear="1" data-service-code=""
                                            data-select2-id="service_code" tabindex="-1" aria-hidden="true">
                                        </select>
                                    </div>
                                    <div class="col-3 mb-3">
                                        <select required class="form-control customer_acno form-control-lg"
                                            id="customer_acno" data-toggle="select2" name="customer_acno" size="1"
                                            label="Select Customers" data-type="{{ session('company_type') }}"
                                            data-pickup-id="pickup_id" data-placeholder="Select Customer"
                                            data-allow-clear="1">
                                            <option value="">Select Customer</option>
                                            @foreach ($customers as $customer)
                                                <option value="{{ $customer->acno }}">
                                                    {{ $customer->business_name }} ({{ $customer->acno }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @if (session('company_type') == 'D')
                                        <div class="co l-3 mb-3">
                                            <select class="form-control" size="1" name="pickup_id" id="pickup_id"
                                                data-toggle="select2" data-placeholder="Select Pickup"
                                                data-allow-clear="1" data-pickup-id="pickup_id"
                                                data-select2-id="pickup_id" tabindex="-1" aria-hidden="true">
                                            </select>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="row">
                        <div class="col-md-12 my-3 text-center">
                            <div class="form-group">
                                <a href="javascript: void(0);" class="btn btn-orio" id="add_rule"
                                    onclick="addRule()">Add Rule</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="regions_list" class="d-none">
                @if (session('company_type') == 'I')
                    @foreach (collect($countries)->sortBy('country_name') as $country)
                        <option value="{{ $country->id }}">{{ $country->country_name }}</option>
                    @endforeach
                @elseif(session('company_type') == 'D')
                    @foreach (collect($cities)->sortBy('city') as $city)
                        <option value="{{ $city->id }}">{{ $city->city }}</option>
                    @endforeach
                @endif
            </div>
            <!--================== Rules Show  ===================-->
            @if (isset($rules) && count($rules) > 0)
                <div class="card card-box mb-3">
                    <div class="card-header">
                        <div class="card-header--title"> <small>Rules List</small> <b>Here is your rules list</b> </div>
                    </div>
                    @foreach ($rules as $rule)
                        @php $i = $loop->iteration ; @endphp
                        <div class="card-body" id="{{ $rule->id }}">
                            <div class="row justify-content-center align-items-center">
                                <div class="col-md-1">
                                    <div class="num-bx" id="rule-">
                                        Rule-{{ $loop->iteration }}
                                    </div>
                                </div>
                                <div class="col-md-11">
                                    <div class="row">
                                        <div class="col fl-0">
                                            <label>Rule Title</label>
                                        </div>
                                        <div class="col mb-3">
                                            <input type="text" class="form-control"
                                                id="rule_title_{{ $rule->id }}" placeholder="Rule Title"
                                                value="{{ $rule->title }}">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col fl-0">
                                            <label>If Trigger</label>
                                        </div>
                                        <div class="col mb-3">
                                            <select id="rule_status_{{ $i }}" disabled="disabled"
                                                class="form-control" data-toggle="select2"
                                                placeholder="Order Status is set to.." data-allow-clear="1">
                                                <option value="4">Arrival</option>
                                            </select>
                                        </div>
                                    </div>
                                    @if ($rule->weight_type != '')
                                        <div class="row" id="rule_value_{{ $i }}">
                                            <div class="col fl-0">
                                                <label>Condition</label>
                                            </div>
                                            <div class="col mb-3">
                                                <select class="form-control" selectcondition="1" disabled="disabled"
                                                    data-toggle="select2" placeholder="Select Weight"
                                                    data-allow-clear="1">
                                                    <option value="Weight" selected>Weight</option>
                                                </select>
                                            </div>
                                            <div class="col mb-3">
                                                <select id="" class="form-control" disabled placeholder="Weight"
                                                    data-allow-clear="1">
                                                    <option value="="
                                                        {{ $rule->weight_type == '=' ? 'selected' : '' }}>Equal to</option>
                                                    <option value="<"
                                                        {{ $rule->weight_type == '<' ? 'selected' : '' }}>Less than
                                                    </option>
                                                    <option value=">"
                                                        {{ $rule->weight_type == '>' ? 'selected' : '' }}>Greater than
                                                    </option>
                                                    <option value="<="
                                                        {{ $rule->weight_type == '<=' ? 'selected' : '' }}>Less than
                                                        or equal to</option>
                                                    <option value=">="
                                                        {{ $rule->weight_type == '>=' ? 'selected' : '' }}>Greater
                                                        than or equal to</option>
                                                </select>
                                            </div>
                                            <div class="col mb-3" id="">
                                                <input type="number" min="0" class="form-control"
                                                    disabled="disabled" id="" placeholder="Enter weight in Kgs"
                                                    value="{{ $rule->weight_value }}" required>
                                            </div>
                                        </div>
                                    @endif

                                    @if ($rule->payment_method_id != '')
                                        <div class="row" id="rule_value_{{ $i }}">
                                            <div class="col fl-0">
                                                <label>Condition</label>
                                            </div>
                                            <div class="col mb-3" id="">
                                                <select class="form-control" selectcondition="1" disabled="disabled"
                                                    data-toggle="select2" placeholder="Select Payment method"
                                                    data-allow-clear="1">
                                                    <option value="Payment method">Payment method</option>
                                                </select>
                                            </div>
                                            @php
                                                $paymentMethods = [
                                                    1 => 'COD',
                                                    2 => 'CC',
                                                    3 => 'EasyPaisa',
                                                    4 => 'JazzCash',
                                                ];
                                                $payment_method =
                                                    $paymentMethods[$rule->payment_method_id] ??
                                                    $rule->payment_method_id;
                                            @endphp
                                            <div class="col mb-3" id="">
                                                <select id="" class="form-control" disabled="disabled"
                                                    placeholder="Weight" data-allow-clear="1" data-toggle="select2"
                                                    data-allow-clear="1">
                                                    <option value="{{ $rule->payment_method_id }}">
                                                        {{ $payment_method }}
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                    @endif

                                    @if ($rule->destination_city_id != '' && $rule->destination_city_id != '0')
                                        <div class="row" id="rule_value_{{ $i }}">
                                            <div class="col fl-0">
                                                <label>Condition</label>
                                            </div>
                                            <div class="col mb-3" id="">
                                                <select class="form-control" selectcondition="1" disabled="disabled"
                                                    data-toggle="select2" placeholder="Select Cities"
                                                    data-allow-clear="1">
                                                    <option value="Cities">Cities</option>
                                                </select>
                                            </div>
                                            <div class="col mb-3" id="">
                                                <select id="" class="form-control" disabled="disabled"
                                                    placeholder="Cities" data-allow-clear="1" data-toggle="select2"
                                                    data-allow-clear="1">
                                                    @foreach ($cities as $city)
                                                        <option
                                                            {{ $rule->destination_city_id == $city->id ? 'selected' : '' }}
                                                            value="{{ $city->id }}">{{ $city->city }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    @endif

                                    @if ($rule->destination_country != '' && $rule->destination_country != '0')
                                        <div class="row" id="rule_value_{{ $i }}">
                                            <div class="col fl-0">
                                                <label>Condition</label>
                                            </div>
                                            <div class="col mb-3" id="">
                                                <select class="form-control" selectcondition="1" disabled="disabled"
                                                    data-toggle="select2" placeholder="Select Countries"
                                                    data-allow-clear="1">
                                                    <option value="Countries">Countries</option>
                                                </select>
                                            </div>
                                            <div class="col mb-3" id="">
                                                <select id="" class="form-control" disabled="disabled"
                                                    placeholder="Countries" data-allow-clear="1" data-toggle="select2"
                                                    data-allow-clear="1">
                                                    @foreach (collect($countries)->sortBy('country_name') as $country)
                                                        <option
                                                            {{ $rule->destination_country == $country->id ? 'selected' : '' }}
                                                            value="{{ $country->id }}">{{ $country->country_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    @endif

                                    @if ($rule->order_value != '')
                                        <div class="row" id="rule_value_{{ $i }}">
                                            <div class="col fl-0">
                                                <label>Condition</label>
                                            </div>
                                            <div class="col mb-3" id="">
                                                <select class="form-control" selectcondition="1" disabled="disabled"
                                                    placeholder="Select Condition">
                                                    <option value="Order value">Order value</option>
                                                </select>
                                            </div>
                                            <div class="col mb-3">
                                                <select id="" class="form-control" disabled="disabled"
                                                    placeholder="Order value" data-toggle="select2" data-allow-clear="1">
                                                    <option value="="
                                                        {{ $rule->order_type === '=' ? 'selected' : '' }}>
                                                        Equal to</option>
                                                    <option value="<"
                                                        {{ $rule->order_type === '<' ? 'selected' : '' }}>
                                                        Less than</option>
                                                    <option value=">"
                                                        {{ $rule->order_type === '>' ? 'selected' : '' }}>
                                                        Greater than</option>
                                                    <option value="<="
                                                        {{ $rule->order_type === '<=' ? 'selected' : '' }}>
                                                        Less than or equal to</option>
                                                    <option value=">="
                                                        {{ $rule->order_type === '>=' ? 'selected' : '' }}>
                                                        Greater than or equal to</option>
                                                </select>
                                            </div>
                                            <div class="col mb-3" id="">
                                                <input type="text" min="0" class="form-control"
                                                    disabled="disabled" id="" placeholder="Date"
                                                    value="{{ $rule->order_value }}" required>
                                            </div>
                                        </div>
                                    @endif

                                    <div class="row">
                                        <div class="col fl-0">
                                            <label>Then</label>
                                        </div>
                                        {{-- <div class="col mb-3">
                                            <select disabled="disabled" class="form-control" data-allow-clear="1"
                                                data-toggle="select2" placeholder="Select Courier">
                                                <option value="with 3PL">with 3PL</option>
                                                <option value="with internal shipping">with internal shipping</option>
                                            </select>
                                        </div> --}}
                                        <div class="col mb-3">
                                            <select onchange="" id="courier_acc_id_{{ $rule->id }}"
                                                class="form-control courier_acc_id" data-toggle="select2"
                                                data-rule-id="{{ $rule->id }}"
                                                data-service-id="service_id_{{ $rule->id }}">
                                                @foreach ($accounts as $account)
                                                    <option value="{{ $account->id }}"
                                                        {{ $rule->account_id == $account->id ? 'selected' : '' }}
                                                        courier_id="{{ $account->courier_id }}">
                                                        {{ $account->account_title }} (
                                                        {{ $account->courier_name }} ) </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col mb-3">
                                            @php
                                                $common = app()->make(\App\Http\Controllers\commonController::class);
                                                $services = $common->get_courier_services($rule->account_id);
                                            @endphp
                                            <select id="service_id_{{ $rule->id }}" class="form-control"
                                                data-placeholder="Choose Service Code" data-toggle="select2"
                                                data-allow-clear="1" tabindex="-1" aria-hidden="true">
                                                @foreach (json_decode($services->getContent(), true) as $service)
                                                    <option value="{{ $service['service_code'] }}">
                                                        {{ $service['service_name'] }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col mb-3">
                                            <select required
                                                class=" form-control customer_acno form-select customer_id_2 form-control-lg input_field "
                                                id="customer_id_{{ $rule->id }}" data-toggle="select2"
                                                name="customer_acno" size="1"
                                                data-pickup-id="pickup_id_{{ $rule->id }}" label="Select Customers"
                                                data-placeholder="Select Customer" data-allow-clear="1">
                                                <option value=" " {{ $rule->customer_acno == '0' ? 'selected' : '' }}>All Customers</option>
                                                @foreach ($customers as $customer)
                                                    <option value="{{ $customer->acno }}"
                                                        {{ $rule->customer_acno == $customer->acno ? 'selected' : '' }}>
                                                        {{ $customer->business_name }} ({{ $customer->acno }})
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @if (session('company_type') == 'D')
                                            <div class="col mb-3">
                                                <select id="pickup_id_{{ $rule->id }}" class="form-control pickup_id"
                                                    size="1" data-toggle="select2" placeholder="Select Pickup"
                                                    data-allow-clear="1"
                                                    data-pickup-id="{{ $rule->pickup_location_id }}">
                                                    <option value="{{ $rule->pickup_location_id }}" selected>
                                                        {{ $rule->pickup_location_name }}</option>
                                                </select>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="row" id="rule_value_1">
                                        <div class="col fl-0">
                                            <label>Status</label>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <div class="col-md-8 mb-3">
                                                <div class="custom-control custom-switch my-3">
                                                    <input type="checkbox" class="custom-control-input"
                                                        data-rule-id="{{ $rule->id }}" id="rule_{{ $rule->id }}"
                                                        {{ isset($rule->active) && !empty($rule->active) && $rule->active == '1' ? 'checked' : '' }}>
                                                    <label class="custom-control-label"
                                                        for="rule_{{ $rule->id }}">Inactive/Active</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <div class="col-md-12 text-right">
                                    <button data-rule-id="{{ $rule->id }}" class="btn btn-orio updateRule "
                                        id='update_{{ $rule->id }}'>Update Rule</button>
                                    <button class="btn btn-orio ml-1" onclick="deleteRule({{ $rule->id }})">Delete
                                        Rule</button>
                                </div>
                            </div>
                        </div>
                        <hr>
                    @endforeach
                </div>
            @endif
            <!--================== Rules Show  ===================-->
            <script>
                var add_route = "{{ Route('admin.add_rule') }}"
                var update_route = "{{ Route('admin.update_rule') }}"
            </script>
        @section('scripts')
            <script src="{{ asset('assets/js/rules/rules.js') }}"></script>
        @endsection

    @endsection
