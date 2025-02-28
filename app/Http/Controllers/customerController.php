<?php
namespace App\Http\Controllers;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
class customerController extends Controller
{
    // -------------- Note ----------------
    // the edit process is seperated in to 2 parts 1 is for editing customer information and 2 is for editing his tarifs 

    // list customers view
    public function customers(Request $request)
    {
        if ($request->isMethod('GET')) {
            $title = "Customers";
            $data = compact("title");
            return view("customers.customers")->with($data);
        }
        if ($request->isMethod('POST')) {
            $company_id = session('company_id');
            $start_date = $request->start_date;
            $end_date = $request->end_date;
            if(session('type') == '3')
            {
                $sales_person = session('emoloyee_id');
            }else{
                $sales_person = '';
            }
            $data = compact('company_id', 'start_date', 'end_date','sales_person');
            $result = json_decode(getAPIJson('customers/index', $data));

            $aaData = [];
            $i = 1;
            $resultsCount = 0;
            if ($result->status == 1) {
                $payload = $result->payload;
                $resultsCount = count($payload);
                foreach ($payload as $key => $row) {
                    $statusBadgeClass = $row->active == 1 ? ' badge-neutral-success text-success' : ' badge-neutral-danger text-danger';
                    $statusBadge = '<button table="customers" data-id="' . $row->id . '" data-status="' . ($row->active == 1 ? '0' : '1') . '" class="status_btn btn badge badge-pill ' . $statusBadgeClass . '">' . ($row->active == 1 ? 'Active' : 'Inactive') . '</button>';
                    $actions = '<div class="action-perform-btns">
                    <a style="color: #ba0c2f !important;" href="' . route('customer.add_edit_customer', ['id' => $row->id]) . '" class="" data-toggle="tooltip" title="Edit" odidcn="28"><img src="' . asset('assets/icons/Edit.svg') . '" width="15" alt="Edit"></a>
                <a table="customers" class="delete" style="color: #ba0c2f !important;" href="javascript:void(0);" data-id="' . $row->id . '" data-toggle="tooltip" title="Delete"><img src="' . asset('assets/icons/Delete.svg') . '" width="15" alt="Delete"></a>
            </div>';
                    $aaData[] = [
                        'SNO' => ++$key,
                        'ACNO' => $row->acno,
                        'NAME' => $row->name,
                        'EMAIL' => $row->email,
                        'PHONE' => $row->phone,
                        'ADDRESS' => Str::limit($row->address, 50, $end = '...'),
                        'BANK' => $row->bank,
                        'ACCTITLE' => $row->account_title,
                        'ACCNUMBER' => $row->account_number,
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
    // add and edit the customer
    public function add_edit_customer(Request $request, $id = null)
    { 
        get_all_banks();
        get_all_services();
        $countries = get_all_countries();
        if ($request->isMethod('GET')) {
            $check = check_company_status();
            if ($check != 1) {
                return redirect()->back()->with('error', 'Please complete your profile to proceed');
            }
            if ($id == null && $request->isMethod('GET')) {
                $title = "Add Customer";
                $type = "add";
                $param = ["company_id" => session('company_id')];
                $salespersons = getsalesPersons($param);
                $couriers = get_all_couriers();
                $data = compact("title", "type", "countries", "salespersons", "couriers");
                return view("customers.addCustomers")->with($data);
            } elseif ($id != null && $request->isMethod('GET')) {
                $title = "Edit Customer";
                $result = getAPIdata('customers/single', ['id' => $request->id]);
                $payload = $result->payload;

                $charges = getTarifs(['acno' => $payload->acno]);
                $param = ["company_id" => session('company_id')];
                $salespersons = getsalesPersons($param);
                $type = "edit";
                $countries = get_all_countries();
                $cities = get_all_cities();
                $data = compact('payload', 'type', 'title', 'salespersons', 'charges', 'countries', 'cities');
                return view('customers.editCustomers')->with($data);
            }
        }
        // to manage the insert and update function
        if ($request->isMethod('POST')) {
            // dr($request);
            $request->validate([
                "name" => "required|regex:/^[A-Za-z\s'-]+$/",
                "user_name" => "required",
                "phone" => "required|numeric",
                "email" => "required|email",
                "cnic" => "required|numeric",
                "address" => "required",
                "bank" => "required",
                "account_title" => "required",
                "account_number" => "required",
            ]);
            // for add
            if ($id == null && $request->isMethod('POST')) {
                $request->validate([
                    "password" => "required",
                    "tarif_service_name" => "required",
                    "region_type" => "required",
                    "start_weight" => "required",
                    "end_weight" => "required",
                    "charges" => "required",
                    "add_weight" => "required",
                    "add_charges" => "required",
                ]);
                $tarif_array = array();
                foreach ($request->tarif_service_name as $key => $tarifs) {
                    $tarif_array['tarif_charges'][] = [
                        "service_id" => isset($tarifs) ? $tarifs : '',
                        "region_type" => isset($request->region_type[$key]) ? $request->region_type[$key] : '',
                        "origin_country" => isset($request->origin_country[$key]) ? $request->origin_country[$key] : '',
                        "destination_country" => isset($request->destination_country[$key]) ? $request->destination_country[$key] : '',
                        "start_weight" => isset($request->start_weight[$key]) ? $request->start_weight[$key] : '',
                        "end_weight" => isset($request->end_weight[$key]) ? $request->end_weight[$key] : '',
                        "charges" => isset($request->charges[$key]) ? $request->charges[$key] : '',
                        "additional_weight" => isset($request->add_weight[$key]) && $request->add_weight[$key] != '' ? $request->add_weight[$key] : 0,
                        "additional_charges" => isset($request->add_charges[$key]) && $request->add_charges[$key] != '' ? $request->add_charges[$key] : 0,
                        "rto_charges" => isset($request->rto_charges[$key]) ? $request->rto_charges[$key] : '',
                        "additional_rto_charges" => isset($request->add_rto_charges[$key]) ? $request->add_rto_charges[$key] : '',
                    ];
                }
                if (isset($request->min_amt) && count($request->min_amt) > 0) {
                    foreach ($request->min_amt as $key => $min_amt) {
                        $tarif_array['handling_charges'][] = [
                            "min_amt" => isset($min_amt) ? $min_amt : 0,
                            "max_amt" => isset($request->max_amt[$key]) && $request->max_amt[$key] != '' ? $request->max_amt[$key] : 0,
                            "charges" => isset($request->handling_charges[$key]) && $request->handling_charges[$key] != '' ? $request->handling_charges[$key] : 0,
                            "deduction_type" => isset($request->handling_deduction[$key]) && $request->handling_deduction[$key] != '' ? $request->handling_deduction[$key] : '1',
                        ];
                    }
                }
                if (isset($request->additional_service_name) && count($request->additional_service_name) > 0) {
                    foreach ($request->additional_service_name as $key => $service_name) {
                        $tarif_array['additional_charges'][] = [
                            "service_id" => isset($service_name) ? $service_name : '',
                            "charges_type" => isset($request->add_charges_type[$key]) ? $request->add_charges_type[$key] : '0',
                            "charges_amt" => isset($request->add_charges_amt[$key]) && $request->add_charges_amt[$key] != '' ? $request->add_charges_amt[$key] : 0,
                            "deduction_type" => isset($request->additional_deduction[$key]) && $request->additional_deduction[$key] != '' ? $request->additional_deduction[$key] : '1',
                        ];
                    }
                }
                $data = $request->only([
                    'name',
                    'user_name',
                    'password',
                    'email',
                    'phone',
                    'ntn',
                    'cnic',
                    'address',
                    'other_name',
                    'other_phone',
                    'bank',
                    'business_name',
                    'business_address',
                    'account_title',
                    'account_number',
                    'sales_person_id',
                    'city_id',
                    'country_id',
                ]);
                $data['charges'] = $tarif_array;
                $data['service_assigned'] = implode(',', $request->service_assigned);
                $data['company_id'] = session('company_id');
                $data['token'] = $token = Str::random(25);
                $result = getAPIdata('customers/add', $data);
                if ($result->status == '1') {
                    $data = [
                        "co_name" => session('company_name'),
                        "user_name" => $request->user_name,
                        "password" => $request->password,
                    ];
                    $send_mail = app(emailController::class);
                    $send_mail->activation($request->email, $token . ':' . time() . '|' . base64_encode('customers'), '6', $data);
                }
                $return = ['status' => $result->status, 'message' => $result->payload];
                return response()->json($return);
            } elseif ($id != null && $request->isMethod('POST')) {
                // for edit only customer info
                $data = $request->only([
                    'name',
                    'email',
                    'phone',
                    'ntn',
                    'cnic',
                    'address',
                    'city_id',
                    'country_id',
                    'other_name',
                    'other_phone',
                    'business_name',
                    'business_address',
                    'bank',
                    'account_title',
                    'account_number',
                ]);
                if ($request->password) {
                    $request->validate([
                        "password" => "required"
                    ]);
                    $data['password'] = $request->password;
                }
                if ($request->case != 'profileUpdate') {
                    $data['sales_person_id'] = $request->sales_person_id;
                }
                // dd($request->user_name_old);
                if ($request->user_name !== $request->user_name_old) {
                    $data['user_name'] = $request->user_name;
                } else {
                    $data['user_name'] = "";
                }
                $data['id'] = $id;
                $data['service_assigned'] = implode(',', $request->service_assigned);

                $result = getAPIdata('customers/update', $data);
                $return = ['status' => $result->status, 'message' => $result->payload];
                return response()->json($return);
            }
        }

    }
    // for inserting seperately for edit page  
    public function insert_charges(Request $request)
    {
        $request->validate([
            "customer_acno" => "required",
        ]);
        // for tariff
        $tarif_array = array();
        if (isset($request->start_weight) && count($request->start_weight) > 0) {
            $request->validate([
                "region_type" => "required",
                "origin_country" => "required",
                "destination_country" => "required",
                "start_weight" => "required",
                "end_weight" => "required",
                "charges" => "required",
            ]);
            foreach ($request->start_weight as $key => $tarifs) {
                $tarif_array['tarif_charges'][] = [
                    "service_id" => isset($request->service_name[$key]) ? $request->service_name[$key] : '',
                    "region_type" => isset($request->region_type[$key]) ? $request->region_type[$key] : '',
                    "origin_country" => isset($request->origin_country[$key]) ? $request->origin_country[$key] : '',
                    "destination_country" => isset($request->destination_country[$key]) ? $request->destination_country[$key] : '',
                    "start_weight" => isset($request->start_weight[$key]) ? $request->start_weight[$key] : '',
                    "end_weight" => isset($request->end_weight[$key]) ? $request->end_weight[$key] : '',
                    "charges" => isset($request->charges[$key]) ? $request->charges[$key] : '',
                    "additional_weight" => isset($request->add_weight[$key]) && $request->add_weight[$key] != '' ? $request->add_weight[$key] : 0,
                    "additional_charges" => isset($request->add_charges[$key]) && $request->add_charges[$key] != '' ? $request->add_charges[$key] : 0,
                    "rto_charges" => isset($request->rto_charges[$key]) ? $request->rto_charges[$key] : '',
                    "additional_rto_charges" => isset($request->add_rto_charges[$key]) ? $request->add_rto_charges[$key] : '',
                ];
            }
        }
        // for cash handling
        if (isset($request->handling_charges) && count($request->handling_charges) > 0) {
            $request->validate([
                "min_amt" => "required",
                "max_amt" => "required",
                "handling_charges" => "required",
                "handling_deduction" => "required",
            ]);

            foreach ($request->min_amt as $key => $min_amt) {
                $tarif_array['handling_charges'][] = [
                    "min_amt" => isset($min_amt) && $min_amt != '' ? $min_amt : 0,
                    "max_amt" => isset($request->max_amt[$key]) && $request->max_amt[$key] != '' ? $request->max_amt[$key] : 0,
                    "charges" => isset($request->handling_charges[$key]) && $request->handling_charges[$key] != '' ? $request->handling_charges[$key] : 0,
                    "deduction_type" => isset($request->handling_deduction[$key]) && $request->handling_deduction[$key] != '' ? $request->handling_deduction[$key] : '1',
                ];
            }
        }
        // for additional
        if (isset($request->add_charges_type) && count($request->add_charges_type) > 0) {
            $request->validate([
                "add_charges_type" => "required",
                "add_charges_amt" => "required",
                "additional_deduction" => "required",
            ]);
            foreach ($request->additional_service_name as $key => $service_name) {
                $tarif_array['additional_charges'][] = [
                    "service_id" => isset($service_name) ? $service_name : '',
                    "charges_type" => isset($request->add_charges_type[$key]) ? $request->add_charges_type[$key] : '0',
                    "charges_amt" => isset($request->add_charges_amt[$key]) && $request->add_charges_amt[$key] != '' ? $request->add_charges_amt[$key] : 0,
                    "deduction_type" => isset($request->additional_deduction[$key]) && $request->additional_deduction[$key] != '' ? $request->additional_deduction[$key] : '1',
                ];
            }
        }
        
        if(count($tarif_array) > 0){
            $data['acno'] = $request->customer_acno;
            $data['charges'] = $tarif_array;
            $data['created_by'] = session('logged_id');
            $result = getAPIdata('customers/addCharges', $data);
            // $result = getAPIJson('customers/addCharges', $data);
            // dd($result);
            $return = ['status' => $result->status, 'message' => $result->message,'payload'=> $result->payload];
        }else{
            $return = ['status' => 0, 'message' => 'No data to insert','payload'=> []];
        }
        return response()->json($return);

    }
    public function update_tariff(Request $request)
    {
        $tarif_array = array();
        // for tariff
        if (isset($request->start_weight) && count($request->start_weight) > 0) {
            $request->validate([
                "service_name" => "required",
                "region_type" => "required",
                "start_weight" => "required",
                "end_weight" => "required",
                "charges" => "required",
            ]);
            foreach ($request->service_name as $key => $tarifs) {
                $tarif_array['tarif_charges'][] = [
                    "id" => isset($request->id[$key]) ? $request->id[$key] : '',
                    "service_id" => isset($tarifs) ? $tarifs : '',
                    "charges_type" => isset($request->charges_type[$key]) ? $request->charges_type[$key] : '',
                    "region_type" => isset($request->region_type[$key]) ? $request->region_type[$key] : '',
                    "origin_country" => isset($request->origin_country[$key]) ? $request->origin_country[$key] : '',
                    "destination_country" => isset($request->destination_country[$key]) ? $request->destination_country[$key] : '',
                    "start_weight" => isset($request->start_weight[$key]) ? $request->start_weight[$key] : '',
                    "end_weight" => isset($request->end_weight[$key]) ? $request->end_weight[$key] : '',
                    "charges" => isset($request->charges[$key]) ? $request->charges[$key] : '',
                    "additional_weight" => isset($request->add_weight[$key]) && $request->add_weight[$key] != '' ? $request->add_weight[$key] : 0,
                    "additional_charges" => isset($request->add_charges[$key]) && $request->add_charges[$key] != '' ? $request->add_charges[$key] : 0,
                    "rto_charges" => isset($request->rto_charges[$key]) ? $request->rto_charges[$key] : '',
                    "additional_rto_charges" => isset($request->add_rto_charges[$key]) ? $request->add_rto_charges[$key] : '',
                ];
            }
        }
        // for cash handling
        if (isset($request->handling_charges) && count($request->handling_charges) > 0) {
            $request->validate([
                "min_amt" => "required",
                "max_amt" => "required",
                "handling_charges" => "required",
                "checked_id" => "required",
            ]);
            foreach ($request->min_amt as $key => $min_amt) {
                $tarif_array['handling_charges'][] = [
                    "id" => isset($request->checked_id[$key]) ? $request->checked_id[$key] : '',
                    "min_amt" => isset($min_amt) && $min_amt != '' ? $min_amt : 0,
                    "max_amt" => isset($request->max_amt[$key]) && $request->max_amt[$key] != '' ? $request->max_amt[$key] : 0,
                    "charges" => isset($request->handling_charges[$key]) && $request->handling_charges[$key] != '' ? $request->handling_charges[$key] : 0,
                    "deduction_type" => isset($request->handling_deduction[$key]) && $request->handling_deduction[$key] != '' ? $request->handling_deduction[$key] : '1',
                ];
            }
        }
        // for additional
        if (isset($request->add_checked_id) && count($request->add_checked_id) > 0) {
            $request->validate([
                "service_name" => "required",
                "add_charges" => "required",
                "charges_amt" => "required",
                "additionl_deduction_type" => "required",
                "add_checked_id" => "required",
            ]);

            foreach ($request->service_name as $key => $service_name) {
                $tarif_array['additional_charges'][] = [
                    "id" => isset($request->add_checked_id[$key]) ? $request->add_checked_id[$key] : '0',
                    "service_id" => isset($service_name) ? $service_name : '',
                    "charges_type" => isset($request->add_charges[$key]) ? $request->add_charges[$key] : '0',
                    "charges_amt" => isset($request->charges_amt[$key]) && $request->charges_amt[$key] != '' ? $request->charges_amt[$key] : 0,
                    "deduction_type" => isset($request->additional_deduction[$key]) && $request->additional_deduction[$key] != '' ? $request->additional_deduction[$key] : '1',
                ];
            }

        }
        $result = getAPIdata('customers/updateCharges', ['customer_acno' => $request->customer_acno,'charges' => $tarif_array]);
        $return = ['status' => $result->status, 'message' => $result->message,'payload'=> $result->payload];
        return response()->json($return);

    }
    // sub accounts view 
    public function sub_accounts(Request $request)
    {
        if ($request->isMethod('GET')) {
            $title = "Sub Accounts";
            $data = compact("title");
            return view("customers.sub_accounts")->with($data);
        }
        if ($request->isMethod('POST')) {
            $company_id = session('company_id');
            $customer_acno = session('acno');
            $start_date = $request->start_date;
            $end_date = $request->end_date;
            $data = compact('company_id', 'customer_acno', 'start_date', 'end_date');
            $result = getAPIdata('customers/sub-accounts/index', $data);
            // $result = getAPIJson('customers/sub-accounts/index', $data);
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
                    $statusBadgeClass = ($row->active == 1) ? ' badge-neutral-success text-success' : ' badge-neutral-danger text-danger';
                    $statusBadge = '<button table="customers" data-id="' . $row->id . '" data-status="' . ($row->active == 1 ? '0' : '1') . '" class="status_btn btn badge badge-pill' . $statusBadgeClass . '">' . ($row->active == 1 ? 'Active' : 'Inactive') . '</button>';
                    $actions = '<div class="action-perform-btns">
                    <a style="color: #ba0c2f !important;" href="' . route('customer.add_edit_sub_account', ['id' => $row->acno]) . '" class="" data-toggle="tooltip" title="Edit"><img src="' . asset('assets/icons/Edit.svg') . '" width="15" alt="Edit"></a>
                <a table="customers" class="delete" style="color: #ba0c2f !important;" href="javascript:void(0);" data-id="' . $row->id . '" data-toggle="tooltip" title="Delete"><img src="' . asset('assets/icons/Delete.svg') . '" width="15" alt="Delete"></a>
            </div>';
                    $aaData[] = [
                        'SNO' => ++$key,
                        'ACCTITLE' => $row->account_title,
                        'NAME' => $row->name,
                        'EMAIL' => $row->email,
                        'PHONE' => $row->phone,
                        'ADDRESS' => Str::limit($row->address, 50, $end = '...'),
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
    public function add_edit_sub_account(Request $request, $id = null)
    {   // to manage the add and edit view page
        if (!session('banks')) {
            get_all_banks();
        }
        $countries = get_all_countries();
        if (!session('services')) {
            get_all_services();
        }
        if ($request->isMethod('GET')) {
            if ($id == null && $request->isMethod('GET')) {
                $title = "Add Sub Account";
                $type = "add";
                $data = compact("title", "type", "countries");
                return view("customers.add_sub_accounts")->with($data);
            } elseif ($id != null && $request->isMethod('GET')) {
                $cities = get_all_cities();
                $title = "Edit Sub Account";
                $acno = $request->id;
                $param_id = compact('acno');
                $result = getAPIdata('customers/sub-accounts/single', $param_id);
                $payload = $result->payload;
                $type = "edit";
                $data = compact('payload', 'cities', 'type', 'title', 'id', "countries");
                return view('customers.add_sub_accounts')->with($data);
            }
        }
        // to manage the insert and update function
        if ($request->isMethod('POST')) {
            // dr($request);
            $request->validate([
                "name" => "required",
                "user_name" => "required",
                "phone" => "required",
                "email" => "required|email",
                "address" => "required",
                "cnic" => "required",
                "ntn" => "required",
                "business_name" => "required",
                "country_id" => "required",
                "city_id" => "required",
            ]);
            // for add
            if ($id == null && $request->isMethod('POST')) {
                $request->validate([
                    "password" => "required",
                ]);
                $data = $request->only([
                    'name',
                    'user_name',
                    'phone',
                    'email',
                    'country_id',
                    'city_id',
                    'address',
                    'cnic',
                    'ntn',
                    'password',
                    'business_name',
                ]);
                $merged_array = array_merge($request->rights_main, $request->rights_sub);
                $merged_array = array_map('intval', $merged_array);
                $data['company_id'] = session('company_id');
                $data['customer_acno'] = session('acno');
                $data['token'] = $token = Str::random(25);
                $data['rights'] = json_encode($merged_array);
                // dd($data);
                $result = getAPIdata('customers/sub-accounts/add', $data);
                // $result = getAPIJson('customers/sub-accounts/add', $data);
                // dd($result);
                if ($result->status == '1') {
                    $data = [
                        "co_name" => session('company_name'),
                        "user_name" => $request->user_name,
                        "password" => $request->password,
                    ];
                    $send_mail = app(emailController::class);
                    $check = $send_mail->activation($request->email, $token . ':' . time() . '|' . base64_encode('customers'), '7', $data);
                }
                $return = ['status' => $result->status, 'message' => $result->message, 'payload' => $result->payload];
                return response()->json($return);
            } elseif ($id != null && $request->isMethod('POST')) {
                $data = $request->only([
                    'name',
                    'phone',
                    'email',
                    'business_name',
                    'country_id',
                    'city_id',
                    'cnic',
                    'ntn',
                    'address',
                    'password',
                ]);
                if ($request->password != '') {
                    $request->validate([
                        "password" => "required"
                    ]);
                    $data['password'] = $request->password;
                }

                if ($request->user_name != $request->old_user_name) {
                    $data['user_name'] = $request->user_name;
                } else {
                    $data['user_name'] = '';
                }
                if ((!empty($request->rights_main) && count($request->rights_main) > 0) && (!empty($request->rights_sub) && count($request->rights_sub) > 0)) {
                    $merged_array = array_merge($request->rights_main, $request->rights_sub);
                }else{
                    $return = ['status' => '0', 'message' => 'Select Sub Accounts Rights', 'payload' => []];
                    return response()->json($return);
                }
                $merged_array = array_map('intval', $merged_array);
                $data['company_id'] = session('company_id');
                $data['customer_acno'] = session('acno');
                $data['rights'] = json_encode($merged_array);
                $data['acno'] = $id;
                // dd($data);
                $result = getAPIdata('customers/sub-accounts/update', $data);
                // $result = getAPIJson('customers/sub-accounts/update', $data);
                // dd($result);
                $return = ['status' => $result->status, 'message' => $result->message, 'payload' => $result->payload];
                return response()->json($return);
            }
        }
    }
    public function sub_users(Request $request)
    {
        if ($request->isMethod('GET')) {
            $title = "Sub Users";
            $data = compact("title");
            return view("customers.sub_users")->with($data);
        }
        if ($request->isMethod('POST')) {
            $company_id = session('company_id');
            $customer_acno = session('acno');
            $start_date = $request->start_date;
            $end_date = $request->end_date;
            $data = compact('company_id', 'customer_acno', 'start_date', 'end_date');
            $result = getAPIdata('customers/sub-accounts/index', $data);
            // $result = getAPIJson('customers/sub-accounts/index', $data);
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
                    $statusBadgeClass = ($row->active == 1) ? ' badge-neutral-success text-success' : ' badge-neutral-danger text-danger';
                    $statusBadge = '<button table="customers" data-id="' . $row->id . '" data-status="' . ($row->active == 1 ? '0' : '1') . '" class="status_btn btn badge badge-pill' . $statusBadgeClass . '">' . ($row->active == 1 ? 'Active' : 'Inactive') . '</button>';
                    $actions = '<div class="action-perform-btns">
                    <a style="color: #ba0c2f !important;" href="' . route('customer.add_edit_sub_account', ['id' => $row->acno]) . '" class="" data-toggle="tooltip" title="Edit"><img src="' . asset('assets/icons/Edit.svg') . '" width="15" alt="Edit"></a>
                <a table="customers" class="delete" style="color: #ba0c2f !important;" href="javascript:void(0);" data-id="' . $row->id . '" data-toggle="tooltip" title="Delete"><img src="' . asset('assets/icons/Delete.svg') . '" width="15" alt="Delete"></a>
            </div>';
                    $aaData[] = [
                        'SNO' => ++$key,
                        'ACCTITLE' => $row->account_title,
                        'NAME' => $row->name,
                        'EMAIL' => $row->email,
                        'PHONE' => $row->phone,
                        'ADDRESS' => Str::limit($row->address, 50, $end = '...'),
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
    public function add_edit_sub_users(Request $request, $id = null)
    {   // to manage the add and edit view page
        if (!session('banks')) {
            get_all_banks();
        }
        $countries = get_all_countries();
        if (!session('services')) {
            get_all_services();
        }
        if ($request->isMethod('GET')) {
            if ($id == null && $request->isMethod('GET')) {
                $title = "Add Sub Account";
                $type = "add";
                $data = compact("title", "type", "countries");
                return view("customers.add_sub_accounts")->with($data);
            } elseif ($id != null && $request->isMethod('GET')) {
                $cities = get_all_cities();
                $title = "Edit Sub Account";
                $acno = $request->id;
                $param_id = compact('acno');
                $result = getAPIdata('customers/sub-accounts/single', $param_id);
                $payload = $result->payload;
                $type = "edit";
                $data = compact('payload', 'cities', 'type', 'title', 'id', "countries");
                return view('customers.add_sub_accounts')->with($data);
            }
        }
        // to manage the insert and update function
        if ($request->isMethod('POST')) {
            // dr($request);
            $request->validate([
                "name" => "required",
                "user_name" => "required",
                "phone" => "required",
                "email" => "required|email",
                "address" => "required",
                "cnic" => "required",
                "ntn" => "required",
                "business_name" => "required",
                "country_id" => "required",
                "city_id" => "required",
            ]);
            // for add
            if ($id == null && $request->isMethod('POST')) {
                $request->validate([
                    "password" => "required",
                ]);
                $data = $request->only([
                    'name',
                    'user_name',
                    'phone',
                    'email',
                    'country_id',
                    'city_id',
                    'address',
                    'cnic',
                    'ntn',
                    'password',
                    'business_name',
                ]);
                $merged_array = array_merge($request->rights_main, $request->rights_sub);
                $merged_array = array_map('intval', $merged_array);
                $data['company_id'] = session('company_id');
                $data['customer_acno'] = session('acno');
                $data['token'] = $token = Str::random(25);
                $data['rights'] = json_encode($merged_array);
                // dd($data);
                $result = getAPIdata('customers/sub-accounts/add', $data);
                // $result = getAPIJson('customers/sub-accounts/add', $data);
                // dd($result);
                if ($result->status == '1') {
                    $data = [
                        "co_name" => session('company_name'),
                        "user_name" => $request->user_name,
                        "password" => $request->password,
                    ];
                    $send_mail = app(emailController::class);
                    $send_mail->activation($request->email, $token . ':' . time() . '|' . base64_encode('customers'), '7', $data);
                }
                $return = ['status' => $result->status, 'message' => $result->message, 'payload' => $result->payload];
                return response()->json($return);
            } elseif ($id != null && $request->isMethod('POST')) {
                $data = $request->only([
                    'name',
                    'phone',
                    'email',
                    'business_name',
                    'country_id',
                    'city_id',
                    'cnic',
                    'ntn',
                    'address',
                    'password',
                ]);
                if ($request->password != '') {
                    $request->validate([
                        "password" => "required"
                    ]);
                    $data['password'] = $request->password;
                }

                if ($request->user_name != $request->old_user_name) {
                    $data['user_name'] = $request->user_name;
                } else {
                    $data['user_name'] = '';
                }
                $merged_array = array_merge($request->rights_main, $request->rights_sub);
                $merged_array = array_map('intval', $merged_array);
                $data['company_id'] = session('company_id');
                $data['customer_acno'] = session('acno');
                $data['rights'] = json_encode($merged_array);
                $data['acno'] = $id;
                // dd($data);
                $result = getAPIdata('customers/sub-accounts/update', $data);
                // $result = getAPIJson('customers/sub-accounts/update', $data);
                // dd($result);
                $return = ['status' => $result->status, 'message' => $result->message, 'payload' => $result->payload];
                return response()->json($return);
            }
        }
    }

}
