<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class thirdPartyController extends Controller
{
    protected function country_name($country_id)
    {
        $countries = get_all_countries();
        $filtered_country = array_filter($countries, function ($country) use ($country_id) {
            return $country->id == $country_id;
        });
        $filtered_country = reset($filtered_country);
        return $filtered_country->country_name;
    }
    // rules
    public function rules()
    {
        $title = "Rules";
        $couriers = get_all_couriers();
        $customers = get_customers();
        $customers = $customers->original['payload'];
        $cities = get_all_cities();
        $countries = get_all_countries();
        $company_id = session('company_id');
        $param = compact('company_id');
        $result = getAPIdata('couriers_details/index', $param);
        $accounts = $result;
        $rules = getAPIdata('rules/index', $param);
        $data = compact("title", "couriers", "customers", "accounts", "rules", "cities", "countries");
        return view("single_page_modules.rules")->with($data);
    }

    public function add_rule(Request $request)
    {
        $request->validate([
            "courier_acc_id" => "required",
            "service_id" => "required",
        ]);
        $company_id = session('company_id');
        $customer_acno = isset($request->customer_acno) ? $request->customer_acno : "";
        $rule_title = $request->rule_title;
        $rules_status = $request->rules_status;
        $pickup_id = $request->pickup_id;
        $customer_courier_id = $request->courier_acc_id;
        $data = ['account_id' => $customer_courier_id];

        $result = getAPIdata('couriers_details/single', $data);
        $courier_id = $result->payload->courier_id;
        $service_code = $request->service_id;

        $weight_type = isset($request->weight_type) ? $request->weight_type : "";
        $weight_value = isset($request->weight_value) ? $request->weight_value : "";
        $payment_method_id = isset($request->paymentmethod_id) ? $request->paymentmethod_id : "";
        $destination_city_id = isset($request->rules_cities) ? $request->rules_cities : "";
        $destination_country = isset($request->rules_countries) ? $request->rules_countries : "";
        $order_type = ($request->order_type !== "undefined") ? $request->order_type : "";
        $order_value = isset($request->order_value) ? $request->order_value : "";

        $data = [
            "company_id" => (int) $company_id,
            "customer_acno" => (int) $customer_acno,
            "rule_title" => (string) $rule_title,
            "status_ids" => (int) $rules_status,
            "weight_type" => (string) $weight_type,
            "weight_value" => (int) $weight_value,
            "payment_method_id" => (string) $payment_method_id,
            "destination_city_id" => (int) $destination_city_id,
            "destination_country" => (int) $destination_country,
            "order_type" => (string) $order_type,
            "order_value" => (string) $order_value,
            "courier_id" => (int) $courier_id,
            "customer_courier_id" => (int) $customer_courier_id,
            "pickup_id" => (int) $pickup_id,
            "service_code" => $service_code
        ];
        $result = getAPIdata('rules/add', $data);
        // $result = getAPIJson('rules/add', $data);
        // dd($result);
        $return = ['status' => $result->status, 'message' => $result->message, 'payload' => $result->payload];
        return response()->json($return);
    }
    public function update_rule(Request $request)
    {
        // dr($request);
        $company_id = session('company_id');
        $customer_acno = isset($request->customer_acno) ? $request->customer_acno : "";
        $rule_id = $request->ruleid;
        $rule_title = $request->rule_title;
        $courier_id = $request->courier_id;
        $customer_courier_id = $request->customer_courier_id;
        $pickup_id = $request->pickup_id;
        $service_code = $request->service_code;
        $status = $request->status;

        $data = [
            "company_id" => $company_id,
            "customer_acno" => (string) $customer_acno,
            "rule_id" => (string) $rule_id,
            "rule_title" => (string) $rule_title,
            "courier_id" => (int) $courier_id,
            "customer_courier_id" => (int) $customer_courier_id,
            "pickup_id" => (int) $pickup_id,
            "service_code" => $service_code,
            "status" => $status,
        ];
        $result = getAPIdata('rules/update', $data);
        // $result = getAPIJson('rules/update', $data);
        // dd($result);
        $return = ['status' => $result->status, 'message' => $result->message, 'payload' => $result->payload];
        return response()->json($return);
    }
    public function get_selected_service(Request $request)
    {
        $request->validate([
            'courier_id' => 'int|nullable'
        ]);
        $courier_id = $request->courier_id;
        $data = ['account_id' => $courier_id];
        $result = getAPIdata('tpl/courier-services', $data);
        return $result->payload;
    }
    // third party auto manual
    public function tpl_manual()
    {
        $result = getAPIdata('tpl/auto/tfm_status_cron', ['test' => 'test']);
        $title = "TPL Manual";
        $customer_array = get_customers();
        $customers = $customer_array->original['payload'];
        $company_id = session('company_id');
        $param = compact('company_id');
        $result = getAPIdata('couriers_details/index', $param);
        $accounts = $result;
        $data = compact("title", "accounts", "customers");
        return view("single_page_modules.list-tpl")->with($data);
    }

    public function list_tpl_manual(Request $request)
    {
        // dr($request);
        $company_id = session('company_id');
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $third_party = $request->third_party;
        $courier_id = $request->courier_id;
        $customer_acno = $request->customer_acno;
        $data = compact('company_id', 'start_date', 'end_date', 'third_party', 'courier_id', 'customer_acno');
        $result = getAPIdata('tpl/manual/index', $data);
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
                $statusBadge = '<button table="" data-id="' . $row->id . '" data-status="' . ($row->active == 1 ? '0' : '1') . '" class="btn badge badge-pill ' . $statusBadgeClass . '">' . $row->status_name . '</button>';
                $actions = '';
                $checkBox = "";
                if ($row->thirdparty_consignment_no != "") {
                    $url = route('admin.tpl_cn_print', [
                        'courier_id' => $row->courier_id,
                        'account_id' => $row->account_id,
                        'cn_number' => $row->thirdparty_consignment_no
                    ]);
                   $actions .= '
                    <div class="action-perform-btns">';
                        if($row->courier_id != '24')
                        {
                            $actions .= '<a style="color: #ba0c2f !important;" href="' . $url . '" 
                                target="_blank"
                                data-courier-id="' . $row->courier_id . '"  
                                data-courier-account-id="' . $row->account_id . '" 
                                data-cn="' . $row->thirdparty_consignment_no . '" 
                                data-route="' . $url . '" 
                                data-toggle="tooltip" 
                                title="Print">
                                <img src="' . asset('images/default/svg/print.svg') . '" width="15" alt="Print">
                            </a>';
                        }
                        $actions .= '<a type="button" style="color: #ba0c2f !important;" 
                            href="javascript:void(0);" 
                            data-courier-id="' . $row->courier_id . '" 
                            data-courier-account-id="' . $row->account_id . '" 
                            data-tpl-cn="' . $row->thirdparty_consignment_no . '" 
                            data-cn="' . $row->consignment_no . '" 
                            data-route="' . route('admin.tpl_cn_track') . '" 
                            class="single-track" data-toggle="tooltip" title="Track">
                            <i class="text-primary fa-solid fa-location-crosshairs fa-lg"></i>
                        </a>';
                     $actions .= '</div>';

                    $checkBox = '<div class="custom-control custom-checkbox my-3">
                    <input type="checkbox" class="custom-control-input check_box" name="checked_id[]" data-type="others" data-courier-account-id="' . $row->account_id . '" data-courier-id="' . $row->courier_id . '" value="' . $row->thirdparty_consignment_no . '" id="customCheck' . $key . '">
                    <label class="custom-control-label" for="customCheck' . $key . '"></label>
                    </div>';
                } else {
                    $actions = '<div class="action-perform-btns">
                        <a type="button" style="color:white !important" href="javascript:void(0);" ' . ($row->status == 14 ? "disabled" : "") . ' data-check-id="customCheck' . $key . '" class="btn-sm ' . ($row->status == 14 ? "btn-secondary" : "btn-primary cn_create btn") . ' " data-toggle="tooltip" title="' . ($row->status == 14 ? "Shipment is delivered" : "Create") . '">' . ($row->status == 14 ? "Shipment is delivered" : "Create") . '</button>
                </div>';
                    $checkBox = '<div class="custom-control custom-checkbox my-3">
                    <input type="checkbox" class="custom-control-input ' . ($row->status == 14 ? "" : "check_box") . '" data-type="creation" ' . ($row->status == 14 ? "disabled" : "") . ' name="checked_id[]" value="' . $row->consignment_no . '" id="customCheck' . $key . '">
                    <label class="custom-control-label" data-toggle="tooltip" title="' . ($row->status == 14 ? "Shipment is delivered" : "Check To Send") . '" for="customCheck' . $key . '"></label>
                </div>';
                }
                $aaData[] = [
                    'CHECK' => $checkBox,
                    'SNO' => ++$key,
                    'COURIER' => ($row->thirdparty_consignment_no != '' ? ($row->courier_id == '22' ? 'TFM' : 'SHIPA') : 'N/A' ),
                    'CN' => $row->consignment_no,
                    'TPL' => ($row->thirdparty_consignment_no != '' ? $row->thirdparty_consignment_no : 'N/A'),
                    'NAME' => $row->consignee_name,
                    'PHONE' => $row->consignee_phone,
                    'SHIPREF' => $row->shipment_referance,
                    'ADDRESS' => $row->consignee_address,
                    'COUNTRY' => country_name($row->destination_country),
                    'PARCELDET' => $row->parcel_detail,
                    'AMOUNT' => $row->order_amount,
                    'PEICES' => $row->peices,
                    'WEIGHT' => $row->weight,
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
        echo compressJson($arraylist);
    }
    public function get_tpl_selected(Request $request)
    {
        $cn_numbers = implode(",", $request->cn_numbers);
        $company_id = session('company_id');
        $type = "selected_cns";
        $param = compact('company_id', 'cn_numbers', 'type');
        $result = getAPIdata('tpl/manual/index', $param);
        if ($result->status == 1) {
            $payload = $result->payload;
            $i = 1;
            $html = '';
            $form = '';
            foreach ($payload as $key => $row) {
                // dd($row);
                $html .= '
                <tr>
                    <td>' . $row->consignment_no . '</td>
                    <td>' . $row->consignee_name . '</td>
                    <td>' . $row->shipment_referance . '</td>
                    <td>' . $row->destination_city . '</td>
                    <td>' . ($row->weight_charged == '' ? '-' : $row->weight_charged) . '</td>
                    <td>' . $row->orignal_currency_code . '</td>
                    <td>' . $row->orignal_order_amt . '</td>
                    <td> <a class="rem_row" style="color: #ba0c2f !important;" href="javascript:void(0);" data-bs-toggle="tooltip" data-id="' . $row->consignment_no . '" data-bs-placement="top" title="Delete"><img src="' . asset('images/default/svg/delete.svg') . '" width="15" alt="Delete" ></a></td>
                </tr>
                ';
            }
            $return = ['status' => '1', 'html' => $html];
        } else {
            $return = ['status' => $result->status, 'message' => $result->message, 'payload' => $result->payload];
        }
        return response()->json($return);
        // dd($result);
    }
    public function add_manual_tpl(Request $request)
    {
        $request->validate([
            'courier_acc_id' => 'required',
            'type_id' => 'required',
            'insurance' => 'required',
            'fragile' => 'required',
            'service_code' => 'required'
        ]);
        $courier_acc_id = $request->courier_acc_id;
        $courier_id = $request->courier_id;
        $type_id = $request->type_id;
        $insurance = $request->insurance;
        $fragile = $request->fragile;
        $service_code = $request->service_code;
        $cn_numbers = explode(',', $request->cn_numbers);
        $courier_code = $request->courier_code;

        $payload = array(
            'courier_id' => $courier_id,
            'courier_code' => $courier_code,
            'customer_courier_id' => $courier_acc_id,
            'parcel_type' => $type_id,
            'service_code' => $service_code,
            'fragile_require' => $fragile,
            'insurance_require' => $insurance,
            'insurance_value' => '0',
            'consignment_no' => [],
        );
        foreach ($cn_numbers as $index => $cn_number) {
            $payload['consignment_no'][$index] = $cn_number;
        }
        $result = getAPIdata('tpl/createThirdParty', $payload);
        if (count($result->payload->error) == 0) {
            $return = ['status' => $result->status, 'error_array' => [], 'success_array' => $result->payload->success];
        } else {
            $return = ['status' => $result->status, 'error_array' => $result->payload->error, 'success_array' => $result->payload->success];
        }
        return response()->json($return);
    }

    public function cn_void(Request $request)
    {
        $void_data = [];
        foreach ($request->values as $data) {

            $void_data[] = [
                "courier_id" => $data['courier_id'],
                "account_id" => $data['account_id'],
                "tpl_consigment_no" => $data['tpl_consignment']
            ];
        }

        if (count($void_data) > 0) {
            $result = getAPIdata('tpl/apply_void', ["void_data" => $void_data]);
            // $result = getAPIJson('tpl/apply_void', ["void_data"=>$void_data]);
            // dd($result);
            $return = ['status' => $result->status, 'message' => $result->payload];
        }
        return response()->json($return);
    }

    public function cn_print($courier_id, $account_id, $cn_number)
    {
        $courier_account_id = $account_id;
        $result = getAPIdata('tpl/print', compact('courier_id', 'courier_account_id', 'cn_number'));
        if ($result->payload != null) {
            if ($result->payload->type == 'text') {
                $content = $result->payload->content;
                $base64Content = str_replace('data:application/pdf;base64,', '', $content);
                $pdfContent = base64_decode($base64Content);
                return response($pdfContent)
                    ->header('Content-Type', 'application/pdf')
                    ->header('Content-Disposition', 'inline; filename="order.pdf"');
            }
            if ($result->payload->type == 'url') {
                $url = urldecode($result->payload->content);
                $response = Http::get($url);
                if ($response->successful()) {
                    $pdfContent = $response->body();
                    return response($pdfContent)
                        ->header('Content-Type', 'application/pdf')
                        ->header('Content-Disposition', 'inline; filename="order.pdf"');
                }
                return redirect()->to($url);
            }
        } else {
            return redirect()->back();
        }
    }
    public function cn_print_bulk(Request $request)
    {
        $courier_ids = array_column($request->bulk_array,'courier_id');
        $account_ids = array_column($request->bulk_array,'account_id');
        $courier_id_single = array_unique($courier_ids);
        $courier_id = $courier_id_single[0];
        
        $account_id_single = array_unique($account_ids);
        $courier_account_id = $account_id_single[0];
        
        $print_type = "bulk";
        $cn_number = array_column($request->bulk_array,'tpl_consignment');
        
        $result = getAPIdata('tpl/print', compact('courier_id', 'courier_account_id', 'cn_number','print_type'));
        // print_r($result);die;
        if ($result->payload != null) {
            if ($result->payload->type == 'text') {
                $content = $result->payload->content;
                $base64Content = str_replace('data:application/pdf;base64,', '', $content);
                return response()->json([
                    'status' => 1,
                    'pdf_content' => $base64Content
                ]);
            }
            if ($result->payload->type == 'url') {
                $url = urldecode($result->payload->content);
                $response = Http::get($url);
                if ($response->successful()) {
                    $pdfContent = $response->body();
                    return response($pdfContent)
                        ->header('Content-Type', 'application/pdf')
                        ->header('Content-Disposition', 'inline; filename="order.pdf"');
                }
                return redirect()->to($url);
            }
        } else {
            return redirect()->back();
        }
    }
    public function cn_track(Request $request)
    {
        $courier_id = $request->courier_id;
        $account_id = $request->account_id;
        $tpl_cn_number = $request->tpl_cn_number;
        $consignment_no = $request->consignment_no;

        $common = app(commonController::class);

        $status_details = $common->order_tracking($consignment_no);
        $html = '';
        $result = getAPIdata('tpl/tracking', compact('courier_id', 'account_id', 'tpl_cn_number'));
        foreach ($result->payload as $key => $row) {
            $html .= ' 
            <div><span class="border-bottom">' . $row->dateTime . ' - ' . $row->status . '</span></div>
           ';
        }
        $get_data = ['company_id' => session('company_id'), 'cn_number' => $tpl_cn_number, "third_party" => "1"];
        $cn_data = getAPIdata('tpl/manual/shipment_data', $get_data);
        $modal = '<div class="infodiv">
            <span class="boldspan">CN# </span>
            <span class="boldbl">' . $tpl_cn_number . '</span>
        </div>
        <div class="infodiv">
            <span class="boldspan">DATE</span>
            <span>' . $status_details->last_updated . '</span>
        </div>
        <div class="infodiv">
            <span class="boldspan">CUSTOMER</span>
            <span>' . $cn_data->payload->customer_name . '</span>

        </div>
        <div class="infodiv">
            <span class="boldspan">COD</span>
            <span class="d-block" style="margin-bottom:8px;">' . number_format($cn_data->payload->order_amount + $cn_data->payload->total_charges) . '</span>
        </div>
        <div class="infodiv">
            <span class="boldspan">FROM TO</span>
            <span>' . city_name($cn_data->payload->origin_city) . ' &nbsp;<i class="fa fa-arrows-h"></i>&nbsp; ' . $cn_data->payload->destination_city . '</span>
        </div>';
        return response()->json(['status' => 1, 'status_list' => $html, 'modal' => $modal]);
    }
}
