@extends('layout.main')
@section('content')
    <div class="app-content">
        <div class="app-content--inner order-detail-wrapper">
            <div class="pb-4 text-center text-xl-left">
                <div class="row align-items-center">
                    <div class="col-xl-7">
                        <div>
                            <h5 class="title-text mb-1">{{ $title }}</h5>
                            <p class="sub-title-text mb-0">Manage {{ strtolower($title) }} below</p>
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
                                    <b>Manage {{ $title }}</b>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="no-gutters row">
                                    <div class="col-md-12">
                                        <form id="company_settings_form" data-parsley-validate
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="form-row">
                                                <div class="col-md-3">
                                                    <label for="inputEmail4">Company Name<span
                                                            class="req">*</span></label>
                                                    <input type="text" name="name" value="{{ $company->name }}"
                                                        class="form-control" id="Name" label="Name" required
                                                        placeholder="Company Name">
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="form-label" for="city_id" id="">
                                                        Select Currency</label>
                                                    <select required {{ isset($company->currency_code) && $company->currency_code != "" ? 'disabled' : '' }}
                                                        class=" form-control form-control-lg form-select city_id form-control form-control-lg-lg input_field "
                                                        id="currency_id" data-toggle="select2" name="base_currency"
                                                        size="1" label="Select Currency"
                                                        data-placeholder="Select Currency" data-allow-clear="1">
                                                        <option value="">Select Currency</option>
                                                        @foreach ($currencies as $currency)
                                                            @if (in_array($currency->code, ['PKR', 'AED', 'USD','SAR']))
                                                                <option value="{{ $currency->code }}"
                                                                    {{ isset($company->currency_code) && $currency->code == $company->currency_code ? 'selected' : '' }}>
                                                                    {{ $currency->name }} ({{ $currency->code }}) </option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="inputZip">Head Office Address<span
                                                            class="req">*</span></label>
                                                    <input type="text" name="office_address"
                                                        value="{{ $company->headoffice_address }}" class="form-control"
                                                        required placeholder="HeadOffice Address" id="office_address">
                                                </div>
                                            </div>
                                            <div id="rates-div" class="row mt-2">
                                                @if ($company->aed != '0' && $company->aed != '1')
                                                    <div class="col-md-3">
                                                        <label for="">Ammount In AED<span
                                                                class="req">*</span></label>
                                                        <input type="text" name="aed" class="form-control float"
                                                            required placeholder="Ammount In AED" value="{{ $company->aed }}">
                                                    </div>
                                                @endif
                                                @if ($company->usd != '0' && $company->usd != '1')
                                                    <div class="col-md-3">
                                                        <label for="">Ammount In USD<span
                                                                class="req">*</span></label>
                                                        <input type="text" name="usd" class="form-control float"
                                                            required placeholder="Ammount In USD" value="{{ $company->usd }}">
                                                    </div>
                                                @endif
                                                @if ($company->pkr != '0' && $company->pkr != '1')
                                                    <div class="col-md-3">
                                                        <label for="">Ammount In PKR<span
                                                                class="req">*</span></label>
                                                        <input type="text" name="pkr" class="form-control float"
                                                            required placeholder="Ammount In PKR" value="{{ $company->pkr }}">
                                                    </div>
                                                @endif
                                                @if ($company->sar != '0' && $company->sar != '1')
                                                    <div class="col-md-3">
                                                        <label for="">Ammount In SAR<span
                                                                class="req">*</span></label>
                                                        <input type="text" name="sar" class="form-control float"
                                                            required placeholder="Ammount In SAR" value="{{ $company->sar }}">
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="card-header--title mt-2 mb-2">
                                                <small class="d-block text-uppercase mt-1">theme color</small>
                                            </div>
                                            <div class="form-row mb-2">
                                                <div class="col-md-4">
                                                    <label for="inputEmail4">Primary Color<span
                                                            class="req">*</span></label>
                                                    <input type="color" name="primary_color"
                                                        value="{{ $company->primary_color }}" class="form-control" readonly
                                                        id="primary_color" label="Prmary Color" required
                                                        placeholder="Primary Color">
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="inputZip">Secondary Color<span
                                                            class="req">*</span></label>
                                                    <input type="color" name="secondary_color"
                                                        value="{{ $company->secondary_color }}" class="form-control"
                                                        required placeholder="Secondary Color" id="secondary_color">
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="inputZip">Font Color<span class="req">*</span></label>
                                                    <input type="color" name="font_color"
                                                        value="{{ $company->font_color }}" class="form-control" required
                                                        placeholder="Font Color" id="font_color">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label for="inputZip">Upload Logo<span class="req">*</span></label>
                                                    <div class="dropzone dropzone-single dz-clickable dz-max-files-reached"
                                                        data-toggle="dropzone-image-1"
                                                        data-dropzone-url="{{ route('admin.uploadProfileData') }}">
                                                        <div class="fallback">
                                                            <div class="custom-file">
                                                                <input type="file" class="custom-file-input"
                                                                    id="dropzoneBasicUpload">
                                                                <label class="custom-file-label"
                                                                    for="dropzoneBasicUpload"><i
                                                                        class="fad fa-image"></i></label>
                                                            </div>
                                                        </div>
                                                        <div class="dz-preview dz-preview-single">
                                                            <div class="dz-preview-cover">
                                                                <img class="dz-preview-img" src="" alt="..."
                                                                    data-dz-thumbnail>
                                                            </div>
                                                        </div>
                                                        <div id="pr_image_db" style="z-index:0"
                                                            class="pr_image_uploaded">
                                                            <img class="dz-preview-img"
                                                                src="{{ asset(session('company_logo') == 'orio-logo.svg' ? 'images/default/svg/' . session('company_logo') : 'images/' . session('company_id') . '/' . session('company_logo')) }}"
                                                                alt="" data-dz-thumbnail>
                                                        </div>
                                                        <input type="hidden" name="logo_image" class=""
                                                            id="image_1">
                                                    </div>
                                                </div>
                                                <input type="hidden" name="old_logo_image"
                                                    value="{{ $company->logo }}">
                                            </div>
                                            <div class="col-md-12 mt-3">
                                                <button class="btn btn-orio float-right" id="update_setting">Update
                                                    Profile</button>
                                            </div>
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
        var storeUrl = "{{ route('admin.company_settings') }}";
    </script>
@section('scripts')
    <script src="{{ asset('assets/js/auth/profile.js') }}"></script>
@endsection
@endsection
