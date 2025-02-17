@extends('layout.main')
@section('content')
    <div class="app-content">
        {{-- ======================= Add Modal ======================= --}}
        <div class="modal fade" id="add_modal" role="dialog" aria-labelledby="editsucessModal" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered w-800" role="document">
                <div class="modal-content">
                    <div class="modal-header border-0">
                        <h6 class="modal-title" id="modal-title-default">Add {{ $title }}</h6>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12 py-3">
                                <form id="add_edit_cityMapping" method="POST" enctype="multipart/form-data"
                                    data-parsley-validate>
                                    @csrf
                                    <div class="form-row">
                                        <div class="mb-3 col-md-6 mt-3">
                                            <label class="form-label" for="" id="">
                                                Select Country</label>
                                            <select required class=" form-control form-select country_id input_field "
                                                id="country_id" data-toggle="select2" name="country_id" size="1"
                                                label="Select Country" data-placeholder="Select Country"
                                                data-allow-clear="1">
                                                <option value="">Select Country</option>
                                                @foreach ($countries as $country)
                                                    <option data-attr="{{ $country->country_code }}"
                                                        value="{{ $country->id }}">
                                                        {{ $country->country_name }} </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3 col-md-6 mt-3">
                                            <label class="form-label" for="" id="">
                                                Select City</label>
                                            <select required class=" form-control form-select city_id input_field "
                                                id="city_id" data-toggle="select2" name="city_id" size="1"
                                                label="Select city" data-placeholder="Select city" data-allow-clear="1">
                                                <option value="">Select City</option>
                                            </select>
                                        </div>
                                        <div class="mb-3 col-md-6 mt-3">
                                            <label class="form-label" for="" id="">
                                                Select Courier</label>
                                            <select required class=" form-control form-select courier_id input_field "
                                                id="courier" data-toggle="select2" name="courier" size="1"
                                                label="Select courier" data-placeholder="Select courier"
                                                data-allow-clear="1">
                                                <option value="">Select Courier</option>
                                                @foreach ($couriers as $courier)
                                                    <option value="{{ $courier->id }}"> {{ $courier->courier_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3 col-md-6 mt-3">
                                            <label class="form-label" for="" id="">
                                                Select Courier City</label>
                                            <select required class=" form-control form-select courier_city input_field "
                                                id="city_courier" data-toggle="select2" name="city_courier" size="1"
                                                label="Select city" data-placeholder="Select courier city"
                                                data-allow-clear="1">
                                                <option value="">Select courier city</option>
                                            </select>
                                        </div>
                                    </div>
                                    <input type="hidden" id="add_url" value="{{ route('admin.add_edit_cityMapping') }}">
                                </form>
                            </div>
                            <div class="col-md-12 text-center mt-1">
                                <div class="d-flex justify-content-center w-100">
                                    <input type="hidden" value="startDate=&amp;endDate=" id="selected_filter_date">
                                    <button type="button" class="btn btn-secondary-orio mr-3 my-3" data-dismiss="modal"
                                        aria-label="Close">Close</button>
                                    <a href="javascript:;" class="btn btn-orio my-3" data-form-id="add_edit_cityMapping"
                                        id="add-btn">Add {{ $title }}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="app-content--inner">
            <div class="pb-4 text-center text-xl-left">
                <div class="row align-items-center">
                    <div class="col-xl-6">
                        <div>
                            <ol class="d-inline-block breadcrumb text-uppercase font-size-xs p-0">
                                <li class="d-inline-block breadcrumb-item"><a
                                        href="{{ Route('admin.index') }}">Dashboard</a></li>
                                <li class="d-inline-block breadcrumb-item"><a href="javascript::void(0)">Admin</a>
                                </li>
                                <li class="d-inline-block breadcrumb-item active" aria-current="page">{{ $title }}
                                </li>
                            </ol>
                            <h5 class="display-4 mt-1 mb-2 font-weight-bold">{{ $title }}</h5>
                            <p class="text-black-50 mb-0">Please see list of {{ strtolower($title) }} below</p>
                        </div>
                    </div>
                    <div class="col-xl-6 d-flex align-items-center justify-content-start mt-xl-0 justify-content-xl-end">
                        <div class="mx-auto mx-xl-0 mt-3 btn-wrapper">
                            <button class="btn btn-secondary-orio" data-toggle="modal" data-target="#add_modal">Add
                                {{ $title }}</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card card-box mb-3">
                <div class="card-header">
                    <div class="card-header--title">
                        <small>{{ $title }}</small>
                        <b>List of {{ $title }}</b>
                    </div>
                    {{--==================Courier Filter================--}}
                    {{-- <div class="mb-3 col-md-6 mt-3">
                        <label class="form-label" for="" id="">
                            Select Courier</label>
                            <select required class=" form-control form-select courier_id input_field " id="courier"
                            data-toggle="select2" name="courier" size="1" label="Select courier"
                            data-placeholder="Select courier" data-allow-clear="1">
                            <option value="">Select Courier</option>
                            @foreach ($couriers as $courier)
                            <option value="{{ $courier->id }}"> {{ $courier->courier_name }} </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3 col-md-6 mt-3">
                        <label class="form-label" for="" id="">
                            Select Courier City</label>
                        <select required class=" form-control form-select courier_city input_field " id="city_courier"
                            data-toggle="select2" name="city_courier" size="1" label="Select city"
                            data-placeholder="Select courier city" data-allow-clear="1">
                            <option value="">Select courier city</option>
                        </select>
                    </div>
                </div> --}}
                {{--==================Courier Filter================--}}
                <div class="card-header--actions">
                    <div class="mx-auto mx-xl-0">
                        <div class="d-inline-block btn-group btn btn-primary coursor-pointer">
                            <div id="datepicker">
                                <i class="fa fa-calendar"></i>
                                <span class="date_title"></span>
                                <span class="date_range"></span>
                                <i class="fa fa-caret-down"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <table id="example" class="example2 display nowrap table table-hover" width="100%">
                <thead class="thead">
                    <tr>
                        <th>SNO</th>
                        <th>COURIER</th>
                        <th>CITY ID</th>
                        <th>CITY NAME</th>
                        <th>COURIER CITY CODE</th>
                        <th>ACTIVE</th>
                    </tr>
                </thead>
            </table>
        </div>
        <script>
            var listRoute = "{{ Route('admin.cityMapping') }}";
        </script>
    @section('scripts')
        <script src="{{ asset('assets/js/admin/city-mapping.js') }}"></script>
    @endsection

@endsection
