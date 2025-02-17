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
                                        <form id="profile_form" data-parsley-validate enctype="multipart/form-data">
                                            @csrf
                                            <div class="form-row">
                                                <div class="col-md-6">
                                                    <label for="inputEmail4">First Name<span class="req">*</span></label>
                                                    <input type="text" name="f_name" value="{{ $company->first_name }}"
                                                        class="form-control form-control-lg" id="first_name"
                                                        label="First name" required placeholder="First Name">
                                                    <label id="error_first_name"></label>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="inputEmail4">Last Name<span class="req">*</span></label>
                                                    <input type="text" name="l_name" value="{{ $company->last_name }}"
                                                        class="form-control form-control-lg" id="last_name"
                                                        label="Last Name" required placeholder="Last Name">
                                                    <label id="error_last_name"></label>
                                                </div>
                                                <div class="col-md-6 mt-1">
                                                    <label class="form-label" for="" id="">Select Country</label>
                                                    <select required
                                                        class=" form-control form-control-lg form-select country_id form-control form-control-lg-lg input_field "
                                                        id="country_id" data-toggle="select2" name="country" size="1"
                                                        label="Select Country" data-placeholder="Select Country"
                                                        data-allow-clear="1">
                                                        <option value="">Select Country</option>
                                                        @foreach ($countries as $country)
                                                            <option value="{{ $country->id }}"
                                                                {{ isset($country->id) && $country->id == $company->country_id ? 'selected' : '' }}>
                                                                {{ $country->country_name }} </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-6 mt-1">
                                                    <label class="form-label" for="" id="">
                                                        Select City</label>
                                                    <select required
                                                        class=" form-control form-control-lg form-select city_id form-control form-control-lg-lg input_field "
                                                        id="city_id" data-toggle="select2" name="city" size="1"
                                                        label="Select Citiy" data-placeholder="Select Citiy"
                                                        data-allow-clear="1">
                                                        <option value="">Select City</option>
                                                        @foreach ($cities as $cities)
                                                            <option value="{{ $cities->id }}"
                                                                {{ isset($company->city_id) && $cities->id == $company->city_id ? 'selected' : '' }}>
                                                                {{ $cities->city }} </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-6 mt-2">
                                                    <label for="inputZip">Zip<span class="req">*</span></label>
                                                    <input type="text" name="zip" value="{{ $company->zip }}"
                                                        class="form-control form-control-lg number" minlength="5"
                                                        maxlength="10" required placeholder="Zip" id="zip">
                                                </div>
                                                <div class="col-md-6 mt-2">
                                                    <label for="inputZip">Email<span class="req">*</span></label>
                                                    <input type="email" name="email" readonly
                                                        value="{{ $company->email }}" class="form-control form-control-lg"
                                                        required placeholder="Email" id="email">
                                                </div>
                                                <div class="col-md-6 mt-2">
                                                    <label for="inputZip">Phone<span class="req">*</span></label>
                                                    <input type="tel" name="phone" value="{{ $company->phone }}"
                                                        class="form-control form-control-lg mobilenumber" required
                                                        placeholder="03__-_______" id="phone" minlength="10"
                                                        maxlength="13">
                                                </div>
                                                <div class="col-md-6 mt-2">
                                                    <label for="inputZip">Other Phone</label>
                                                    <input type="tel" name="phone2" value="{{ $company->phone2 }}"
                                                        class="form-control form-control-lg mobilenumber"
                                                        placeholder="03__-_______" minlength="10" maxlength="13"
                                                        id="phone2">
                                                </div>
                                                <div class="col-md-6 mt-2">
                                                    <label for="inputZip">NTN Number</label>
                                                    <input type="text" name="ntn"
                                                        value="{{ $company->ntn_number }}"
                                                        class="form-control form-control-lg number"
                                                        placeholder="NTN Number" id="ntn" minlength="10"
                                                        maxlength="13">
                                                </div>
                                                <div class="col-md-6 mt-2">
                                                    <label for="inputZip">CNIC Number<span class="req">*</span></label>
                                                    <input type="text" name="cnic"
                                                        value="{{ $company->cnic_number }}"
                                                        class="form-control form-control-lg number" required
                                                        placeholder="CNIC Number" id="cnic" minlength="10"
                                                        maxlength="13">
                                                    
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6 mt-2">
                                                    <label for="inputZip">Upload NTN</label>
                                                    <div class="dropzone dropzone-single dz-clickable dz-max-files-reached"
                                                        data-max-filesize="1443x561" data-toggle="dropzone-image-1"
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
                                                        @if ($company->ntn_img != '')
                                                            <div id="pr_image_db" style="z-index:0"
                                                                class="pr_image_uploaded">
                                                                <img class="dz-preview-img"
                                                                    src="{{ asset('images/' . session('company_id') . '/' . $company->ntn_img) }}"
                                                                    alt="" data-dz-thumbnail>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <input type="hidden" name="ntn_image" class=""
                                                        id="image_1">
                                                </div>

                                                <div class="col-md-6 mt-2">
                                                    <label for="inputZip">Upload CNIC<span class="req">*</span></label>
                                                    <div class="dropzone dropzone-single dz-clickable dz-max-files-reached"
                                                        data-max-filesize="1443x561" data-toggle="dropzone-image-2"
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
                                                        @if ($company->cnic_img != '')
                                                            <div id="pr_image_db" style="z-index:0"
                                                                class="pr_image_uploaded">
                                                                <img class="dz-preview-img"
                                                                    src="{{ asset('images/' . session('company_id') . '/' . $company->cnic_img) }}"
                                                                    alt="" data-dz-thumbnail>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <input type="hidden" name="cnic_image" id="image_2">
                                                </div>
                                            </div>
                                            <input type="hidden" name="old_ntn_image" value="{{ $company->ntn_img }}">
                                            <input type="hidden" name="cnic_old_image" value="{{ $company->cnic_img }}">
                                        </form>
                                    </div>
                                    <div class="col-md-12 mt-3">
                                        <button class="btn btn-orio float-right" id="submit-btn" type="button">Update
                                            Profile</button>
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

