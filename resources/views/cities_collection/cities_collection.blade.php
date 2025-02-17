@extends('layout.main')
@section('content')
    <div class="app-content">
        {{-- Edit modal --}}
        <div class="modal fade" id="edit_modal" role="dialog" aria-labelledby="editsucessModal" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered w-800" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6 class="modal-title" id="modal-title-default">Edit {{ $title }}</h6>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div id="edit_form_append" class="p-0">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a href="javascript:;" class="btn btn-sm btn-orio" data-form-id="edit_sales_men_from"
                            id="updateBtn">Edit {{ $title }}</a>
                        <button type="button" class="btn btn-sm btn-secondary-orio" data-dismiss="modal"
                            aria-label="Close">Close</button>
                    </div>
                </div>
            </div>
        </div>
        {{-- Add modal --}}
        <div class="modal fade" id="add_modal" role="dialog" aria-labelledby="editsucessModal" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered w-800" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6 class="modal-title" id="modal-title-default">Add {{ $title }}</h6>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="py-0 my-0">
                            <form id="add_collection_form" method="POST" enctype="multipart/form-data"
                                data-parsley-validate>
                                @csrf
                                <div class="form-row">
                                    <div class="col-md-6">
                                        <label for="name">Collection name<span class="req">*</span></label>
                                        <input type="text" name="name" value="" class="form-control"
                                            id="name" label="Collection name" required placeholder="Collection name">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label" for="city_id" id="">Select Cities</label>
                                        <select required
                                            class=" form-control form-select city_id form-control-lg input_field "
                                            id="" multiple="multiple" data-toggle="select2" name="city_id[]" size="1"
                                            label="{{ $title }}" data-placeholder="Select city" data-allow-clear="1">
                                            <option value="">Select City</option>
                                            @foreach (session('cities') as $cities)
                                                <option value="{{ $cities->id }}">
                                                    {{ $cities->city }} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <input type="hidden" id="add_url" value="{{ route('admin.add_edit_collection') }}">
                            </form>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a href="javascript:;" class="btn btn-sm btn-orio"
                            id="add-btn">Add {{ $title }}</a>
                        <button type="button" class="btn btn-sm btn-secondary-orio" data-dismiss="modal"
                            aria-label="Close">Close</button>
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
                                <li class="d-inline-block breadcrumb-item"><a href="javascript::void(0)">Admin</a></li>
                                <li class="d-inline-block breadcrumb-item active" aria-current="page">{{ $title }}</li>
                            </ol>
                            <h5 class="display-4 mt-1 mb-2 font-weight-bold">{{ $title }}s</h5>
                            <p class="text-black-50 mb-0">Please see list of <span class="text-lowercase">{{ $title }}</span> below</p>
                        </div>
                    </div>
                    <div class="col-xl-6 d-flex align-items-center justify-content-start mt-xl-0 justify-content-xl-end">
                        <div class="mx-auto mx-xl-0 mt-3 btn-wrapper">
                            <button class="btn btn-secondary-orio" data-toggle="modal" data-target="#add_modal">Add {{ $title }}</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card card-box mb-3">
                <div class="card-header">
                    <div class="card-header--title">
                        <small>{{ $title }}s</small>
                        <b>List of <span class="text-lowercase">{{ $title }}</span></b>
                    </div>
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
                            <th>FIRSTNAME</th>
                            <th>LASTNAME</th>
                            <th>EMAIL</th>
                            <th>PHONE</th>
                            <th>ACTIVE</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
            <script>
                var listRoute = "{{ Route('admin.cities_collection') }}";
                var columns = [
                    {
                        data: "SNO"},
                    {
                        data: "FIRSTNAME",
                    },
                    {
                        data: "LASTNAME",
                    },
                    {
                        data: "EMAIL",
                    },
                    {
                        data: "PHONE",
                    },
                    {
                        data: "STATUS",
                    },
                    {
                        data: "ACTIONS",
                    },
                ];
            </script>
        @section('scripts')
            <script src="{{ asset('assets/js/admin/modules.js') }}"></script>
        @endsection

    @endsection
