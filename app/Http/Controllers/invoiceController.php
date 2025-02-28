<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Facades\Excel;

class invoiceController extends Controller
{

    public function invoice(Request $request)
    {
        if ($request->isMethod('GET')) {
            $get = get_customers();
            $customers = $get->original['payload'];
            $title = "Invoice";
            $data = compact("title", "customers");
            return view("invoices.invoices")->with($data);
        }
        if ($request->isMethod('POST')) {
            $company_id = session('company_id');
            $start_date = $request->start_date;
            $end_date = $request->end_date;
            $date_filter = "";
            if (is_portal()) {
                $customer_acno[] = session('acno');
                $new_start_date = Carbon::now()->subDays(3)->format('Y-m-d');
                $new_end_date = Carbon::now()->format('Y-m-d');
                $date_filter = 'invoice_creation_date';                    
                if($new_start_date == $start_date && $new_end_date == $end_date){
                    $start_date = Carbon::now()->format('d-m-Y');
                    $end_date = $new_end_date;                    
                }else{
                    $start_date = Carbon::parse($request->start_date)->format('d-m-Y');
                    $end_date = Carbon::parse($request->end_date)->format('d-m-Y');
                }
            } else {
                $customer_acno = $request->customer_acno;
                $date_filter = "created_at";
            }
            $data = compact('company_id', 'start_date', 'end_date', 'customer_acno','date_filter');
            $result = getAPIdata('invoice/index', $data);
            $aaData = [];
            $i = 1;
            $resultsCount = 0;
            if ($result->status == 1) {
                $payload = $result->payload;
                $resultsCount = count($payload);
                $aaData = [];
                $i = 1;
                foreach ($payload as $key => $row) {
                    $actions = '<div class="action-perform-btns">
                    <a target="_blank" style="color: #ba0c2f !important;" href="' . route('admin.invoice_pdf', ['id' => $row->invoice_no]) . '" class="" data-toggle="tooltip" title="Print"><img src="' . asset('images/default/svg/print.svg') . '" width="15" alt="Print"></a>';
                    if (is_ops() && $row->status == '0') {
                        $actions .= '<a class="delete_invoice" style="color: #ba0c2f !important;" href="javascript:void(0);" data-id="' . $row->id . '" data-toggle="tooltip" title="Delete"><img src="' . asset('assets/icons/Delete.svg') . '" width="15" alt="Delete"></a>';
                    }
                    if (is_ops() && $row->status == '0') {
                        $actions .= '<a class="mark_paid" style="color: #ba0c2f !important;" href="javascript:void(0);" data-id="' . $row->id . '" data-toggle="tooltip" title="Mark Paid"><i class="fa-solid fa-dollar-sign fa-lg text-primary"></i></a>';
                    }
                    $actions .= '</div>';
                    $statusBadgeClass = ($row->status == 1) ? ' badge-neutral-success text-success' : ' badge-neutral-danger text-danger';
                    $statusBadge = '<button data-id="' . $row->id . '" data-status="' . ($row->status == 1 ? '0' : '1') . '" class="btn badge badge-pill' . $statusBadgeClass . '" data-toggle="tooltip" title="' . ($row->status == 1 ? 'Paid' : 'Un Paid') . '">' . ($row->status == 1 ? 'Paid' : 'Un Paid') . '</button>';
                    $aaData[] = [
                        'SNO' => ++$key,
                        'INVOICE' => $row->invoice_no,
                        'CHEQUENO' => $row->cheque_no,
                        'CHEQUETITLE' => $row->cheque_title,
                        'TYPE' => $row->payment_type,
                        'REF' => $row->referance,
                        'CUSTOMER' => $row->customer_name,
                        'COUNT' => $row->consignment_count,
                        'CREATION' => $row->invoice_creation_date,
                        'FROM' => $row->invoice_from_date,
                        'TO' => $row->invoice_to_date,
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
    public function add_invoice()
    {
        $title = "Add Invoice";
        $customers_function = get_customers();
        $customers = $customers_function->original['payload'];
        $data = compact("title", "customers");
        return view("invoices.addInvoice")->with($data);
    }
    public function fetch_invoice_data(Request $request)
    {
        $request->validate([
            "customer_acno" => "required",
            "invoice_date" => "required",
            "from_date" => "required",
            "to_date" => "required",
        ]);
        if (session('company_type') == 'I') {
            $request->validate([
                "payment_type" => "required",
                "referance" => "required",
            ]);
        } elseif (session('company_type') == 'D') {
            $request->validate([
                "cheque_no" => "required",
                "cheque_title" => "required",
            ]);
        }
        $start_date = Carbon::parse($request->from_date)->format('Y-m-d');
        $end_date = Carbon::parse($request->to_date)->format('Y-m-d');
        $customer_acno = $request->customer_acno;

        $company_id = session('company_id');
        $data = compact('company_id', 'start_date', 'end_date', 'customer_acno');
        $result = getAPIdata('invoice/getData', $data);
        if ($result->status == 1) {
            $payload = $result->payload;
            $html = '';
            foreach ($payload as $key => $records) {
                $destination_city_id = $records->destination_city_id;
                $cities = get_all_cities();
                $filtered_city = array_filter($cities, function ($city) use ($destination_city_id) {
                    return $city->id == $destination_city_id;
                });
                $filtered_city = reset($filtered_city);
                $statusBadgeClass = ($records->status == '14') ? ' badge-neutral-success text-success' : ' badge-neutral-danger text-danger';
                $statusBadge = '<button class="btn badge badge-pill' . $statusBadgeClass . '">' . $records->status_name . '</button>';
                $actions = '<div class="action-perform-btns">
                              <a class="rem_row" style="color: #ba0c2f !important;" href="javascript:void(0);" data-toggle="tooltip" data-id="' . $records->consignment_no . '" data-bs-placement="top" title="Delete"><img src="' . asset('assets/icons/Delete.svg') . '" width="15" alt="Delete" ></a>
                          </div>';
                $data = (array) $records;
                extract($data);
                $html .= '<tr>
                                <td>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input check_box" name="checked_id[]" value="' . $consignment_no . '" id="customCheck' . $key . '">
                                        <label class="custom-control-label" data-toggle="tooltip" title="Check to update charges" for="customCheck' . $key . '"></label>
                                    </div>
                                </td> 
                                <td>' . ++$key . '</td> 
                                <td class="cn">' . $consignment_no . '</td> 
                                <td>' . Carbon::parse($created_at)->format('d-m-Y') . '</td> 
                                <td>' . $consignee_name . '</td>    
                                <td>' . $shipment_referance . '</td>   
                                <td>' . $filtered_city->city . '</td>    
                                <td>' . $statusBadge . '</td>    
                                <td class="totalCod">' . $order_amount . '</td>';
                                if($records->status == '14')
                                {
                                   $html .= ' <td>
                                        <input style="width:150px !important" readonly type="text" name="service_charges[]" class="form-control service_charges charges_inp float"  required value="' . ($records->status == '14' ? $service_charges : '0') . '" />
                                    </td>';
                                }else{
                                    $html .= '<td class="service_charges d-none">' . $service_charges . ' </td><td class="">0</td>';
                                }    
                                if($records->status == '16')
                                {
                                   $html .= ' <td>
                                        <input style="width:150px !important" readonly type="text" name="rto_charges[]" class="form-control rto_charges charges_inp float"  required value="' . ($records->status == '16' ? $rto_charges : '0') . '" />
                                    </td>';
                                }else{
                                    $html .= '<td class="rto_charges d-none">' . $rto_charges . ' </td><td class="">0</td>';
                                }    
                               $html .= ' 
                                <td class="old_service_charges d-none">' . $service_charges . '</td>    
                                <td class="old_rto_charges d-none">' . $rto_charges . '</td>    
                                <td class="handling">' . $handling_charges . '</td>    
                                <td class="gst">' . ($records->status == '14' ? $gst_charges : $rto_gst_charges) . '</td>      
                                <td class="sst">' . $sst_charges . '</td>    
                                <td class="bac">' . $bac_charges . '</td>    
                                <td>' . $actions . '</td>
                            </tr>';
            }
            $return = ['status' => 1, 'message' => 'success', 'payload' => $html];
            return response()->json($return);
        } else {
            $return = ['status' => $result->status, 'message' => $result->message, 'payload' => $result->payload];
            return response()->json($return);
        }
    }
    public function store_invoice_data(Request $request)
    {
        $request->validate([
            "customer_acno" => "required",
            "invoice_date" => "required",
            "from_date" => "required",
            "to_date" => "required",
        ]);
        if (session('company_type') == 'I') {
            $request->validate([
                "payment_type" => "required",
                "referance" => "required",
            ]);
        } elseif (session('company_type') == 'D') {
            $request->validate([
                "cheque_no" => "required",
                "cheque_title" => "required",
            ]);
        }
        $invoice_date = $request->invoice_date;
        $cheque_no = $request->cheque_no;
        $cheque_title = $request->cheque_title;
        $payment_type = $request->payment_type;
        $referance = $request->referance;
        $customer_acno = $request->customer_acno;
        $start_date = $request->from_date;
        $end_date = $request->to_date;
        $company_id = session('company_id');
        $details = $request->details;
        $data = compact(
        'invoice_date', 
        'cheque_no', 
        'cheque_title', 
        'payment_type', 
        'referance', 
        'company_id', 
        'start_date', 
        'end_date', 
        'customer_acno',
        'details'
        );
        // $result = getAPIJson('invoice/add', $data);
        $result = getAPIdata('invoice/add', $data);
        $return = ['status' => $result->status, 'message' => $result->message, 'payload' => $result->payload];
        return response()->json($return);
    }
    // third party payments   
    public function third_party_payments(Request $request)
    {
        if ($request->isMethod('GET')) {
            $title = "Third Party Payments";
            $get = get_customers();
            $customers = $get->original['payload'];
            $data = compact("title", 'customers');
            return view("invoices.tpl-payments")->with($data);
        }
        if ($request->isMethod('POST')) {
            $company_id = session('company_id');

            $customer_acno = $request->customer_acno;

            $start_date = $request->start_date;
            $end_date = $request->end_date;
            $data = compact('company_id', 'start_date', 'end_date', 'customer_acno');
            // dd($data);
            // $result = getAPIJson('invoice/tpl-payments/index', $data);
            $result = getAPIdata('invoice/tpl-payments/index', $data);
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
                    $actions = '<div class="action-perform-btns">
                     <a table="de_manifist" class="delete" style="color: #ba0c2f !important;" href="javascript:void(0);" data-id="' . $row->id . '" data-toggle="tooltip" title="Delete"><img src="' . asset('assets/icons/Delete.svg') . '" width="15" alt="Delete"></a>
                      </div>';
                    $statusBadgeClass = ($row->status == '14') ? ' badge-neutral-success text-success' : ' badge-neutral-danger text-danger';
                    $statusBadge = '<button class="btn badge badge-pill' . $statusBadgeClass . '">' . $row->status_name . '</button>';
                    $checkBox = '<div class="custom-control custom-checkbox">
                      <input  type="checkbox" class="custom-control-input check_box" name="checked_id[]" value="' . $row->consignment_no . '" id="customCheck' . $key . '">
                      <label class="custom-control-label" data-toggle="tooltip" title="Mark Payment" for="customCheck' . $key . '"></label>
                  </div>';
                    $aaData[] = [
                        'CHECK' => $checkBox,
                        'SNO' => ++$key,
                        'CN' => $row->consignment_no,
                        'CUSTOMER' => $row->customer_name,
                        'SHIPPER' => $row->shipper_name,
                        'REF' => $row->shipment_referance,
                        'COD' => $row->order_amount,
                        'CHARGES' => $row->total_charges,
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
    }
    public function add_third_party_payments(Request $request)
    {
        $consignments = $request->order_ids;
        $company_id = session('company_id');
        $updated_by = session('logged_id');
        $data = compact('company_id', 'consignments', 'updated_by');
        $result = getAPIdata('invoice/tpl-payments/add', $data);
        $return = ['status' => $result->status, 'message' => $result->message, 'payload' => $result->payload];
        return response()->json($return);
    }

    public function import_tpl_payments(Request $request)
    {
        $file = $request->file('excel_file');
        $data = Excel::toArray([], $file);
        $headerRow = $data[0][0];
        if ($headerRow[0] == "Consignment No") {
            $consignments = [];
            $excelData = array_slice($data[0], 1);
            foreach ($excelData as $key => $value) {
                $length = Str::length($value[0]);
                if ($length >= '9') {
                    $consignments[] = $value[0];
                }
            }
            $result = getAPIdata('invoice/tpl-payments/add', compact('consignments'));
            $return = ["status" => $result->status, "message" => $result->message, "payload" => $result->payload];
        } else {
            $return = ["status" => "0", "message" => "Invalid Column Please use this Consignment No as column name", "payload" => ""];
        }

        return response()->json($return);
    }
 
    public function delete_invoice(Request $request)
    {
        $result = getAPIdata('invoice/delete', ['company_id' => session('company_id'), 'invoice_id' => $request->id]);
        $return = ['status' => $result->status, 'message' => $result->message, 'payload' => $result->payload];
        return response()->json($return);
    }
    public function update_invoice(Request $request)
    {
        $result = getAPIdata('invoice/update', ['company_id' => session('company_id'), 'invoice_id' => $request->id]);
        $return = ['status' => $result->status, 'message' => $result->message, 'payload' => $result->payload];
        return response()->json($return);
    }
}
