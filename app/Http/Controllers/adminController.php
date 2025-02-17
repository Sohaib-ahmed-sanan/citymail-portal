<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;

class adminController extends Controller
{
    // list sale persons view
    public function sales_person(Request $request)
    {
        if ($request->isMethod('GET')) {
            $title = "Sales Persons";
            $countries = get_all_countries();
            $data = compact("title", "countries");
            return view("single_page_modules.salesPersons")->with($data);
        }
        if ($request->isMethod('POST')) {
            $company_id = session('company_id');
            $start_date = $request->start_date;
            $end_date = $request->end_date;
            $data = compact('company_id', 'start_date', 'end_date');
            $result = json_decode(getAPIJson('salesPersons/index', $data));
            $aaData = [];
            $i = 1;
            $resultsCount = 0;
            if ($result->status == 1) {
                $payload = $result->payload;
                $resultsCount = count($payload);
                $aaData = [];
                $i = 1;
                foreach ($payload as $key => $row) {
                    $statusBadgeClass = ($row->active == 1) ? 'badge-neutral-success text-success' : 'badge-neutral-danger text-danger';
                    $statusBadge = '<button table="employees" data-id="' . $row->id . '" data-status="' . ($row->active == 1 ? '0' : '1') . '" class="status_btn btn badge badge-pill ' . $statusBadgeClass . '">' . ($row->active == 1 ? 'Active' : 'Inactive') . '</button>';
                    $actions = '<div class="action-perform-btns">
                <a type="button" style="color: #ba0c2f !important;" href="javascript:void(0);" data-id="' . $row->id . '" data-route="' . route('admin.add_edit_salePerson') . '" class="edit-item" data-toggle="tooltip" title="Edit" odidcn="28"><img src="' . asset('assets/icons/Edit.svg') . '" width="15" alt="Edit"></a>
              <a table="employees" class="delete" style="color: #ba0c2f !important;" href="javascript:void(0);" data-id="' . $row->id . '" data-toggle="tooltip" title="Delete"><img src="' . asset('assets/icons/Delete.svg') . '" width="15" alt="Delete"></a>
          </div>';
                    $aaData[] = [
                        'SNO' => ++$key,
                        'FIRSTNAME' => $row->first_name,
                        'LASTNAME' => $row->last_name,
                        'EMAIL' => $row->email,
                        'PHONE' => $row->phone,
                        'STATUS' => $statusBadge,
                        'ACTIONS' => $actions,
                    ];
                    $i++;
                    $resultsCount++;
                }
            } 
            $arraylist = array(
                'TotalRecords' => $resultsCount,
                'aaData' => $aaData,
            );
            echo json_encode($arraylist);
        }
    }

    public function add_edit_salesPerson(Request $request, $id = null)
    {
        if ($request->isMethod('POST') && isset($request->type) && $request->type == "edit_modal") {
            $id = $request->id;
            $data = compact('id');
            $result = getAPIdata('salesPersons/single', $data);
            // dd($result);
            $countries = get_all_countries();
            $cities = get_all_cities();
            $payload = $result->payload;
            extract((array) $payload);
            $return = '<form id="edit_sales_men_from" enctype="multipart/form-data">
                <input type="hidden" name="_token" value="' . csrf_token() . '" autocomplete="off">
                <div class="form-row">
                    <div class="col-md-6 px-3">
                        <label for="inputEmail4">First Name<span class="req">*</span></label>
                        <input type="text" name="first_name" value="' . $first_name . '" class="form-control"
                            id="first_name" label="First name" required placeholder="First Name">
                        <label id="error_first_name"></label>
                    </div>
                    <div class="col-md-6 px-3">
                        <label for="inputEmail4">Last Name<span class="req">*</span></label>
                        <input type="text" name="last_name" value="' . $last_name . '" class="form-control"
                            id="last_name" label="Last name" required placeholder="Last Name">
                        <label id="error_last_name"></label>
                    </div>
                    <div class="col-md-6 px-3">
                        <label for="inputEmail4">Email<span class="req">*</span></label>
                        <input type="email" name="email" value="' . $email . '" class="form-control" id="email"
                            label="First name" required placeholder="Email">
                        <label id="error_email"></label>
                    </div>
                    <div class="col-md-6 px-3">
                        <label for="inputEmail4">Phone<span class="req">*</span></label>
                        <input type="tel" minlength="10" maxlength="12" name="phone" value="' . $phone . '" class="form-control mobilenumber" id="phone"
                            label="Phone" required placeholder="03xx-xxxxxxx" data-inputmask="{&quot;mask&quot;: &quot;0399-9999999&quot;}">
                        <label id="error_phone"></label>
                    </div>
                    <div class="mb-3 col-md-6 mt-3 px-3">
                        <label class="form-label" for="" id="">Select
                            Country</label>
                        <select required
                            class="form-control form-control-lg form-select country_id form-control form-control-lg-lg input_field "
                            id="" data-toggle="select2" name="country_id" size="1"
                            label="Select Country" data-placeholder="Select Country"
                            data-allow-clear="1">
                            <option value="">Select Country</option>';
                                foreach ($countries as $country) {
                                    $return .= '<option value="' . $country->id . '"' . (isset($payload->country_id) && $country->id == $payload->country_id ? 'selected' : '') . '>' . $country->country_name . '</option>';
                                };
                                $return .= '</select>
                    </div>
                    <div class="mb-3 col-md-6 mt-3 px-3">
                        <label class="form-label" for="" id="">
                            Select City</label>
                        <select required class=" form-control form-select city_id form-control-lg input_field "
                            id="" data-toggle="select2" name="city_id" size="1"
                            label="Sales Person" data-placeholder="Select city" data-allow-clear="1">
                            <option value="">Select City</option>';
                        foreach ($cities as $city) {
                            $return .= '<option value="' . $city->id . '" ' . (isset($payload->city_id) && $city->id == $payload->city_id ? 'selected' : '') . '>
                                                ' . $city->city . ' </option>';
                        }
                        $return .= '</select>
                    </div>
                    <div class="col-md-6 mt-3 px-3">
                        <label for="inputEmail4">Username<span class="req">*</span></label>
                        <input minlength="4" maxlength="18" name="username" type="text" value="' . $user_name . '" class="form-control"
                            id="username" label="Username" required placeholder="Enter Username">
                    </div>
                    <div class="col-md-6 mt-3 px-3">
                       <div class="d-flex justify-content-between">
                            <label for="inputEmail4">Password<span class="req">*</span></label>
                            <label data-toggle="tooltip" title="Click to generate password" class="gen-pass mb-0">Generate password</label>
                        </div>
                        <input type="password" name="password" value="" class="form-control passwordField" id="password"
                        label="Password" placeholder="Password">
                        <span class="show_pass_btn"><i class="fa-regular fa-eye"></i></span>
                    </div>
                    <div class="col-md-6 mt-3 px-3">
                        <label for="inputEmail4">Confirm Password<span class="req">*</span></label>
                        <input type="password" data-parsley-equalto="#password" name="confirm_password" value="" class="form-control passwordField" id="confirm_password"
                        label="Confirm Password" placeholder="Confirm Password">
                        <span class="show_pass_btn"><i class="fa-regular fa-eye"></i></span>
                    </div>
                <input type="hidden" name="id" value="' . $id . '">
                <input name="current_username" type="hidden" value="' . $user_name . '" >
                <input type="hidden" class="url" value="' . route('admin.add_edit_salePerson') . '">
            </form> ';

            return response()->json($return);
        }
        $request->validate([
            "first_name" => "required|regex:/^[A-Za-z\s'-]+$/",
            "last_name" => "required|regex:/^[A-Za-z\s'-]+$/",
            "phone" => "required",
            "email" => "required|email",
            "username" => "required",
            "city_id" => "required|numeric",
            "country_id" => "required|numeric",
        ]);
        // to manage the insert and update function
        if ($request->isMethod('POST') && $request->id == null) {
            // dr($request);
            $request->validate([
                "password" => "required",
            ]);
            $first_name = $request->first_name;
            $last_name = $request->last_name;
            $email = $request->email;
            $phone = $request->phone;
            $username = $request->username;
            $password = $request->password;
            $city_id = $request->city_id;
            $country_id = $request->country_id;
            $company_id = session('company_id');
            $token = Str::random(25);
            $data = compact('first_name', 'last_name', 'email', 'phone', 'company_id', 'password', 'username', 'city_id', 'country_id', 'token');
            $result = getAPIdata('salesPersons/add', $data);
            if ($result->status == '1') {
                $data = [
                    "co_name" => session('company_name'),
                    "user_name" => $request->username,
                    "password" => $request->password,
                ];
                $send_mail = app(emailController::class);
                $check = $send_mail->activation($request->email, $token . ':' . time() . '|' . base64_encode('sales_persons'), '3', $data);
            }
            $return = ['status' => $result->status, 'message' => $result->message, 'payload' => $result->payload];
            return response()->json($return);
        } elseif (isset($request->id) && $request->id != null && $request->isMethod('POST')) {
            $data = $request->only([
                'first_name',
                'last_name',
                'email',
                'phone',
                'city_id',
                'country_id',
                'id'
            ]);
            if ($request->password) {
                $data['password'] = $request->password;
            }
            if ($request->current_username !== $request->username) {
                $data['user_name'] = $request->username;
            } else {
                $data['user_name'] = '';
            }
            $result = getAPIdata('salesPersons/update', $data);
            $return = ['status' => $result->status, 'message' => $result->message, 'payload' => $result->payload];
            return response()->json($return);
        }
    }

    // END SALES PERSON FUNCTIONS

    // list riders view
    public function riders(Request $request)
    {
        if ($request->isMethod('GET')) {
            $title = "Riders";
            $stations = json_decode(getAPIJson('stations/index', ['company_id' => session('company_id')]));
            $countries = get_all_countries();
            $data = compact("title", "stations", "countries");
            return view("single_page_modules.riders")->with($data);
        }
        if ($request->isMethod('POST')) {
            $company_id = session('company_id');
            $start_date = $request->start_date;
            $end_date = $request->end_date;
            $data = compact('company_id', 'start_date', 'end_date');
            $result = getAPIdata('riders/index', $data);
            // $result = getAPIJson('riders/index', $data);
            // dd($result);
            $aaData = [];
            $i = 1;
            $resultsCount = 0;
            if ($result->status == 1) {
                $payload = $result->payload;
                $resultsCount = count($payload);
                $aaData = [];
                $i = 1;
                foreach ($payload as $key => $row) {
                    $statusBadgeClass = ($row->active == 1) ? 'badge-neutral-success text-success' : 'badge-neutral-danger text-danger';
                    $statusBadge = '<button table="employees" data-id="' . $row->id . '" data-status="' . ($row->active == 1 ? '0' : '1') . '" class="status_btn btn badge badge-pill  ' . $statusBadgeClass . '">' . ($row->active == 1 ? 'Active' : 'Inactive') . '</button>';
                    $actions = '<div class="action-perform-btns">
                 <a type="button" style="color: #ba0c2f !important;" href="javascript:void(0);" data-id="' . $row->id . '" data-route="' . route('admin.add_edit_rider') . '" class="edit-item" data-toggle="tooltip" title="Edit" odidcn="28"><img src="' . asset('assets/icons/Edit.svg') . '" width="15" alt="Edit"></a>
                 <a table="employees" class="delete" style="color: #ba0c2f !important;" href="javascript:void(0);" data-id="' . $row->id . '" data-toggle="tooltip" title="Delete"><img src="' . asset('assets/icons/Delete.svg') . '" width="15" alt="Delete"></a>
           </div>';
                    $aaData[] = [
                        'SNO' => ++$key,
                        'FIRSTNAME' => $row->first_name,
                        'LASTNAME' => $row->last_name,
                        'EMAIL' => $row->email,
                        'PHONE' => $row->phone,
                        'ADDRESS' => $row->address,
                        'CITY' => $row->city,
                        'STATUS' => $statusBadge,
                        'ACTIONS' => $actions,
                    ];
                    $i++;
                    $resultsCount++;
                }
            } else {
                $aaData[] = [
                    'SNO' => '',
                    'FIRSTNAME' => '',
                    'LASTNAME' => '',
                    'EMAIL' => '',
                    'PHONE' => '',
                    'ADDRESS' => '',
                    'CITY' => '',
                    'STATUS' => '',
                    'ACTIONS' => '',
                ];
            }
            $arraylist = array(
                'TotalRecords' => $resultsCount,
                'aaData' => $aaData,
            );
            echo json_encode($arraylist);
        }
    }
    // for add and edit the RIDER
    public function add_edit_rider(Request $request, $id = null)
    {
        if ($request->isMethod('POST') && isset($request->type) && $request->type == "edit_modal") {
            $id = $request->id;
            $data = compact('id');
            $result = json_decode(getAPIJson('riders/single', $data));
            $payload = $result->payload;
            $countries = get_all_countries();
            $cities = get_all_cities();
            extract((array) $payload);
            $return = '<form id="edit_rider_from" enctype="multipart/form-data">
            <input type="hidden" name="_token" value="' . csrf_token() . '" autocomplete="off">
            <div class="form-row">
                <div class="col-md-6 px-3">
                    <label for="inputEmail4">First Name<span class="req">*</span></label>
                    <input type="text" name="first_name" value="' . $first_name . '" class="form-control form-control-lg" id="name"
                        label="First Name" required placeholder="First Name">
                </div>
                <div class="col-md-6 px-3">
                    <label for="inputEmail4">Last Name<span class="req">*</span></label>
                    <input type="text" name="last_name" value="' . $last_name . '"
                        class="form-control form-control-lg" id="last_name" label="Last Name" required
                        placeholder="Last Name">
                </div>
                <div class="col-md-6 mt-3 px-3">
                    <label for="inputEmail4">Email<span class="req">*</span></label>
                    <input type="email" name="email" value="' . $email . '" class="form-control form-control-lg" id="email"
                        label="Email" required placeholder="Email">
                </div>
                <div class="col-md-6 mt-3 px-3">
                    <label for="inputEmail4">Phone<span class="req">*</span></label>
                    <input type="tel" minlength="10" maxlength="12" name="phone" value="' . $phone . '" class="form-control form-control-lg mobilenumber" placeholder="03xx-xxxxxxx" data-inputmask="{&quot;mask&quot;: &quot;0399-9999999&quot;}" id="phone"
                        label="Phone" required placeholder="03xx-xxxxxxx">
                </div>
                <div class="col-md-6 mt-3 px-3">
                    <label for="inputEmail4">Address<span class="req">*</span></label>
                    <input type="text" name="address" value="' . $address . '" class="form-control form-control-lg" id="address"
                        label="Phone" required placeholder="Address">
                </div>
                <div class="mb-3 col-md-6 mt-3 px-3">
                    <label class="form-label" for="" id="">Select
                    Country</label>
                    <select required
                    class="form-control form-control-lg form-select country_id form-control form-control-lg-lg input_field "
                    id="" data-toggle="select2" name="country_id" size="1"
                    label="Select Country" data-placeholder="Select Country"
                    data-allow-clear="1">
                    <option value="">Select Country</option>';
                    foreach ($countries as $country) {
                        $return .= '<option value="' . $country->id . '"' . (isset($payload->country_id) && $country->id == $payload->country_id ? 'selected' : '') . '>' . $country->country_name . '</option>';
                    };
                    $return .= '</select>
                </div>
                <div class="mb-3 col-md-6 mt-3 px-3">
                    <label class="form-label" for="" id="">
                        Select City</label>
                    <select required class=" form-control form-select city_id select-city form-control-lg input_field "
                        id="" data-toggle="select2" name="city_id" size="1"
                        label="Sales Person" data-placeholder="Select city" data-allow-clear="1">
                        <option value="">Select City</option>';
                    foreach ($cities as $city) {
                        $return .= '<option value="' . $city->id . '" ' . (isset($payload->city_id) && $city->id == $payload->city_id ? 'selected' : '') . '>
                                                        ' . $city->city . ' </option>';
                    }
                    $return .= '</select>
                </div>
                <div class="mb-3 col-md-6 mt-3 px-3">
                    <label class="form-label" for="station_id" id="">
                        Select Station</label>
                    <select required
                        class="form-control form-control-lg select-station form-select station_id input_field "
                        id="" data-toggle="select2" name="station_id" size="1"
                        label="Sales Station" data-placeholder="Select Station" data-allow-clear="1">
                        <option value="">Select Station</option>
                    </select>
                </div>
                <div class="col-md-6 mt-3 px-3">
                    <label for="inputEmail4">Username<span class="req">*</span></label>
                    <input minlength="4" maxlength="18" name="user_name" type="text"
                        value="' . (isset($user_name) ? $user_name : '') . '" class="form-control form-control-lg" id="user_name"
                        label="Username" required placeholder="Enter Username">
                    <input name="current_username" type="hidden" value="' . (isset($user_name) ? $user_name : '') . '">
                </div>
                <div class="col-md-6 mt-3 px-3">
                <div class="d-flex justify-content-between">
                    <label for="inputEmail4">Password<span class="req">*</span></label>
                    <label data-toggle="tooltip" title="Click to generate password" class="gen-pass mb-0">Generate password</label>
                </div>
                <input type="password" name="password" value="" class="form-control form-control-lg passwordField" id="password"
                 label="Password" placeholder="Password">
                 <span class="show_pass_btn"><i class="fa-regular fa-eye"></i></span>
            </div>
            <div class="col-md-6 mt-3 px-3">
                <label for="inputEmail4">Confirm Password<span class="req">*</span></label>
                <input type="password" name="confirm_password" value="" class="form-control form-control-lg passwordField" id="confirm_password"
                 label="Confirm Password" data-parsley-equalto="#password" placeholder="Confirm Password">
                 <span class="show_pass_btn"><i class="fa-regular fa-eye"></i></span>
            </div>
          
                <input type="hidden" name="id" value="' . $id . '">
                <input type="hidden" class="url" value="' . route('admin.add_edit_rider') . '">
            </form> ';
            return response()->json($return);
        }
        // to manage the insert and update function
        if ($request->isMethod('POST') && !isset($request->type)) {
            // dr($request);
            $request->validate([
                "first_name" => "required|regex:/^[A-Za-z\s'-]+$/",
                "last_name" => "required|regex:/^[A-Za-z\s'-]+$/",
                "phone" => "required",
                "email" => "required|email",
                "address" => "required",
                "city_id" => "required",
                "country_id" => "required",
                "user_name" => "required",
                "station_id" => "required",
            ]);
            if (!isset($request->id) && $request->isMethod('POST')) {
                $request->validate([
                    "password" => "required",
                    "confirm_password" => "required|same:password",
                ]);
                $data = $request->only([
                    'first_name',
                    'last_name',
                    'email',
                    'phone',
                    'address',
                    'city_id',
                    'country_id',
                    'password',
                    'user_name',
                    'station_id'
                ]);
                $data['company_id'] = session('company_id');
                $result = getAPIdata('riders/add', $data);
                // $result = getAPIJson('riders/add', $data);
                // dd($result);
                $return = ['status' => $result->status, 'message' => $result->message, 'payload' => $result->payload];
                return response()->json($return);
            } elseif (isset($request->id) && $request->id != null && $request->isMethod('POST')) {
                $data = $request->only([
                    'first_name',
                    'last_name',
                    'email',
                    'phone',
                    'address',
                    'city_id',
                    'country_id',
                    'station_id'
                ]);
                if ($request->password) {
                    $request->validate([
                        "password" => "required",
                        "confirm_password" => "required|same:password",
                    ]);
                    $data['password'] = $request->password;
                }
                if ($request->username !== $request->current_username) {
                    $data['user_name'] = $request->username;
                } else {
                    $data['user_name'] = '';
                }
                $data['id'] = $request->id;
                $result = getAPIdata('riders/update', $data);
                // $result = getAPIJson('riders/update', $data);
                // dd($result);
                $return = ['status' => $result->status, 'message' => $result->message, 'payload' => $result->payload];
                return response()->json($return);
            }
        }
    }
    // ----------- END RIDES FUNCTIONS
    // list ROUTES view
    public function routes(Request $request)
    {
        if ($request->isMethod('GET')) {
            $title = "Routes";
            $countries = get_all_countries();
            $data = compact("title", "countries");
            return view("single_page_modules.routes")->with($data);
        }
        if ($request->isMethod('POST')) {
            $company_id = session('company_id');
            $start_date = $request->start_date;
            $end_date = $request->end_date;
            $data = compact('company_id', 'start_date', 'end_date');
            $result = json_decode(getAPIJson('routes/index', $data));
            $aaData = [];
            $i = 1;
            $resultsCount = 0;
            if ($result->status == 1) {
                $payload = $result->payload;
                $resultsCount = count($payload);
                $aaData = [];
                $i = 1;
                foreach ($payload as $key => $row) {
                    $statusBadgeClass = ($row->active == 1) ? ' badge-neutral-success text-success' : ' badge-neutral-danger text-danger';
                    $statusBadge = '<button table="routes" data-id="' . $row->id . '" data-status="' . ($row->active == 1 ? '0' : '1') . '" class="status_btn btn badge badge-pill ' . $statusBadgeClass . '">' . ($row->active == 1 ? 'Active' : 'Inactive') . '</button>';
                    $actions = '<div class="action-perform-btns">
                    <a type="button" style="color: #ba0c2f !important;" href="javascript:void(0);" data-id="' . $row->id . '" data-route="' . route('admin.add_edit_route') . '" class="edit-item" data-toggle="tooltip" title="Edit" odidcn="28"><img src="' . asset('assets/icons/Edit.svg') . '" width="15" alt="Edit"></a>
                    <a table="routes" class="delete" style="color: #ba0c2f !important;" href="javascript:void(0);" data-id="' . $row->id . '" data-toggle="tooltip"  title="Delete"><img src="' . asset('assets/icons/Delete.svg') . '" width="15" alt="Delete"></a>
            </div>';
                    $aaData[] = [
                        'SNO' => ++$key,
                        'CITY' => $row->city,
                        'ADDRESS' => $row->address,
                        'STATUS' => $statusBadge,
                        'ACTIONS' => $actions,
                    ];
                    $i++;
                    $resultsCount++;
                }
            } else {
                $aaData[] = [
                    'SNO' => '',
                    'CITY' => '',
                    'ADDRESS' => '',
                    'STATUS' => '',
                    'ACTIONS' => '',
                ];
            }
            $arraylist = array(
                'TotalRecords' => $resultsCount,
                'aaData' => $aaData,
            );
            echo json_encode($arraylist);
        }
    }

    // for add and edit the ROUTES
    public function add_edit_route(Request $request, $id = null)
    {
        if ($request->isMethod('POST') && isset($request->type) && $request->type == "edit_modal") {
            $id = $request->id;
            $data = compact('id');
            $result = json_decode(getAPIJson('routes/single', $data));
            $payload = $result->payload;
            // $riders = getAPIdata('riders/index', ['company_id' => session('company_id')]);
            $countries = get_all_countries();
            $cities = get_all_cities();
            extract((array) $payload);
            $return = '<form id="edit_route_from" enctype="multipart/form-data">
                <input type="hidden" name="_token" value="' . csrf_token() . '" autocomplete="off">
                <div class="form-row">
                    <div class="mb-3 col-md-6 px-3">
                        <label class="form-label" for="" id="">Select Country</label>
                        <select required
                            class="form-control form-control-lg form-select country_id form-control form-control-lg-lg input_field "
                            id="" data-toggle="select2" name="country_id" size="1"
                            label="Select Country" data-placeholder="Select Country"
                            data-allow-clear="1">
                            <option value="">Select Country</option>';
                            foreach ($countries as $country) {
                                $return .= '<option value="' . $country->id . '"' . (isset($payload->country_id) && $country->id == $payload->country_id ? 'selected' : '') . '>' . $country->country_name . '</option>';
                            };
                        $return .= '</select>
                    </div>
                    <div class="mb-3 col-md-6 px-3">
                        <label class="form-label" for="country_id" id="">
                            Select City</label>
                        <select required class=" form-control form-select country_id form-control-lg input_field "
                            id="city" data-toggle="select2" name="city_id" size="1"
                        label="Select City" data-placeholder="Select city" data-allow-clear="1">
                        <option value="">Select City</option>';
                        foreach ($cities as $city) {
                            $return .= '<option value="' . $city->id . '" ' . (isset($payload->city_id) && $city->id == $payload->city_id ? 'selected' : '') . '>
                                    ' . $city->city . ' </option>';
                        }
                        $return .= '</select>
                    </div>
                    <div class="col-md-6 px-3">
                        <label for="inputEmail4">Address<span class="req">*</span></label>
                        <input type="tel" name="address" value="' . $address . '" class="form-control form-control-lg" id="address"
                            label="Phone" required placeholder="Address">
                    </div>
                </div>
                <input type="hidden" name="id" value="' . $id . '">
                <input type="hidden" class="url" value="' . route('admin.add_edit_route') . '">
                </form> ';
            return response()->json($return);
        }
        // to manage the insert and update function
        if ($request->isMethod('POST') && !isset($request->type)) {
            // dr($request);
            $request->validate([
                "address" => "required",
                "country_id" => "required",
                "city_id" => "required",
            ]);
            if (!isset($request->id) && $request->isMethod('POST')) {
                $data = $request->only([
                    'address',
                    'city_id',
                    'country_id',
                ]);
                $data['company_id'] = session('company_id');
                //  $result = getAPIJson('routes/add', $data);
                // dd($result);
                $result = getAPIdata('routes/add', $data);
                $return = ['status' => $result->status, 'message' => $result->message, 'payload' => $result->payload];
                return response()->json($return);
            } elseif (isset($request->id) && $request->id != null && $request->isMethod('POST')) {
                $data = $request->only([
                    'address',
                    'city_id',
                    'country_id',
                ]);
                $data['id'] = $request->id;
                $result = getAPIdata('routes/update', $data);
                // $result = getAPIJson('routes/update', $data);
                // dd($result);
                $return = ['status' => $result->status, 'message' => $result->message, 'payload' => $result->payload];
                return response()->json($return);
            }
        }
    }
    // ----- END ROUTES FUNCTIONS
    // list pickup_locations view
    public function pickup_locations(Request $request)
    {
        if ($request->isMethod('GET')) {
            $title = "Pickup Locations";
            get_all_status();
            $countries = get_all_countries();
            $cities = get_all_cities();
            $customers_function = get_customers();
            $customers = $customers_function->original['payload'];
            $sub_accounts = [];
            if (session('type') === '6') {
                $fetch_sub_acc = get_customers_sub(session('acno'));
                $sub_accounts = $fetch_sub_acc->original;
            }
            $data = compact("title", "customers", "sub_accounts", "countries", "cities");
            return view("single_page_modules.pickup_locations")->with($data);
        }
        if ($request->isMethod('POST')) {
            $company_id = session('company_id');
            $type = session('type');
            $customer_acno = $employee_id = '';
            switch ($type) {
                case '1':
                    if ($request->customer_acno != '') {
                        $customer_acno = isset($request->customer_acno) ? implode(',', $request->customer_acno) : '';
                    }
                    break;
                case '6':
                    if ($request->customer_acno == '') {
                        $prams = ['acno' => session('acno')];
                        $get_childs = getAPIdata('common/getSubAccounts', $prams);
                        $sub_account_acno = $get_childs->payload ?? '';
                        $customer_acno = $sub_account_acno != '' ? session('acno') . ',' . $sub_account_acno : session('acno');
                    } else {
                        $customer_acno = isset($request->customer_acno) ? implode(',', $request->customer_acno) : '';
                    }
                    break;
                case '7':
                    $customer_acno = session('acno');
                    break;
                case '3':
                    $employee_id = session('employee_id');
                    break;
            }

            $start_date = $request->start_date;
            $end_date = $request->end_date;
            $city_id = isset($request->city_id) ? implode(',', $request->city_id) : '';
            $data = compact('company_id', 'type', 'customer_acno', 'start_date', 'end_date', 'city_id','employee_id');
            $result = getAPIdata('pickupLocation/index', $data);
            $aaData = [];
            $i = 1;
            $resultsCount = 0;
            if ($result->status == 1) {
                $payload = $result->payload;
                $resultsCount = count($payload);
                foreach ($payload as $key => $row) {
                    $statusBadgeClass = ($row->active == 1) ? ' badge-neutral-success text-success' : ' badge-neutral-danger text-danger';
                    $statusBadge = '<button table="pickup_locations" data-id="' . $row->id . '" data-status="' . ($row->active == 1 ? '0' : '1') . '" class="status_btn btn badge badge-pill ' . $statusBadgeClass . '">' . ($row->active == 1 ? 'Active' : 'Inactive') . '</button>';
                    $actions = '<div class="action-perform-btns">
                    <a type="button" style="color: #ba0c2f !important;" href="javascript:void(0);" data-id="' . $row->id . '" data-route="' . route('admin.add_edit_pickupLocation') . '" class="edit-item" data-toggle="tooltip" title="Edit" odidcn="28"><img src="' . asset('assets/icons/Edit.svg') . '" width="15" alt="Edit"></a>
                    <a table="pickup_locations" class="delete" style="color: #ba0c2f !important;" href="javascript:void(0);" data-id="' . $row->id . '" data-toggle="tooltip" title="Delete" ><img src="' . asset('assets/icons/Delete.svg') . '" width="15" alt="Delete"></a>
                    </div>';
                    $account = $row->customer_acno;
                    $aaData[] = [
                        'SNO' => $i,
                        'PICKUPID' => $row->id,
                        'ACCOUNT' => $account,
                        'NAME' => $row->name,
                        'EMAIL' => $row->email,
                        'PHONE' => $row->phone,
                        'ADDRESS' => $row->address,
                        'CITY' => $row->city,
                        'ACCTYPE' => ($row->parent_id === '0' || $row->parent_id == '' ? 'Main Account' : 'Sub Account'),
                        'STATUS' => $statusBadge,
                        'ACTIONS' => $actions,
                    ];
                    $i++;
                    $resultsCount++;
                }
            } 

            $arraylist = array(
                'TotalRecords' => $resultsCount,
                'aaData' => $aaData,
            );
            echo json_encode($arraylist);
        }
    }
    // for add and edit the pickup_locations
    public function add_edit_locations(Request $request, $id = null)
    {
        if ($request->isMethod('POST') && isset($request->type) && $request->type == "edit_modal") {
            $id = $request->id;
            $data = compact('id');
            $result = getAPIdata('pickupLocation/single', $data);
            $payload = $result->payload;
            $customers_function = get_customers();
            $customers = $customers_function->original['payload'];
            $sub_accounts_arr = [];
            if (is_portal()) {
                $fetch_sub_acc = get_customers_sub(session('acno'));
                $sub_accounts_arr = $fetch_sub_acc->original;
            }
            $countries = get_all_countries();
            $cities = get_all_cities();
            extract((array) $payload);
            $return = '<form id="edit_route_from" enctype="multipart/form-data">
                <input type="hidden" name="_token" value="' . csrf_token() . '" autocomplete="off">
            <div class="form-row">
            <div class="col-md-6 mb-3 px-3">
                <label for="title">Title<span class="req">*</span></label>
                <input type="text" class="form-control form-control-lg" id="title" name="title"
                    placeholder="Enter Title"
                    value="' . $title . '" required="true">
            </div>
            <div class="col-md-6 mb-3 px-3">
                <label for="Customer_name">Name<span class="req">*</span></label>
                <input type="text" class="form-control form-control-lg" id="name" name="name"
                    placeholder="Enter Name" value="' . $name . '"
                    required="true">
            </div>
            <div class="col-md-6 mb-3 px-3">
                <label for="Customer_name">Email<span class="req">*</span></label>
                <input type="email" class="form-control form-control-lg" id="email" name="email"
                    placeholder="Enter Email"
                    value="' . $email . '" required="true">
            </div>
            <div class="col-md-6 mb-3 px-3">
                <label for="Customer_name">Phone<span class="req">*</span></label>
                <input minlength="10" maxlength="12"  type="tel"
                    class="form-control form-control-lg mobilenumber" id="phone" name="phone" placeholder="Enter Phone"
                    value="' . $phone . '" required="true">
            </div>
            <div class="col-md-6 mb-3 px-3">
                <label for="Customer_name">Address<span class="req">*</span></label>
                <input type="text" class="form-control form-control-lg" id="address" name="address"
                    placeholder="Enter Address"
                    value="' . $address . '" required="true">
            </div>';
            // if (is_portal()) {
            //     $return .= '<div class="mb-3 col-md-6">
            //          <input type="hidden" name="customer_acno" value="' . session('acno') . '">
            //         <label class="form-label" for="sub_account_id" id="">Make for Sub account</label>
            //         <select
            //             class=" form-control form-select sub_account_id form-control-lg input_field"
            //             id="is-sub-account" data-toggle="select2" name="sub_account_id"
            //             size="1" label="Make for Sub account"
            //             data-placeholder="Make for Sub account" data-allow-clear="1">
            //             <option value="0">NO</option>
            //             <option ' . ($customer_acno != session('acno') ? 'selected' : '') . ' value="1">YES</option>
            //         </select>
            //     </div>
            //     <div id="sub_account_id" class="mb-3 col-md-6 d-none">
            //         <label class="form-label" for="sub_account_id" id="">
            //             Select Sub Account</label>
            //         <select 
            //             class="form-control form-select sub_account_id form-control-lg input_field"
            //             data-toggle="select2" name="sub_account_id"
            //             size="1" id="sub-acc-select" label="Select Sub Account"
            //             data-placeholder="Select Sub Account" data-allow-clear="1">
            //             <option value="">Select Sub Account</option>';
            //     foreach ($sub_accounts_arr as $sub_account) {
            //         $return .= '<option value="' . $sub_account->id . '"
            //                     ' . (isset($customer_acno) && $sub_account->id == $customer_acno ? 'selected' : '') . '>
            //                     ' . $sub_account->name . '</option>';
            //     }
            //     $return .= '</select>
            //     </div>';
            // }
            if (is_customer_sub()) {
                $return .= '<input type="hidden" name="sub_account_id" value="' . session('logged_id') . '">';
            }
            $return .= '
             <div class="mb-3 col-md-6 px-3">
                <label class="form-label" for="" id="">Select
                    Country</label>
                <select required
                    class="form-control form-control-lg form-select country_id form-control form-control-lg-lg input_field "
                    id="edit_country" data-toggle="select2" name="country_id" size="1"
                    label="Select Country" data-placeholder="Select Country"
                    data-allow-clear="1">
                    <option value="">Select Country</option>';
                    foreach ($countries as $country) {
                        $return .= '<option value="' . $country->id . '"' . (isset($payload->country_id) && $country->id == $payload->country_id ? 'selected' : '') . '>' . $country->country_name . '</option>';
                    };
                    $return .= '</select>
            </div>
            <div class="mb-3 col-md-6 px-3">
                <label class="form-label" for="city_id" id="">Select City</label>
                <select required
                    class=" form-control form-select city_id form-control-lg input_field "
                    id="edit_city" data-toggle="select2" name="city_id" size="1"
                    label="Select Citiy" data-placeholder="Select Citiy" data-allow-clear="1">
                    <option value="">Select City</option>';
                    foreach ($cities as $city) {
                        $return .= '<option value="' . $city->id . '" ' . (isset($city_id) && $city->id == $city_id ? 'selected' : '') . '>
                                        ' . $city->city . ' </option>';
                    }
                $return .= '</select>
            </div>';
            if (is_ops()) {
                $return .= '<div class="mb-3 col-md-6 px-3">
                    <label class="form-label" for="" id="">
                        Select Customer</label>
                    <select required
                        class=" form-control form-select form-control-lg input_field "
                        id="" data-toggle="select2" name="customer_acno" size="1"
                        label="Select Customer" data-placeholder="Select Customer"
                        data-allow-clear="1">
                        <option value="">Select Customer</option>';
                foreach ($customers as $customer) {
                    $return .= '<option ' . (isset($customer_acno) && $customer->acno == $customer_acno ? 'selected' : '') . ' value="' . $customer->acno . '">' . $customer->business_name . ' (' . $customer->acno . ')</option>';
                }
                $return .= '  </select>
                </div>';
            } else {
                $return .= '<input type="hidden" name="customer_acno" value="' . session('acno') . '">';
            }
            $return .= '  </div>
            </div>
            <input type="hidden" name="id" value="' . $id . '">
            <input type="hidden" class="url" value="' . route('admin.add_edit_pickupLocation') . '">
            </form> ';
            return response()->json($return);
        }
        // to manage the insert and update function
        if ($request->isMethod('POST') && !isset($request->type)) {
            $request->validate([
                "title" => "required",
                "name" => "required|regex:/^[A-Za-z\s'-]+$/",
                "phone" => "required",
                "email" => "required|email",
                "address" => "required",
                "country_id" => "required",
                "city_id" => "required",
                "customer_acno" => "required",
            ]);
            if (!isset($request->id) && $request->isMethod('POST')) {
                $data = $request->only([
                    'name',
                    'title',
                    'email',
                    'phone',
                    'address',
                    'country_id',
                    'city_id',
                ]);
                if (isset($request->sub_account_acno) && $request->sub_account_acno != '') {
                    $data['customer_acno'] = $request->sub_account_acno;
                } else {
                    $data['customer_acno'] = $request->customer_acno;
                }
                $data['company_id'] = session('company_id');
                $result = getAPIdata('pickupLocation/add', $data);
                $return = ['status' => $result->status, 'message' => $result->message, 'payload' => $result->payload];
                return response()->json($return);
            } elseif (isset($request->id) && $request->id != null && $request->isMethod('POST')) {
                $data = $request->only([
                    'name',
                    'title',
                    'email',
                    'phone',
                    'address',
                    'country_id',
                    'city_id',
                    'customer_acno'
                ]);

                $data['id'] = $request->id;
                $result = getAPIdata('pickupLocation/update', $data);
                $return = ['status' => $result->status, 'message' => $result->message, 'payload' => $result->payload];
                return response()->json($return);
            }
        }
    }
    //  END PICKUP LOCATIONS 

    // list stations view
    public function stations(Request $request)
    {
        if ($request->isMethod('GET')) {
            $title = "Stations";
            $countries = get_all_countries();
            $data = compact("title", "countries");
            return view("single_page_modules.stations")->with($data);
        }
        if ($request->isMethod('POST')) {
            $company_id = session('company_id');
            $start_date = $request->start_date;
            $end_date = $request->end_date;
            $data = compact('company_id', 'start_date', 'end_date');
            $result = json_decode(getAPIJson('stations/index', $data));
            $aaData = [];
            $i = 1;
            $resultsCount = 0;
            if ($result->status == 1) {
                $payload = $result->payload;
                $resultsCount = count($payload);
                foreach ($payload as $key => $row) {
                    $statusBadgeClass = ($row->active == 1) ? ' badge-neutral-success text-success' : 'badge-neutral-danger text-danger';
                    $statusBadge = '<button table="stations" data-id="' . $row->id . '" data-status="' . ($row->active == 1 ? '0' : '1') . '" class="status_btn btn badge badge-pill ' . $statusBadgeClass . '">' . ($row->active == 1 ? 'Active' : 'Inactive') . '</button>';
                    $actions = '<div class="action-perform-btns">
                  <a type="button" style="color: #ba0c2f !important;" href="javascript:void(0);" data-id="' . $row->id . '" data-route="' . route('admin.add_edit_station') . '" class="edit-item" data-toggle="tooltip" title="Edit" odidcn="28"><img src="' . asset('assets/icons/Edit.svg') . '" width="15" alt="Edit"></a>
                  <a table="stations" class="delete" style="color: #ba0c2f !important;" href="javascript:void(0);" data-id="' . $row->id . '" data-toggle="tooltip" title="Delete"><img src="' . asset('assets/icons/Delete.svg') . '" width="15" alt="Delete"></a>
            </div>';
                    $aaData[] = [
                        'SNO' => ++$key,
                        'NAME' => $row->name,
                        'ADDRESS' => $row->address,
                        'CITY' => $row->city,
                        'STATUS' => $statusBadge,
                        'ACTIONS' => $actions,
                    ];
                    $i++;
                    $resultsCount++;
                }
            }
            $arraylist = array(
                'TotalRecords' => $resultsCount,
                'aaData' => $aaData,
            );
            echo json_encode($arraylist);
        }
    }
    // for add and edit the customer
    public function add_edit_station(Request $request, $id = null)
    {
        if ($request->isMethod('POST') && isset($request->type) && $request->type == "edit_modal") {
            $id = $request->id;
            $data = compact('id');
            $result = getAPIdata('stations/single', $data);
            $countries = get_all_countries();
            $cities = get_all_cities();
            $payload = $result->payload;
            extract((array) $payload);
            $return = '<form id="edit_station_form" enctype="multipart/form-data">
             <input type="hidden" name="_token" value="' . csrf_token() . '" autocomplete="off">
             <div class="form-row">
                 <div class="col-md-6 px-3">
                     <label for="inputEmail4">Name<span class="req">*</span></label>
                     <input type="text" name="name" value="' . $name . '" class="form-control form-control-lg" id="name"
                         label="Name" required placeholder="Name">
                 </div>
                 <div class="col-md-6 px-3">
                     <label for="inputEmail4">Address<span class="req">*</span></label>
                     <input type="text" name="address" value="' . $address . '" class="form-control form-control-lg" id="address"
                         label="Address" required placeholder="Address">
                 </div>
                <div class="mb-3 col-md-6 mt-3 px-3">
                    <label class="form-label" for="" id="">Select
                        Country</label>
                    <select required
                        class="form-control form-control-lg form-select country_id form-control form-control-lg-lg input_field "
                        id="" data-toggle="select2" name="country_id" size="1"
                        label="Select Country" data-placeholder="Select Country"
                        data-allow-clear="1">
                        <option value="">Select Country</option>';
                        foreach ($countries as $country) {
                            $return .= '<option value="' . $country->id . '"' . (isset($payload->country_id) && $country->id == $payload->country_id ? 'selected' : '') . '>' . $country->country_name . '</option>';
                        };
                        $return .= '</select>
                </div>
                <div class="mb-3 col-md-6 mt-3 px-3">
                     <label class="form-label" for="city_id" id="">
                         Select City</label>
                     <select required class=" form-control form-select city_id form-control-lg input_field "
                         id="" data-toggle="select2" name="city_id" size="1"
                         label="Sales Person" data-placeholder="Select city" data-allow-clear="1">
                         <option value="">Select City</option>';
                            foreach ($cities as $city) {
                                $return .= '<option value="' . $city->id . '" ' . (isset($payload->city_id) && $city->id == $payload->city_id ? 'selected' : '') . '>
                                            ' . $city->city . ' </option>';
                            }
                            $return .= '</select>
                 </div>
             </div>
            <input type="hidden" name="id" value="' . $id . '">
            <input type="hidden" class="url" value="' . route('admin.add_edit_station') . '">
        </form> ';
            return response()->json($return);
        }
        // to manage the insert and update function
        if ($request->isMethod('POST') && !isset($request->type)) {
            $request->validate([
                "name" => "required|regex:/^[A-Za-z\s'-]+$/",
                "address" => "required",
                "country_id" => "required",
                "city_id" => "required",
            ]);
            if (!isset($request->id) && $request->isMethod('POST')) {
                $data = $request->only([
                    'name',
                    'address',
                    'country_id',
                    'city_id',
                ]);
                $data['company_id'] = session('company_id');
                $result = getAPIdata('stations/add', $data);
                $return = ['status' => $result->status, 'message' => $result->message, 'payload' => $result->payload];
                return response()->json($return);
            } elseif (isset($request->id) && $request->id != null && $request->isMethod('POST')) {
                $data = $request->only([
                    'name',
                    'address',
                    'country_id',
                    'city_id',
                ]);

                $data['id'] = $request->id;
                $result = getAPIdata('stations/update', $data);
                $return = ['status' => $result->status, 'message' => $result->message, 'payload' => $result->payload];
                return response()->json($return);
            }
        }
    }
    // list stations view
    public function cities_collection(Request $request)
    {
        if ($request->method() == 'GET') {
            $title = "Cities collection";
            $cities = get_all_cities();

            $data = compact("title");
            return view("cities_collection.cities_collection")->with($data);
        }
        if ($request->method() == 'POST') {
            $company_id = session('company_id');
            $start_date = $request->start_date;
            $end_date = $request->end_date;
            $data = compact('company_id', 'start_date', 'end_date');
            $result = json_decode(getAPIJson('stations/index', $data));
            $aaData = [];
            $i = 1;
            $resultsCount = 0;
            if ($result->status == 1) {
                $payload = $result->payload;
                $resultsCount = count($payload);
                foreach ($payload as $key => $row) {
                    $statusBadgeClass = ($row->active == 1) ? ' badge-neutral-success text-danger' : 'badge-neutral-danger text-danger';
                    $statusBadge = '<button table="stations" data-id="' . $row->id . '" data-status="' . ($row->active == 1 ? '0' : '1') . '" class="status_btn btn badge badge-pill ' . $statusBadgeClass . '">' . ($row->active == 1 ? 'Active' : 'Inactive') . '</button>';
                    $actions = '<div class="action-perform-btns">
              <a type="button" style="color: #ba0c2f !important;" href="javascript:void(0);" data-id="' . $row->id . '" data-route="' . route('admin.add_edit_station') . '" class="edit-item" data-toggle="tooltip" title="Edit" odidcn="28"><img src="' . asset('assets/icons/Edit.svg') . '" width="15" alt="Edit"></a>
              <a table="stations" class="delete" style="color: #ba0c2f !important;" href="javascript:void(0);" data-id="' . $row->id . '" data-toggle="tooltip" title="Delete"><img src="' . asset('assets/icons/Delete.svg') . '" width="15" alt="Delete"></a>
        </div>';
                    $aaData[] = [
                        'SNO' => ++$key,
                        'NAME' => $row->name,
                        'ADDRESS' => $row->address,
                        'CITY' => $row->city,
                        'STATUS' => $statusBadge,
                        'ACTIONS' => $actions,
                    ];
                    $i++;
                    $resultsCount++;
                }
            }
            $arraylist = array(
                'TotalRecords' => $resultsCount,
                'aaData' => $aaData,
            );
            echo json_encode($arraylist);
        }
    }
    // for add and edit the customer
    public function add_edit_collection(Request $request, $id = null)
    {
        if ($request->isMethod('POST') && isset($request->type) && $request->type == "edit_modal") {
            $id = $request->id;
            $data = compact('id');
            $result = getAPIdata('stations/single', $data);
            $payload = $result->payload;
            extract((array) $payload);
            $return = '<form id="edit_station_form" enctype="multipart/form-data">
             <input type="hidden" name="_token" value="' . csrf_token() . '" autocomplete="off">
             <div class="form-row">
                 <div class="col-md-6">
                     <label for="inputEmail4">Name<span class="req">*</span></label>
                     <input type="text" name="name" value="' . $name . '" class="form-control" id="name"
                         label="Name" required placeholder="Name">
                 </div>
                 <div class="col-md-6 ">
                     <label for="inputEmail4">Address<span class="req">*</span></label>
                     <input type="text" name="address" value="' . $address . '" class="form-control" id="address"
                         label="Phone" required placeholder="Address">
                 </div>
                 <div class="mb-3 col-md-6 mt-3">
                     <label class="form-label" for="city_id" id="">
                         Select City</label>
                     <select required class=" form-control form-select city_id form-control-lg input_field "
                         id="" data-toggle="select2" name="city_id" size="1"
                         label="Sales Person" data-placeholder="Select city" data-allow-clear="1">
                         <option value="">Select City</option>';
            foreach ($cities as $cities) {
                $return .= '<option value="' . $cities->id . '" ' . (isset($payload->city_id) && $cities->id == $payload->city_id ? 'selected' : '') . '>
                             ' . $cities->city . ' </option>';
            }
            $return .= '</select>
                     </select>
                 </div>
             </div>
            <input type="hidden" name="id" value="' . $id . '">
            <input type="hidden" class="url" value="' . route('admin.add_edit_station') . '">
        </form> ';
            return response()->json($return);
        }
        // to manage the insert and update function
        if ($request->isMethod('POST') && !isset($request->type)) {
            $request->validate([
                "name" => "required|regex:/^[A-Za-z\s'-]+$/",
                "city_id" => "required",
            ]);
            if (!isset($request->id) && $request->isMethod('POST')) {
                $data = $request->only([
                    'name',
                ]);
                $data['company_id'] = session('company_id');
                $data['city_ids'] = implode($request->city_id);
                $result = getAPIdata('city_collections/add', $data);
                $return = ['status' => $result->status, 'message' => $result->message, 'payload' => $result->payload];
                return response()->json($return);
            } elseif (isset($request->id) && $request->id != null && $request->isMethod('POST')) {
                $data = $request->only([
                    'name',
                    'city_id'
                ]);
                $data['id'] = $request->id;
                $result = getAPIdata('city_collections/update', $data);
                // $result = getAPIJson('riders/update', $data);
                // dd($result);
                $return = ['status' => $result->status, 'message' => $result->message, 'payload' => $result->payload];
                return response()->json($return);
            }
        }
    }

    public function city_mapping(Request $request)
    {
        if ($request->isMethod('GET')) {
            $title = "City Mapping";
            $countries = get_all_countries();
            $couriers = get_all_couriers();
            return view("single_page_modules.city-mapping")->with(compact("title", "countries", "couriers"));
        }
        if ($request->isMethod('POST')) {
            $company_id = session('company_id');
            $start_date = $request->start_date;
            $end_date = $request->end_date;
            $data = compact('company_id', 'start_date', 'end_date');
            $result = json_decode(getAPIJson('cityMapping/index', $data));
            $aaData = [];
            $i = 1;
            $resultsCount = 0;
            if ($result->status == 1) {
                $payload = $result->payload;
                $resultsCount = count($payload);
                $aaData = [];
                $i = 1;
                foreach ($payload as $key => $row) {
                    $statusBadgeClass = ($row->active == 1) ? 'badge-neutral-success text-success' : 'badge-neutral-danger text-danger';
                    $statusBadge = '<button table="courier_mappings" data-id="' . $row->id . '" data-status="' . ($row->active == 1 ? '0' : '1') . '" class="status_btn btn badge badge-pill ' . $statusBadgeClass . '">' . ($row->active == 1 ? 'Active' : 'Inactive') . '</button>';
                    $aaData[] = [
                        'SNO' => ++$key,
                        'courier_name' => $row->courier_name,
                        'city_id' => $row->city_id,
                        'city' => $row->city,
                        'courier_city_code' => $row->courier_city_code,
                        'STATUS' => $statusBadge,
                    ];
                    $i++;
                    $resultsCount++;
                }
            }

            $arraylist = array(
                'TotalRecords' => $resultsCount,
                'aaData' => $aaData,
            );
            echo json_encode($arraylist);
        }
    }

    public function add_edit_city_mapping(Request $request, $id = null)
    {
        if ($request->isMethod('POST') && $request->id == null) {
            $city_courier = $request->city_courier;
            $courier = $request->courier;
            $city_id = $request->city_id;
            $country_id = $request->country_id;
            $company_id = session('company_id');
            $token = Str::random(25);
            $data = compact('city_courier', 'courier', 'city_id', 'country_id', 'company_id', 'token');
            $result = getAPIdata('cityMapping/add', $data);
            $return = ['status' => $result->status, 'message' => $result->message, 'payload' => $result->payload];  
            return response()->json($return);
        }
    }
}
