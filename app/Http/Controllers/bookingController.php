<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;

class bookingController extends Controller
{
    // list shipments view

    public function shipments(Request $request)
    {
        if ($request->isMethod('GET')) {
            $title = 'Bookings';
            $customers = $sub_accounts = [];
            if (!session('status')) {
                get_all_status();
            }
            if (is_ops()) {
                $customers_function = get_customers();
                $customers = $customers_function->original['payload'];
            }
            if (is_portal()) {
                $customers_function = get_customers_sub(session('acno'));
                $customers = $customers_function->original;
            }
            $cities = get_all_cities();
            $countries = get_all_countries();
            $data = compact('title', 'customers', 'cities', 'countries');
            return view('shipments.index')->with($data);
        }

        if ($request->isMethod('POST')) {
            $company_id = session('company_id');
            $start_date = $request->start_date;
            $end_date = $request->end_date;
            $destination_id = $request->destination_id;
            $country_id = $request->country_id;
            $status_id = $request->status_id;
            $employee_id = $customer_acno = null;
            if (is_portal() && $request->customer_acno == '') {
                $customer_acno = session('acno');
            }elseif (is_customer_sub()) {
                $customer_acno = session('acno');
            }elseif (session('type') == '3') {
                $employee_id = session('employee_id');
            }
            $data = compact('company_id', 'start_date', 'end_date', 'country_id', 'destination_id', 'status_id', 'customer_acno','employee_id');
            $result = getAPIdata('shipment/index', $data);
            $aaData = [];
            $i = 1;
            $resultsCount = 0;
            if ($result->status == 1) {
                $payload = $result->payload;
                $resultsCount = count($payload);
                // <a table="shipments" class="delete" style="color: #ba0c2f !important;" href="javascript:void(0);" data-id="' . $row->id . '" data-toggle="tooltip" title="Delete"><img src="' . asset('images/default/svg/delete.svg') . '" width="15" alt="Delete"></a>
                foreach ($payload as $key => $row) {
                    $status_class = ' badge-neutral-' . getStatusBadge($row->status) . ' text-' . getStatusBadge($row->status);
                    $statusBadge = '<button table="shipments" data-id="' . $row->id . '" data-status="' . ($row->active == 1 ? '0' : '1') . '" class="btn badge badge-pill' . $status_class . '">' . $row->status_name . '</button>';
                    $wrongCityBadge = '<button class="btn badge badge-pill badge-neutral-returned"  data-toggle="tooltip" title="'.$row->wrong_city.'">Wrong City</button>';
                    $wrongCountryBadge = '<button class="btn badge badge-pill badge-neutral-returned"  data-toggle="tooltip" title="Wrong Country">Wrong Country</button>';

                    $edit_btn = "";
                    if(is_portal() && in_array($row->status,['1','21']))
                    {
                        $edit_btn = '<a style="color: #ba0c2f !important;" href="' . route('admin.add_edit_bookings', ['id' => $row->id]) . '" class="" data-toggle="tooltip" title="Edit"><img src="' . asset('assets/icons/Edit.svg') . '" width="15" alt="Edit"></a>';                    
                    }
                    if(is_ops() && !in_array($row->status,['14','16','15']))
                    {
                        $edit_btn = '<a style="color: #ba0c2f !important;" href="' . route('admin.add_edit_bookings', ['id' => $row->id]) . '" class="" data-toggle="tooltip" title="Edit"><img src="' . asset('assets/icons/Edit.svg') . '" width="15" alt="Edit"></a>';                    
                    }
                    
                    $actions =
                        '<div class="action-perform-btns">

                  ' .
                        $edit_btn .
                        '

                    <a style="color: #ba0c2f !important;" target="_blank" href="' .
                        route('admin.cn_print', ['id' => base64_encode($row->consignment_no)]) .
                        '" class="" data-toggle="tooltip" title="Print"><img src="' .
                        asset('assets/icons/Print.svg') .
                        '" width="15" alt="Print"></a>

                    </div>';

                    $checkBox =
                        '<div class="custom-control custom-checkbox">

                    <input data-status="' .
                        $row->status .
                        '" type="checkbox" class="custom-control-input check_box" name="checked_id[]" data-customer-id="' .
                        $row->acno .
                        '" value="' .
                        $row->consignment_no .
                        '" id="customCheck' .
                        $key .
                        '">

                    <label class="custom-control-label" for="customCheck' .
                        $key .
                        '"></label>

                    </div>';
                    if (is_ops()) {
                        $account = $row->acno;
                        $tpl = $row->thirdparty_consignment_no ?? 'N/A'; // Add TPL only if in ops
                    } else {
                        $account = $row->account_no;
                        $tpl = null; // No TPL for non-ops
                    }

                    $aaData[] = [
                        'SNO' => '<div class="d-flex">'.$checkBox.' '.++$key.'</div>',
                        'CN' => $row->consignment_no,
                        'ACNO' => $account,
                        'BUSINESSNAME' => $row->business_name,
                        'TPL' => $tpl, // Set TPL based on condition
                        'NAME' => $row->consignee_name,
                        'EMAIL' => $row->consignee_email,
                        'PHONE' => $row->consignee_phone,
                        'SHIPREF' => $row->shipment_referance,
                        'DESTINATION' => ($row->destination_country == '450' ? $wrongCountryBadge : $row->country_name),
                        'DESCITY' => ($row->destination_city_id == '1317' ? $wrongCityBadge : $row->destination_city),
                        'ADDRESS' => $row->consignee_address,
                        'PARCELDET' => $row->parcel_detail,
                        'AMOUNT' => $row->orignal_order_amt,
                        'ORIGCODE' => $row->orignal_currency_code,
                        'CONVERTEDAMT' => $row->order_amount,
                        'CONVERTEDCODE' => $row->currency_code,
                        'PEICES' => $row->peices,
                        'WEIGHT' => $row->weight,
                        'BOOKEDAT' => Carbon::parse($row->created_at)->format('Y-m-d H:i A'),
                        'LASTSTATUSDATE' => Carbon::parse($row->last_status_date)->format('Y-m-d H:i A'),
                        'STATUS' => $statusBadge,
                        'ACTIONS' => $actions,

                    ];
                    $i++;
                    $resultsCount++;
                }
            }

            $arraylist = [
                'TotalRecords' => $resultsCount,
                'aaData' => $aaData,
            ];

          echo compressJson($arraylist);
        }
    }

  
    // for add and edit the manual_booking

    public function add_edit_bookings(Request $request, $id = null)
    {
        // to manage the add and edit view page

        if ($request->isMethod('GET')) {
            $countries = get_all_countries();

            $check = check_company_status();

            $currencies = get_currencies();

            get_all_services();

            if ($check != 1) {
                return redirect()->back()->with('error', 'Please complete your profile to proceed');
            }

            if ($id == null && $request->isMethod('GET')) {
                $title = 'Add Manual Booking';

                $type = 'add';

                if (is_ops()) {
                    $customers_function = get_customers();

                    $customers = $customers_function->original['payload'];
                } else {
                    $customers = [];
                }

                $data = compact('title', 'type', 'currencies', 'customers', 'countries');

                return view('shipments.addEditBooking')->with($data);
            } elseif ($id != null && $request->isMethod('GET')) {
                $title = 'Edit Manual Booking';
                $id = $request->id;
                get_all_banks();
                $cities = get_all_cities();
                $result = getAPIdata('shipment/single', ['id' => $id]);
                $payload = $result->payload;
                // if($payload->status == '1')
                // {
                    if (is_ops()) {
                        $customers_function = get_customers();
                        $customers = $customers_function->original['payload'];
                    } else {
                        $customers = [];
                    }
                    $param = ['company_id' => session('company_id'), 'customer_acno' => $payload->customer_acno];
                    $result = getAPIdata('pickupLocation/index', $param);
                    $pickup_locations = $result->payload;
                    $data = ['customer_acno' => $payload->customer_acno, 'type' => '6'];
                    $result = getAPIdata('common/getServices', $data);
                    $services = explode(',', $result[0]->service_id);
                    $type = 'edit';
                    $data = compact('payload', 'customers', 'type', 'title', 'cities', 'currencies', 'countries', 'pickup_locations', 'services');
                    
                    return view('shipments.addEditBooking')->with($data);
                // }else{
                //     return redirect()->back();
                // }
            }
        }

        // to manage the insert and update function

        if ($request->isMethod('POST')) {
            $request->validate([
                'account' => 'required',

                'shipment_ref' => 'required',

                'pickup_location' => 'required',

                'name' => "required",

                'phone' => 'required',

                'address' => 'required',

                'product_detail' => 'required',

                'peices' => 'required|numeric',

                'weight' => 'required|numeric',

                'fragile' => 'required',

                'insurance' => 'required',

                'base_currency' => 'required',
            ]);

            if ($id == null && $request->isMethod('POST')) {
                $data[] = [
                    'shipment_ref' => (string) $request->shipment_ref,

                    'pickup_location' => (string) $request->pickup_location,

                    'name' => (string) $request->name,

                    'email' => (string) $request->email,

                    'phone' => (string) $request->phone,

                    'address' => (string) $request->address,

                    'product_detail' => (string) $request->product_detail,

                    'order_amount' => (string) $request->order_amount,

                    'peices' => (string) $request->peices,

                    'weight' => (string) $request->weight,

                    'fragile' => (string) $request->fragile,

                    'insurance' => (string) $request->insurance,

                    'insurance_amt' => $request->insurance_amt,

                    'comments' => (string) $request->comments,

                    'service' => (string) $request->service_id,

                    'payment_method_id' => (string) $request->payment_method_id,

                    'destination_country' => (string) $request->country_id,

                    'destination_city' => (string) $request->destination,

                    'currency_code' => (string) $request->base_currency,
                ];

                if (is_customer_sub()) {
                    $customer_acno = session('acno');
                }

                if ($request->sub_account != null && $request->sub_account != '') {
                    $customer_acno = $request->sub_account;
                } else {
                    $customer_acno = $request->account;
                }

                $params = [
                    'company_id' => (int) session('company_id'),

                    'customer_acno' => (int) $customer_acno,

                    'device' => (string) '1',

                    'flag' => (string) 'Manual Booking',

                    'shipments' => $data,
                ];

                // print_r(json_encode($params));die;
                // $this->generate_log(session('acno') . '-add-', $params);
                $result = getAPIdata('shipment/add', $params);
                // dd($result);
                if ($result->status == 1) {
                    $return = ['status' => $result->status, 'message' => $result->message, 'payload' => 'Booking has been created succeessfully CN ' . $result->payload->success[0]->consignment_no];
                } else {
                   $errorMessage = isset($result->payload->error[0]->message) 
                    ? $result->payload->error[0]->message 
                    : 'Unstable network detected.';
                    $return = [
                        'status' => $result->status, 
                        'message' => $result->message, 
                        'payload' => $errorMessage
                    ];
                }

                return response()->json($return);
            } elseif ($id != null && $request->isMethod('POST')) {
              
                $data = $request->only(['cn_number','shipment_ref', 'pickup_location', 'payment_method_id', 'name', 'email', 'phone', 'address', 'destination', 'product_detail', 'order_amount', 'peices', 'weight', 'fragile', 'insurance', 'insurance_amt', 'comments', 'service_id']);

                $data['id'] = $id;

                $data['destination_country'] = $request->country_id;

                $data['currency_code'] = $request->base_currency;

                if (is_customer_sub()) {
                    $data['customer_acno'] = session('logged_id');
                }

                if ($request->sub_account != null && $request->sub_account != '') {
                    $data['customer_acno'] = $request->sub_account;
                } else {
                    $data['customer_acno'] = $request->account;
                }

                $result = getAPIdata('shipment/update', $data);

                $return = ['status' => $result->status, 'message' => $result->message, 'payload' => $result->payload];

                return response()->json($return);
            }
        }
    }

    // bulk booking

    public function bulk_booking()
    {
        get_all_services();

        get_all_cities();

        $sub_accounts = [];

        if (session('type') === '6') {
            $fetch_sub_acc = get_customers_sub(session('acno'));

            $sub_accounts = $fetch_sub_acc->original;
        }

        $title = 'Bulk Order Booking';

        $data = compact('title', 'sub_accounts');

        return view('shipments.bulkuploading')->with($data);
    }

    public function upload_bulk_file(Request $request)
    {
        $customer_acno = session('acno');

        $file = $request->file('file');

        $data = Excel::toArray([], $file);

        $error_array = [];

        $headerRow = $data[0][0];

        $excelData = array_filter(array_slice($data[0], 1), function ($row) {
            return array_filter(array_map('trim', $row));
        });
        $cities = get_all_cities();
        $columns = ['name', 'email', 'phone', 'address', 'destination_city', 'shipment_ref', 'product_detail', 'order_amount', 'peices', 'weight', 'comment', 'fragile', 'insurance', 'payment_method_id', 'pickup_location', 'service', 'currency_code'];

        // Check headers match expected columns

        if (array_diff($columns, $headerRow)) {
            return response()->json(['status' => '0', 'message' => 'Fatal Error Incomplete excel columns']);
        }

        // Preload city data into a collection for faster lookups

        $cities_collection = collect($cities)->keyBy('city');

        $final_data = [];

        foreach ($excelData as $row) {
            $newRow = [];

            foreach ($headerRow as $index => $key) {
                if (in_array($key, $columns)) {
                    if ($key == 'email') {
                        $newRow[$key] = (string) trim($row[$index] ?? 'demo@demo.com');
                    }
                    if ($key == 'comment') {
                        $newRow[$key] = (string) trim($row[$index] ?? '');
                    }
                    if ($key == 'order_amount') {
                        $newRow[$key] = (string) trim($row[$index] ?? '0.00');
                    } elseif (!empty($row[$index])) {
                        $newRow[$key] = (string) trim($row[$index]);
                    } else {
                        return response()->json(['status' => '0', 'message' => "Please provide complete data in the $key column"]);
                    }
                } else {
                    return response()->json(['status' => '0', 'message' => 'Please provide complete data in excel']);
                }
            }

            $country = $cities_collection->get($newRow['destination_city']);

            if ($country) {
                $newRow['destination_country'] = (string) $country->country_id;

                $newRow['service_id'] = (string) $newRow['service'];

                $final_data[] = $newRow;
            } else {
                $error_array[$newRow['shipment_ref']] = [
                    'message' => 'destination city not found',

                    'name' => $newRow['name'],

                    'email' => $newRow['email'],

                    'address' => $newRow['address'],

                    'phone' => $newRow['phone'],

                    'order_amount' => $newRow['order_amount'],

                    'shipment_ref' => $newRow['shipment_ref'],

                    'peices' => $newRow['peices'],

                    'weight' => $newRow['weight'],

                    'comment' => $newRow['comment'],

                    'insurance' => $newRow['insurance'],

                    'product_detail' => $newRow['product_detail'],

                    'fragile' => $newRow['fragile'],

                    'payment_method_id' => $newRow['payment_method_id'],

                    'pickup_location' => $newRow['pickup_location'],

                    'service' => $newRow['service'],

                    'currency_code' => $newRow['currency_code'],
                ];
            }
        }

        $params = [
            'company_id' => (int) session('company_id'),

            'customer_acno' => (int) $customer_acno,

            'device' => (string) '1',

            'flag' => (string) 'Bulk Uploading',

            'shipments' => $final_data,
        ];
        // $this->generate_log('Bulk-Upload' . session('acno'), $params);
        $result = getAPIdata('shipment/add', $params);
        $response = $this->process_api_response($result, $final_data, $customer_acno, $error_array);
        return response()->json($response);
    }

    private function process_api_response($result, $final_data, $customer_acno, $error_array)
    {
        $success_array = [];

        $execel_final_data = collect($final_data)->keyBy('shipment_ref');

        if ($result->status === 1) {
            foreach ($result->payload->success as $item) {
                $shipmentRef = $item->shipment_ref;

                if (isset($execel_final_data[$shipmentRef])) {
                    $success_array[] = array_merge($execel_final_data[$shipmentRef], [
                        'message' => $item->message,

                        'cn_no' => $item->consignment_no,
                    ]);
                }
            }

            foreach ($result->payload->error as $item) {
                $shipmentRef = $item->shipment_ref;

                if (isset($execel_final_data[$shipmentRef])) {
                    $error_array[] = array_merge($execel_final_data[$shipmentRef], ['message' => $item->message]);
                }
            }
        }

        if ($result->status == '0') {
            // dd($result->payload);
            foreach ($result->payload->error as $item) {
                $shipmentRef = $item->shipment_ref;

                if (isset($execel_final_data[$shipmentRef])) {
                    $error_array[] = array_merge($execel_final_data[$shipmentRef], ['message' => $item->message]);
                }
            }
        }

        $err_html = $this->generate_error_html($error_array, $customer_acno);

        $success_html = $this->generate_success_html($success_array);

        return [
            'status' => $result->status,

            'message' => $result->message,

            'success_html' => $success_html,

            'error_html' => $err_html,
        ];
    }

    private function generate_error_html($error_array, $customer_acno)
    {
        $cities = get_all_cities();
        $err_html = '';
        $pickup_param = ['company_id' => session('company_id'), 'customer_acno' => $customer_acno];
        $pickups = getAPIdata('pickupLocation/index', $pickup_param);
        foreach ($error_array as $i => $data) {
            $err_html .=
                '
                <tr>
                    <td>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input re-upload-check" name="checked_id[]" data-customer-id="' .
                $customer_acno .
                '" value="" id="customCheck' .
                $i .
                '">

                            <label class="custom-control-label" data-toggle="tooltip" title="Check to re-upload" for="customCheck' .
                $i .
                '"></label>

                        </div>

                    </td>

                    <td><span style="width:600px">' .
                $data['message'] .
                '</span></td>

                    <td>' .
                $data['name'] .
                '</td>

                    <td>' .
                $data['email'] .
                '</td>

                    <td>' .
                $data['address'] .
                '</td>

                    <td>' .
                $data['phone'] .
                '</td>

                    <td>';

            if ($data['message'] === 'destination city not found') {
                $err_html .= '<select

                        class="form-control form-select country_id form-control-lg input_field"

                        id="" data-toggle="select2" style="width:250px !important;" name="destination_city"

                        size="1" label="Select Destination"

                        data-placeholder="Select Destination" data-allow-clear="1">

                        <option value="">Select Destination</option>';

                foreach ($cities as $city) {
                    $err_html .=
                        '

                                <option value="' .
                        $city->id .
                        '">' .
                        $city->city .
                        '</option>';
                }

                $err_html .= '</select>';
            } else {
                $err_html .= $data['destination_city'];
            }

            $err_html .=
                '

                    </td>

                    <td>

                    <input style="width:200px;" data-parsley-validate="number"

                    class="form-control form-control-lg" id="shipment_ref' .
                $i .
                '"

                    name="shipment_ref" placeholder="Enter Shipment Ref" value="' .
                $data['shipment_ref'] .
                '"></td>

                    <td>' .
                $data['order_amount'] .
                '</td>

                    <td>' .
                ($data['message'] === 'weight or peices not found'
                    ? '<input style="width:200px;" data-parsley-validate="number"

                    class="form-control form-control-lg" id="peices' .
                        $i .
                        '"

                    name="peices" placeholder="Enter Peices" value="' .
                        $data['peices'] .
                        '">'
                    : $data['peices']) .
                '</td>

                    <td>' .
                ($data['message'] === 'weight or peices not found'
                    ? '<input style="width:200px;" data-parsley-validate="number"

                    class="form-control form-control-lg" id="weight' .
                        $i .
                        '"

                    name="weight" placeholder="Enter Weight" value="' .
                        $data['weight'] .
                        '">'
                    : $data['weight']) .
                '</td>

                    <td>' .
                $data['comment'] .
                '</td>

                    <td>' .
                $data['insurance'] .
                '</td>

                    <td>' .
                $data['fragile'] .
                '</td>

                    <td>' .
                $data['product_detail'] .
                '</td>

                    <td>' .
                ($data['payment_method_id'] == '1' ? 'COD' : 'CC') .
                '</td>

                    <td style="display:none">' .
                $data['pickup_location'] .
                '</td>

                    <td>';

            if ($data['message'] === 'service not found') {
                $err_html .= '<select

                            class="form-control form-select service form-control-lg"

                            id="" data-toggle="select2" style="width:250px !important;" name="service"

                            size="1" label="Select Service"

                            data-placeholder="Select Service" data-allow-clear="1">

                            <option value="">Select Service</option>';

                foreach (session('services') as $service) {
                    $err_html .=
                        '

                                    <option value="' .
                        $service->id .
                        '">' .
                        $service->service_name .
                        '</option>';
                }

                $err_html .= '</select>';
            } else {
                $err_html .= $data['service'];
            }

            $err_html .=
                '

                </td>

                <td>' .
                $data['currency_code'] .
                '</td>

                <td>';

            $err_html .= '<select

                            class="form-control form-select Pickup form-control-lg"

                            id="" data-toggle="select2" style="width:250px !important;" name="pickup_location"

                            size="1" label="Select Pickup"

                            data-placeholder="Select Pickup" data-allow-clear="1">

                            <option value="">Select Pickup</option>';

            foreach ($pickups->payload as $pickup) {
                $err_html .= '<option  ' . (isset($data['pickup_location']) && $data['pickup_location'] == $pickup->id ? 'selected' : '') . ' value="' . $pickup->id . '">' . $pickup->title . '</option>';
            }

            $err_html .= '</select>';

            $err_html .= '</td>

                </tr>';
        }
        return $err_html;
    }
    private function generate_success_html($success_array)
    {
        $success_html = '';
        foreach ($success_array as $data) {
            $success_html .=
                '
                            <tr>
                                <td>' .
                $data['cn_no'] .
                '</td>

                                <td>' .
                $data['name'] .
                '</td>

                                <td>' .
                $data['email'] .
                '</td>

                                <td>' .
                $data['address'] .
                '</td>

                                <td>' .
                $data['phone'] .
                '</td>

                                <td>' .
                $data['destination_city'] .
                '</td>

                                <td>' .
                $data['shipment_ref'] .
                '</td>

                                <td>' .
                $data['order_amount'] .
                '</td>

                                <td>' .
                $data['peices'] .
                '</td>

                                <td>' .
                $data['weight'] .
                '</td>

                                <td><a style="color: #ba0c2f !important;" target="_blank" href="' .
                route('admin.cn_print', ['id' => base64_encode($data['cn_no'])]) .
                '" class="" data-toggle="tooltip" title="Print"><img src="' .
                asset('images/default/svg/print.svg') .
                '" width="15" alt="Print"></td>

                            </tr>';
        }

        return $success_html;
    }

    private function generate_log($file_name, $data)
    {
        $logFile = 'logs/' . $file_name . '.txt';
        $logData = json_encode($data);

        Storage::append($logFile, $logData);
    }

    public function cancle_cn(Request $request)
    {
        $request->validate([
            'cn_no' => 'required',
        ]);

        $cn_numbers = $request->cn_no;

        $cn_numbers_array = explode(',', $cn_numbers);

        $cleaned_cn_numbers_array = array_map(function ($cn_number) {
            return preg_replace('/[^0-9]/', '', $cn_number);
        }, $cn_numbers_array);

        $consignment_no = array_filter($cleaned_cn_numbers_array);

        $params = compact('consignment_no');

        $result = getAPIdata('shipment/cancle', $params);

        $return = ['status' => $result->status, 'message' => $result->message, 'payload' => $result->payload];

        return response()->json($return);
    }

    public function push_orders(Request $request)
    {
        foreach ($request->data as $key => $value) {
            $data = [
                'shipment_ref' => (string) $value['shipment_ref'],

                'pickup_location' => (string) $value['pickup_location'],

                'name' => (string) $value['name'],

                'email' => (string) $value['email'],

                'phone' => (string) $value['phone'],

                'address' => (string) $value['address'],

                'product_detail' => (string) $value['product_detail'],

                'currency_code' => (string) $value['currency_code'],

                'order_amount' => (string) $value['order_amount'],

                'payment_method_id' => (string) $value['payment_method_id'],

                'peices' => (string) $value['peices'],

                'weight' => (string) $value['weight'],

                'fragile' => (string) $value['fragile'],

                'insurance' => (string) $value['insurance'],

                'comments' => (string) $value['comments'],
            ];
            $matchedService = null;
            foreach (session('services') as $service) {
                if ($service->service_code == $value['service'] || $service->id == $value['service']) {
                    $matchedService = $service->id;
                    break;
                }
            }
            $matchedCity = null;
            $cities = get_all_cities();
            foreach ($cities as $city) {
                if ($city->city == $value['destination'] || $city->id == $value['destination']) {
                    $matchedCity = $city->id;

                    break;
                }
            }
            $data['service'] = (string) $matchedService;
            $data['service_id'] = (string)$matchedService;
            $data['destination_city'] = (string)$matchedCity;
            $final[] = $data;
        }

        $params = [
            'company_id' => (int) session('company_id'),
            'customer_acno' => (int) session('acno'),
            'device' => (string) '1',
            'flag' => (string) 'Pushed Bulk',
            'shipments' => $final,
        ];
        // $this->generate_log('Pushed' . session('acno'), $params);
        $result = getAPIdata('shipment/add', $params);
        $final_data = [];
        $error_array = [];
        $success_array = [];
        foreach ($final as $item) {
            $final_data[$item['shipment_ref']] = $item;
        }
        if ($result->status === 0) {
            foreach ($result->payload->error as $item) {
                $shipmentRef = $item->shipment_ref;

                if (isset($final_data[$shipmentRef])) {
                    $error_array[] = array_merge($final_data[$shipmentRef], ['message' => $item->message]);
                }
            }
        }
        if ($result->status === 1) {
            foreach ($result->payload->success as $item2) {
                $shipmentRef = $item2->shipment_ref;

                if (isset($final_data[$shipmentRef])) {
                    $success_array[] = array_merge($final_data[$shipmentRef], ['cn_no' => $item2->consignment_no, 'message' => $item2->message]);
                }
            }

            foreach ($result->payload->error as $item3) {
                $shipmentRef = $item3->shipment_ref;

                if (isset($final_data[$shipmentRef])) {
                    $error_array[] = array_merge($final_data[$shipmentRef], ['message' => $item3->message]);
                }
            }
        }
        $err_html = '';
        $success_html = '';
        if (count($error_array) > 0) {
            $i = 1;
            foreach ($error_array as $key => $data) {
                $err_html .=
                    '
                <tr>
                    <td>' .
                    $i++ .
                    '</td>

                    <td>' .
                    $data['shipment_ref'] .
                    '</td>

                    <td>' .
                    $data['message'] .
                    '</td>

                </tr>';

                $i++;
            }
        }

        if (count($success_array) > 0) {
            $i = 1;

            foreach ($success_array as $key => $data) {
                $success_html .=
                    '

                <tr>

                    <td>' .
                    $i++ .
                    '</td>

                    <td>' .
                    $data['shipment_ref'] .
                    '</td>

                    <td>' .
                    $data['cn_no'] .
                    '</td>

                    <td>' .
                    $data['message'] .
                    '</td>

                </tr>';

                $i++;
            }
        }

        $return = ['status' => $result->status, 'message' => $result->message, 'success_html' => $success_html, 'error_html' => $err_html];

        // dd($return);

        return response()->json($return);
    }
}
