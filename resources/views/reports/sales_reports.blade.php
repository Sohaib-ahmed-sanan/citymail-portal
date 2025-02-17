@extends('layout.main')
@section('content')
    {{-- filter modal --}}
    <div class="modal fade" id="filter_modal" role="dialog" aria-labelledby="filterModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered w-800" role="document">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <h6 class="modal-title" id="modal-title-default">Apply Filter</h6>
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
                    <div class="form-row">
                        <div class="col-md-12">
                            <form action="#" data-parsley-validate id="report_form" method="post">
                                 <div class="form-row flex-column justify-content-center align-items-center">
                                    <div class="col-md-10 mb-3 px-3">
                                        @if (is_ops())
                                            <select required
                                                class="form-control form-select customer_filter form-control-lg input_field "
                                                id="customer_id" multiple data-toggle="select2" name="customer_id[]"
                                                size="1" label="Select Customer" data-placeholder="Select Customer"
                                                data-allow-clear="1">
                                                @foreach ($customers as $customer)
                                                    <option value="{{ $customer->id }}">
                                                        {{ $customer->business_name }}
                                                        ({{ $customer->acno }})
                                                    </option>
                                                @endforeach
                                            </select>
                                        @else
                                            <input type="hidden" id="customer_id" name="customer_id[]" value="{{ session('acno') }}">
                                        @endif
                                        @if (is_portal())
                                            @if (count($sub_acc) > 0)
                                                <select required
                                                    class="form-control form-select sub_acc_id form-control-lg input_field "
                                                    id="sub_acc_id" multiple data-toggle="select2" name="sub_acc_id[]"
                                                    size="1" label="Select Sub Account"
                                                    data-placeholder="Select Sub Account" data-allow-clear="1">
                                                    @foreach ($sub_acc as $acc)
                                                        <option value="{{ $acc->id }}">
                                                            {{ $acc->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            @endif
                                        @endif
                                    </div>
                                    <div class="col-md-10 mb-3 px-3">
                                        <select class=" form-control form-select country_id form-control-lg input_field "
                                            id="destination_id" multiple="multiple" data-toggle="select2" name="city_id[]"
                                            size="1" label="Select Destination" data-placeholder="Select Destination"
                                            data-allow-clear="1">
                                            @foreach ($cities as $city)
                                                <option value="{{ $city->id }}"> {{ $city->city }} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-10 mb-3 px-3">
                                        <select class=" form-control form-select country_id form-control-lg input_field "
                                            id="status_id" data-toggle="select2" multiple="multiple" name="status_id[]"
                                            size="1" label="Select Delivery Status"
                                            data-placeholder="Select Delivery Status" data-allow-clear="1">
                                            @foreach (session('status') as $status)
                                                @if (in_array($status->id, [1, 2, 4, 14, 21, 24]))
                                                    <option value="{{ $status->id }}">{{ $status->name }}</option>
                                                @endif
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
        <div class="app-content--inner order-detail-wrapper">
            <div class="pb-4 text-center text-xl-left">
                <div class="row align-items-center">
                    <div class="col-xl-6">
                        <div>
                            <h5 class="title-text mb-1">{{ $title }}</h5>
                            <p class="sub-title-text mb-0">Please see list of {{ strtolower($title) }} below</p>
                        </div>
                    </div>
                    <div class="col-xl-6 d-flex align-items-center justify-content-start mt-xl-0 justify-content-xl-end">
                        <div class="mx-auto mx-xl-0  btn-wrapper" style="margin-right: 16px !important;">
                            <button class="btn btn-sm btn-custom" data-toggle="modal" data-target="#filter_modal"><svg
                                    class="w-20" data-toggle="tooltip" data-title="Filter" width="28" height="26" viewBox="0 0 28 26" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M24.7865 23.4066C24.17 23.4066 23.5543 23.4156 22.9379 23.4018C22.735 23.3969 22.6507 23.4692 22.5712 23.657C21.8998 25.2435 20.3074 26.1701 18.6179 25.9742C16.9912 25.7848 15.635 24.4876 15.3232 22.8222C14.9605 20.8838 16.0948 18.9696 17.9601 18.3739C19.7919 17.7887 21.7933 18.7185 22.5616 20.5278C22.6515 20.7383 22.7462 20.809 22.9705 20.8073C24.2225 20.7952 25.4745 20.796 26.7273 20.8041C27.3804 20.8082 27.8791 21.2649 27.9809 21.9217C28.0748 22.5256 27.7137 23.1384 27.1322 23.3262C26.9556 23.3831 26.7615 23.4009 26.5754 23.4034C25.9788 23.4123 25.3822 23.4066 24.7865 23.4066Z"
                                        fill="#525252"></path>
                                    <path
                                        d="M3.15064 11.7029C3.77665 11.7029 4.40345 11.6948 5.02946 11.707C5.23627 11.711 5.33729 11.6493 5.42319 11.4444C6.07784 9.8904 7.687 8.92562 9.28502 9.11175C11.0055 9.31169 12.3546 10.5707 12.6712 12.2718C13.0307 14.2046 11.9036 16.1285 10.0677 16.7153C8.2088 17.3095 6.21545 16.3975 5.43513 14.5753C5.33649 14.3453 5.22513 14.2859 4.99684 14.2884C3.75438 14.2989 2.51191 14.2989 1.26944 14.29C0.703891 14.2859 0.264017 13.96 0.078681 13.4431C-0.101882 12.94 0.0341367 12.3832 0.427081 12.0272C0.676051 11.8021 0.969566 11.7005 1.30206 11.7029C1.91772 11.7053 2.53418 11.7029 3.15064 11.7029Z"
                                        fill="#525252"></path>
                                    <path
                                        d="M24.2002 0.000192582C26.3193 0.0213249 28.008 1.75824 28 3.90724C27.9913 6.06193 26.2477 7.82241 24.1445 7.79884C22.0422 7.77527 20.3464 6.00991 20.3686 3.8666C20.3909 1.69972 22.0963 -0.0209398 24.2002 0.000192582Z"
                                        fill="#525252"></path>
                                    <path
                                        d="M8.89363 5.19485C6.36972 5.19485 3.84661 5.1981 1.3227 5.19323C0.439768 5.1916 -0.162375 4.43734 0.039665 3.58798C0.159775 3.0808 0.485903 2.76057 0.981458 2.6354C1.12384 2.59964 1.27656 2.59151 1.42451 2.59151C6.41188 2.58907 11.4 2.58907 16.3874 2.59313C16.5831 2.59313 16.7875 2.6167 16.972 2.67929C17.54 2.87273 17.8892 3.47094 17.8065 4.06752C17.719 4.69662 17.2099 5.17616 16.5839 5.18997C15.9778 5.20379 15.3716 5.19404 14.7655 5.19404C12.808 5.19485 10.8512 5.19485 8.89363 5.19485Z"
                                        fill="#525252"></path>
                                    <path
                                        d="M6.36966 23.407C4.7096 23.407 3.04953 23.4094 1.39025 23.4062C0.650501 23.4045 0.136652 22.9892 0.0213138 22.313C-0.104365 21.5766 0.420621 20.8768 1.15162 20.8069C1.20094 20.802 1.25105 20.802 1.30037 20.802C4.67937 20.802 8.05916 20.7996 11.4382 20.8036C12.1501 20.8044 12.6926 21.3441 12.7268 22.0553C12.7594 22.7194 12.267 23.2989 11.5869 23.3907C11.4501 23.4094 11.3093 23.4062 11.1701 23.4062C9.56969 23.407 7.96928 23.407 6.36966 23.407Z"
                                        fill="#525252"></path>
                                    <path
                                        d="M21.6346 14.293C19.9546 14.293 18.2754 14.2987 16.5955 14.2906C15.7046 14.2865 15.1168 13.5428 15.3093 12.6894C15.4302 12.1538 15.8923 11.7498 16.43 11.7092C16.4992 11.7043 16.5692 11.7027 16.6384 11.7027C19.9681 11.7027 23.2978 11.7011 26.6267 11.7035C27.345 11.7043 27.8445 12.0993 27.9678 12.7479C28.1165 13.5306 27.5725 14.2589 26.7921 14.2841C26.1073 14.3068 25.4208 14.2922 24.7352 14.2922C23.7019 14.2938 22.6678 14.293 21.6346 14.293Z"
                                        fill="#525252"></path>
                                </svg></button>
                        </div>
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
            <div class="catalogue-wrapper">
                <div class="row">
                    <div class="col-12">
                        <div class="card card-box mb-5">
                            <div class="card-header">
                                <div class="card-header--title">
                                    <b>{{ $title }}:</b>
                                </div>
                            </div>
                            <table id="example" class="example2 display nowrap table table-hover" width="100%">
                                <thead class="thead">
                                    <tr>
                                        <th>SNO</th>
                                        <th>CONSIGNMENT</th>
                                        <th>DATE</th>
                                        <th>CONSIGNEE</th>
                                        <th>ORIGIN</th>
                                        <th>DESTINATION</th>
                                        <th>TPL CONSIGNMENT</th>
                                        <th>WEIGHT</th>
                                        <th>PEICES</th>
                                        <th>SST</th>
                                        <th>GST</th>
                                        <th>BAC</th>
                                        <th>HANDLING CHARGES</th>
                                        <th>SERVICE CHARGES</th>
                                        <th>TOTAL CHARGES</th>
                                        <th>COD</th>
                                        <th>TPL COLLECTED</th>
                                        <th>INVOICE NO</th>
                                        <th>INVOICE STATUS</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                   
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
    <script>
        var listRoute = "{{ route('ops.sales_report') }}";
        var type = 'sales_report';
    </script>

@section('scripts')
    <script src="{{ asset('assets/js/reports/sales.js') }}"></script>
@endsection
@endsection
