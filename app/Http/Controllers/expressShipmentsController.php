<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
class expressShipmentsController extends Controller
{
    public function express_shipments(Request $request)
    {
        if ($request->isMethod('GET')) {
            $title = 'Express Shipments';
            $data = compact('title');
            return view('express-shipments.index')->with($data);
        }
        if ($request->isMethod('POST')) {
            $company_id = (int) session('company_id');
            $customer_acno = (string) session('acno');
            $start_date = $request->start_date;
            $end_date = $request->end_date;
            $destination_id = (int) $request->destination_id;
            $country_id = (int) $request->country_id;
            $status_id = (int) $request->status_id;

            $data = compact('company_id','customer_acno','start_date','end_date','country_id','destination_id','status_id');
            $result = getAPIdata('express-shipments/index', $data);
            $aaData = [];
            $i = 1;
            $resultsCount = 0;
            if ($result->status == 1) {
                $payload = $result->payload;
                $resultsCount = count($payload);
                foreach ($payload as $key => $row) {
                    $status_class = ' badge-neutral-' . getStatusBadge($row->status) . ' text-' . getStatusBadge($row->status);
                    $statusBadge = '<button table="shipments" data-id="' . $row->id . '" data-status="' . ($row->active == 1 ? '0' : '1') . '" class="btn badge badge-pill' . $status_class . '">' . $row->status_name . '</button>';
                    $wrongCityBadge = '<button class="btn badge badge-pill badge-neutral-returned"  data-toggle="tooltip" title="' . $row->wrong_city . '">Wrong City</button>';
                    $wrongCountryBadge = '<button class="btn badge badge-pill badge-neutral-returned"  data-toggle="tooltip" title="Wrong Country">Wrong Country</button>';
                    $edit_btn = '';
                    if (is_ops() && !in_array($row->status, ['14', '15', '16'])) {
                        $edit_btn = '<a style="color: #ba0c2f !important;" href="' . route('admin.add_edit-express-shipments', ['id' => $row->id]) . '" class="" data-toggle="tooltip" title="Edit"><img src="' . asset('assets/icons/Edit.svg') . '" width="15" alt="Edit"></a>';
                    }
                    $actions =
                        '<div class="action-perform-btns">' .
                        $edit_btn .
                        '<a style="color: #ba0c2f !important;" target="_blank" href="' .
                        route('admin.cn_print', ['id' => base64_encode($row->consignment_no)]) .
                        '" class="" data-toggle="tooltip" title="Print"><img src="' .
                        asset('assets/icons/Print.svg') .
                        '" width="15" alt="Print"></a>
                            <a target="_blank"
                                href="'. route('admin.proforma-invoice', ['id' => base64_encode($row->consignment_no)]).'"
                                class="" data-toggle="tooltip" title="Performa Invoice Print">
                                <i class="fa-solid fa-sheet-plastic"></i>
                            </a>';
                            if(isset($row->document) && $row->document != ""){
                                $actions .= '<a target="_blank"
                                href="'.env('API_URL').$row->document.'"
                                class="" data-toggle="tooltip" title="Download Document">
                                <img src="'.asset('assets/icons/Download.svg').'" width="15" alt="Download Document" download>
                            </a>'; 
                            }

                        $actions .= '</div>';
                    $aaData[] = [
                        'SNO' => ++$key,
                        'CN' => $row->consignment_no,
                        'SHIPPERNAME' => $row->shipper_name,
                        'SHIPPEREMAIL' => $row->shipper_email,
                        'SHIPPERPHONE' => $row->shipper_phone,
                        'NAME' => $row->consignee_name,
                        'EMAIL' => $row->consignee_email,
                        'PHONE' => $row->consignee_phone,
                        'SHIPREF' => $row->shipment_referance,
                        'DESTINATION' => $row->destination_country == '450' ? $wrongCountryBadge : $row->country_name,
                        'DESCITY' => $row->destination_city_id == '1317' ? $wrongCityBadge : $row->destination_city,
                        'ADDRESS' => $row->consignee_address,
                        'PARCELDET' => $row->parcel_detail,
                        'AMOUNT' => $row->orignal_order_amt,
                        'ORIGCODE' => $row->orignal_currency_code,
                        'CONVERTEDAMT' => $row->order_amount,
                        'CONVERTEDCODE' => $row->currency_code,
                        'PEICES' => $row->peices,
                        'WEIGHT' => $row->weight,
                        'BOOKEDAT' => Carbon::parse($row->created_at)->format('Y-m-d h:i A'),
                        'LASTSTATUSDATE' => Carbon::parse($row->last_status_date)->format('Y-m-d h:i A'),
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
    public function add_edit_express_shipments(Request $request, $id = null)
    {
        if ($request->isMethod('GET')) {
            $cities = get_all_cities();
            $countries = get_all_countries();
            $customers_function = get_customers(1);
            $customers = $customers_function->original['payload'];
            $sub_accounts = [];
            $pickup_locations = [];
            if (session('type') === '6') {
                $pickup_locations = [];
                $fetch_sub_acc = get_customers_sub(session('acno'));
                $sub_accounts = $fetch_sub_acc->original;
            }
            if ($id == null) {
                $title = 'Add Express Shipments';
                $data = compact('title', 'cities', 'countries', 'customers', 'sub_accounts');
                return view('express-shipments.add-edit')->with($data);
            } else {
                $title = 'Edit Express Shipments';
                $result = getAPIdata('express-shipments/single', ['company_id' => (int) session('company_id'), 'id' => (int) $id]);
                if ($result->status == '1') {
                    $shipment = $result->payload;
                    $param = ['company_id' => session('company_id'), 'customer_acno' => $shipment->customer_acno];
                    $result = getAPIdata('pickupLocation/index', $param);
                    $pickup_locations = $result->payload;
                    $data = compact('title', 'cities', 'countries', 'shipment', 'customers', 'sub_accounts','pickup_locations');
                    return view('express-shipments.add-edit')->with($data);
                } else {
                    return redirect()->back();
                }
            }
        }
    }
    public function store_express_shipments(Request $request, $id = null)
    {
        $request->validate([
            'consignee_name' => 'required|string',
            'consignee_email' => 'required|string|email',
            'consignee_phone' => 'required|string',
            'consignee_cnic' => 'nullable|string',
            'consignee_postcode' => 'required|string',
            'consignee_address' => 'required|string',
            'destination_country_id' => 'required|string',
            'destination_city_id' => 'required|string',
            'weight' => 'required|string',
            'export_reason' => 'required|string',
            'shipment_ref' => 'required|string',
            'service_id' => 'required|string',
            'product_details' => 'required',
        ]);
        if ($id == null) {
            $request->validate([
                'document' => 'nullable|mimes:png,jpg,jpeg,pdf',
            ]);
            $base64Document = '';
            if ($request->hasFile('document')) {
                $document = $request->file('document');
                $documentMimeType = $document->getMimeType();
                $documentBase64 = base64_encode(file_get_contents($document->getPathname()));
                $base64Document = "data:$documentMimeType;base64,$documentBase64";
            }
            $details = json_decode($request->product_details);
            if (count($details) == 0) {
                return response()->json(['status' => 0, 'message' => 'Please add product details']);
            }
            $data = [
                'company_id' => (int) session('company_id'),
                'customer_acno' => (string) $request->customer_acno,
                'pickup_location_id' => (string) $request->pickup_location,
                'consignee_name' => (string) $request->consignee_name,
                'consignee_email' => (string) $request->consignee_email,
                'consignee_phone' => (string) $request->consignee_phone,
                'consignee_cnic' => (string) $request->consignee_cnic,
                'consignee_postcode' => (string) $request->consignee_postcode,
                'consignee_address' => (string) $request->consignee_address,
                'destination_country_id' => (int) $request->destination_country_id,
                'destination_city_id' => (int) $request->destination_city_id,
                'weight' => (int) $request->weight,
                'export_reason' => (string) $request->export_reason,
                'shipment_ref' => (string) $request->shipment_ref,
                'service_id' => (int) $request->service_id,
                'document_path' => (string) $base64Document??"",
                'product_details' => $details,
            ];
            $result = getAPIdata('express-shipments/add', $data);
            
            $return = ['status' => $result->status, 'message' => $result->message, 'payload' => $result->payload];
            return response()->json($return);
        } else {
            $request->validate([
                'product_details' => 'required',
            ]);
            $base64Document = '';
            if ($request->hasFile('document')) {
                $request->validate([
                    'document' => 'required|mimes:png,jpg,jpeg,pdf',
                ]);
                $document = $request->file('document');
                $documentMimeType = $document->getMimeType();
                $documentBase64 = base64_encode(file_get_contents($document->getPathname()));
                $base64Document = "data:$documentMimeType;base64,$documentBase64";
            }
            $details = json_decode($request->product_details);
            $data = [
                'shipment_id' => (int) $id,
                'company_id' => (int) session('company_id'),
                'customer_acno' => (string) $request->customer_acno,
                'pickup_location_id' => (string) $request->pickup_location,
                'consignee_name' => (string) $request->consignee_name,
                'consignee_email' => (string) $request->consignee_email,
                'consignee_phone' => (string) $request->consignee_phone,
                'consignee_cnic' => (string) $request->consignee_cnic,
                'consignee_postcode' => (string) $request->consignee_postcode,
                'consignee_address' => (string) $request->consignee_address,
                'destination_country_id' => (int) $request->destination_country_id,
                'destination_city_id' => (int) $request->destination_city_id,
                'weight' => (int) $request->weight,
                'export_reason' => (string) $request->export_reason,
                'shipment_ref' => (string) $request->shipment_ref,
                'service_id' => (int) $request->service_id,
                'document_path' => (string) $base64Document,
                'product_details' => $details,
            ];
            $result = getAPIdata('express-shipments/update', $data);
            $return = ['status' => $result->status, 'message' => $result->message, 'payload' => $result->payload];
            return response()->json($return);
        }
    }
    public function get_existing_shipper(Request $request)
    {
        $request->validate([
            'phone' => 'required|string|min:10|max:17',
        ]);
        $data = [
            'company_id' => (int) session('company_id'),
            'phone_number' => $request->phone,
        ];
        $result = getAPIdata('express-shipments/get-shipper', $data);
        $return = ['status' => $result->status, 'message' => $result->message, 'payload' => $result->payload];
        return response()->json($return);
    }

    public function add_walkin_customer(Request $request)
    {
        $data = [
            'company_id' => (int) session('company_id'),
            'name' => (string) $request->customer_name,
            'email' => (string) $request->customer_email,
            'phone' => (string) $request->customer_phone,
            'city_id' => (int) '655',
            'country_id' => (int) '449',
            'address' => (string) $request->customer_address,
            'business_name' => (string) $request->customer_business_name,
            'business_address' => (string) $request->customer_business_address,
            'cnic' => (string) $request->customer_cnic,
            'ntn' => (string) $request->customer_ntn,
            'postal_code' => (string) $request->customer_postal_code,
            'user_name' => (string) $request->user_name,
            'password' => (string) $request->customer_password,
        ];
        $result = getAPIdata('express-shipments/walkin-customer-creation', $data);
        $return = ['status' => $result->status, 'message' => $result->message, 'payload' => $result->payload];
        return response()->json($return);
    }

    public function get_walkin_customer(Request $request){
        $customers_function = get_customers(1);
        $customers = $customers_function->original['payload'];
        return response()->json(['customers'=>$customers]);
    }
}
