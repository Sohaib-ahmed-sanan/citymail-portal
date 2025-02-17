<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class reportsController extends Controller
{
    public function customer_reports(Request $request)
    {
        $customers_function = get_customers();
        $cities = get_all_cities();
        if (!session('status')) {
            get_all_status();
        }
        $customers = $customers_function->original['payload'];
        if ($request->isMethod('GET')) {
            $title = "Customers Reports";
            $type = "add";
            if (is_portal()) {
                $company_id = session('company_id');
                $customer_acno = session('acno');
                $data = compact('company_id', 'customer_acno');

                $result = getAPIdata('customers/sub-accounts/index', $data);

                $sub_acc = $result;
            } else {
                $sub_acc = [];
            }
            $data = compact("title", "type", "customers", "sub_acc", "cities");
            return view("reports.customer_reports")->with($data);
        }
        if ($request->isMethod('POST')) {
            $customer_acno = isset($request->sub_acc) ? $request->sub_acc : '';
            if (is_portal() || is_customer_sub()) {
                $customer_acno = [session('acno')];
            }
            if (is_ops()) {
                $customer_acno = $request->customer_acno;
            }
            $city_id = $request->destination_id;
            $type = $request->type;
            $status_id = $request->status_id;
            $start_date = $request->start_date;
            $end_date = $request->end_date;
            $company_id = session('company_id');
            $data = compact('city_id', 'status_id', 'start_date', 'end_date', 'company_id', 'customer_acno');
            $result = getAPIdata('reports/customer-report', $data);
            $aaData = [];
            $resultsCount = 0;
            if ($result->status == 1) {
                $payload = $result->payload;
                $resultsCount = count($payload);
                $i = 1;
                $html = '';
                foreach ($payload as $key => $row) {
                   $status_name = $row->status_name;
                    $status_badge_class = getStatusBadge($row->status_id);
                    $statusBadge = sprintf(
                        '<button class="btn badge badge-pill badge-neutral-%s text-%s">%s</button>',
                        $status_badge_class,
                        $status_badge_class,
                        $status_name
                    );
                    $actions = '<div class="action-perform-btns">
                    <a style="color: #ba0c2f !important;" href="' . route('admin.cn_print', ['id' =>  base64_encode($row->consignment_no)]) . '" target="_blank" class="" data-toggle="tooltip" title="Print"><img src="' . asset('images/default/svg/print.svg') . '" width="15" alt="Print"></a>
              </div>';
                    if ($type == 'revenue') {
                        $amount = number_format($row->total_charges).' AED';
                    } else {
                        $amount = number_format($row->orignal_order_amt).' '.$row->orignal_currency_code;
                    }
                    if (is_ops()) {
                        $tpl = $row->thirdparty_consignment_no ?? 'N/A'; // Add TPL only if in ops
                    } else {
                        $tpl = null; // No TPL for non-ops
                    }
                    $aaData[] = [
                        'SNO' => ++$key,
                        'CN' => $row->consignment_no,
                        'TPL' => $tpl,
                        'CONSIGNEENAME' => $row->consignee_name,
                        'REFERENCE' => $row->shipment_referance,
                        'DESTINATIONCITY' => $row->destination_city,
                        'PAYMENT' => ($row->payment_method_id == '1' ? 'COD' : 'CC'),
                        'COD' => $amount,
                        'CHARGES' => $row->total_charges,
                        'BOOKEDAT' => Carbon::parse($row->created_at)->format('Y-m-d H:i A'),
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
    public function monthly_invoice_reports(Request $request)
    {
        $customers_function = get_customers();
        $cities = get_all_cities();
        if (!session('status')) {
            get_all_status();
        }
        $customers = $customers_function->original['payload'];
        if ($request->isMethod('GET')) {
            $title = "Monthly Invoice Reports";
            $type = "add";
            if (is_portal()) {
                $company_id = session('company_id');
                $customer_acno = session('acno');
                $data = compact('company_id', 'customer_acno');
                $result = getAPIdata('customers/sub-accounts/index', $data);
                $sub_acc = $result;
            } else {
                $sub_acc = [];
            }

            $data = compact("title", "type", "customers", "sub_acc", "cities");
            return view("reports.monthly_invoice_reports")->with($data);
        }
        if ($request->isMethod('POST')) {
            if ($request->sub_acc != "") {
                $customer_acno[] = $request->sub_acc;
            }
            if (is_portal()) {
                $customer_acno[] = session('acno');
            }
            if (is_ops()) {
                $customer_acno = $request->customer_acno;
            }
            if (is_customer_sub()) {
                $customer_acno[] = session('acno');
            }
            $city_id = $request->destination_id;
            $type = $request->type;
            $status_id = $request->status_id;
            $start_date = $request->start_date;
            $end_date = $request->end_date;
            $company_id = session('company_id');
            $data = compact('customer_acno', 'city_id', 'status_id', 'start_date', 'end_date', 'company_id');
            $result = getAPIdata('invoice/monthly-invoice', $data);
            $aaData = [];
            $resultsCount = 0;
            if ($result->status == 1) {
                $payload = $result->payload;
                $resultsCount = count($payload);
                $i = 1;
                $html = '';
                foreach ($payload as $key => $row) {
                    $statusBadgeClass = ($row->status != 2) ? ' badge-neutral-success text-success' : ' badge-neutral-danger text-danger';
                    $statusBadge = '<button table="" data-id="' . $row->id . '" class="btn badge badge-pill' . $statusBadgeClass . '">' . $row->status_name . '</button>';
                    $actions = '<div class="action-perform-btns">
                    <a style="color: #ba0c2f !important;" href="' . route('admin.cn_print', ['id' => base64_encode($row->consignment_no)]) . '" target="_blank" class="" data-toggle="tooltip" title="Print"><img src="' . asset('images/default/svg/print.svg') . '" width="15" alt="Print"></a>
              </div>';

                    $aaData[] = [
                        'SNO' => ++$key,
                        'CN' => $row->consignment_no,
                        'CONSIGNEENAME' => $row->consignee_name,
                        'REFERENCE' => $row->shipment_referance,
                        'DESTINATIONCITY' => $row->destination_city,
                        'ORIGIN' => $row->origin_city,
                        'PAYMENT' => ($row->payment_method_id == '1' ? 'COD' : 'CC'),
                        'BOOKED' => Carbon::parse($row->booking_date)->format('d-m-Y'),
                        'ARRIVAL' => Carbon::parse($row->booking_date)->format('d-m-Y'),
                        'CURRENCY' => $row->currency_code,
                        'COD' => number_format($row->order_amount),
                        'CHARGES' => number_format($row->total_charges),
                        'INVOICE' => ($row->invoice_no != "" ? $row->invoice_no : "Invoice Not Created"),
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
    public function sales_person_reports(Request $request)
    {
        if ($request->isMethod('GET')) {
            $customers_function = get_customers();
            $cities = get_all_cities();
            if (!session('status')) {
                get_all_status();
            }
            $customers = $customers_function->original['payload'];
            $title = "Sales Person Report";
            $data = compact("title", "customers", "cities");
            return view("reports.sales_person_reports")->with($data);
        }
        if ($request->isMethod('POST')) {
            if (is_ops()) {
                $customer_acno = $request->customer_id;
            }
            $start_date = $request->start_date;
            $end_date = $request->end_date;
            $company_id = session('company_id');
            $data = compact('customer_acno','start_date', 'end_date', 'company_id');
            $result = getAPIdata('reports/salesperson-report', $data);
            // $result = getAPIJson('revenue-report/salesperson-report', $data);
            // dd($result);
            $aaData = [];
            $resultsCount = 0;
            if ($result->status == 1) {
                $payload = $result->payload;
                $resultsCount = count($payload);
                $i = 1;
                $html = '';
                foreach ($payload as $key => $row) {
                    $statusBadgeClass = ($row->active == 1) ? ' badge-neutral-success text-success' : ' badge-neutral-danger text-danger';
                    $statusBadge = '<button data-id="' . $row->id . '" data-status="' . ($row->active == 1 ? '0' : '1') . '" class="btn badge badge-pill' . $statusBadgeClass . '" data-toggle="tooltip" title="'.($row->active == 1 ? 'Active' : 'Inactive').'">' . ($row->active == 1 ? 'Active' : 'Inactive') . '</button>';
                    $aaData[] = [
                        'SNO' => ++$key,
                        'SALESPERSON' => $row->sp_first_name.' '. $row->sp_last_name,
                        'CUSTOMER' => $row->business_name,
                        'DATE' => Carbon::parse($row->created_at)->format('d-m-Y'),
                        'TOTALSHIPMENTS' => $row->st_count,
                        'TOTALRETURN' => $row->sr_count,
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
            echo compressJson($arraylist);
        }
    }
    public function sales_reports(Request $request)
    {
        if ($request->isMethod('GET')) {
            $customers_function = get_customers();
            $cities = get_all_cities();
            if (!session('status')) {
                get_all_status();
            }
            $customers = $customers_function->original['payload'];
            $title = "Sales Report";
            $data = compact("title", "customers", "cities");
            return view("reports.sales_reports")->with($data);
        }
        if ($request->isMethod('POST')) {
            if (is_ops()) {
                $customer_acno = $request->customer_id;
            }
            $start_date = $request->start_date;
            $end_date = $request->end_date;
            $company_id = session('company_id');
            $data = compact('customer_acno','start_date', 'end_date', 'company_id');
            $result = json_decode(getAPIJson('reports/sales-report', $data));
            $aaData = [];
            // $resultsCount = 0;
                $i = 0;
            if ($result->status == 1) {
                $payload = $result->payload;
                // $resultsCount = count($payload);
                $html = '';
                $i = 1;
               foreach ($payload as $key => $row) {
                $i++;
                    $status_name = $row->status_name;
                    $status_badge_class = getStatusBadge($row->status_id);
                    $statusBadge = sprintf(
                        '<button class="btn badge badge-pill badge-neutral-%s text-%s">%s</button>',
                        $status_badge_class,
                        $status_badge_class,
                        $status_name
                    );
            
                    $withCashierBadge = $row->with_cashier == 1
                        ? '<button class="status_btn btn badge badge-pill badge-neutral-success text-success">Collected</button>'
                        : '<button class="status_btn btn badge badge-pill badge-neutral-danger text-danger">Not Collected</button>';
            
                    $InvoicePaidBadge = $row->payment_status == 1
                        ? '<button class="btn badge badge-pill badge-neutral-success text-success">PAID</button>'
                        : '<button class="btn badge badge-pill badge-neutral-danger text-danger">UN PAID</button>';
                
                        // 'DATE' => Carbon::parse($row->created_at)->format('d-m-Y'),
            
                    $aaData[] = [
                        'SNO' => $key + 1,
                        'CN' => $row->consignment_no,
                        'DATE' => date('d-m-Y', strtotime($row->created_at)),
                        'CONSIGN' => $row->consignee_name,
                        'ORIGIN' => $row->origin_city, // Access cached data
                        'DESTINATION' => $row->destination_city, // Access cached data
                        'TCN' => $row->thirdparty_consignment_no ?? 'N/A',
                        'WGTCHARGED' => $row->weight_charged,
                        'PCSCHARGED' => $row->peices_charged,
                        'SST' => $row->sst_charges,
                        'GST' => $row->gst_charges,
                        'BAC' => $row->bac_charges,
                        'HC' => $row->handling_charges,
                        'SC' => $row->service_charges,
                        'TC' => $row->total_charges,
                        'COD' => $row->order_amount . ' AED',
                        'TPLCOLLECTED' => $withCashierBadge,
                        'INVOICENO' => $row->invoice_no ?? 'N/A',
                        'INVOICESTATUS' => $InvoicePaidBadge,
                        'STATUS' => $statusBadge,
                    ];
                }
            }
            // dd($aaData);
            $arraylist = array(
                'TotalRecords' => $i,
                'aaData' => $aaData,
            );
            return response()->json($arraylist);
        }
    }
     // revenue_details
    public function revenue_details(Request $request)
    {
        if ($request->isMethod('GET')) {
            $customers_function = get_customers();
            $cities = get_all_cities();
            if (!session('status')) {
                get_all_status();
            }
            if (is_portal()) {
                $company_id = session('company_id');
                $customer_acno = session('acno');
                $data = compact('company_id', 'customer_acno');
                $result = getAPIdata('customers/sub-accounts/index', $data);
                $sub_acc = $result;
            } else {
                $sub_acc = [];
            }
            $customers = $customers_function->original['payload'];
            $title = "Revenue Details";
            $data = compact("title", "customers", "sub_acc", "cities");
            return view("reports.revenue_details")->with($data);
        }
        if ($request->isMethod('POST')) {
            if ($request->sub_acc != "") {
                $customer_acno[] = $request->sub_acc;
            }
            if (is_portal()) {
                $customer_acno[] = session('acno');
            }
            if (is_ops()) {
                $customer_acno = $request->customer_acno;
            }
            if (is_customer_sub()) {
                $customer_acno[] = session('acno');
            }
            $city_id = $request->destination_id;
            $type = $request->type;
            $status_id = $request->status_id;
            $start_date = $request->start_date;
            $end_date = $request->end_date;
            $company_id = session('company_id');
            $type = '1';
            $data = compact('customer_acno', 'city_id', 'status_id', 'start_date', 'end_date','type','company_id');
            $result = getAPIdata('reports/revenue-report', $data);
            $aaData = [];
            $resultsCount = 0;
            if ($result->status == 1) {
                $payload = $result->payload;
                $resultsCount = count($payload);
                $i = 1;
                $html = '';
                foreach ($payload as $key => $row) {
                    $statusBadgeClass = ($row->status == 14) ? ' badge-neutral-success text-success' : ' badge-neutral-danger text-danger';
                    $statusBadge = '<button class="btn badge badge-pill' . $statusBadgeClass . '">' . $row->status_name . '</button>';
                    $actions = '<div class="action-perform-btns">
                    <a style="color: #ba0c2f !important;" href="' . route('admin.cn_print', ['id' => base64_encode($row->consignment_no)]) . '" target="_blank" class="" data-toggle="tooltip" title="Print"><img src="' . asset('images/default/svg/print.svg') . '" width="15" alt="Print"></a>
                    </div>';
                    if($row->status == 14)
                    {
                       $total_charges = $row->service_charges+$row->gst_charges+$row->bac_charges+$row->sst_charges+$row->handling_charges;
                    }else{
                        $total_charges = $row->rto_charges+$row->rto_gst_charges+$row->bac_charges+$row->sst_charges+$row->handling_charges;                        
                    }

                    $charges_amount = number_format($total_charges);

                    $aaData[] = [
                        'SNO' => ++$key,
                        'CN' => $row->consignment_no,
                        'CONSIGNEENAME' => $row->consignee_name,
                        'REFERENCE' => $row->shipment_referance,
                        'DESTINATIONCITY' => $row->destination_city,
                        'PAYMENT' => ($row->payment_method_id == '1' ? 'COD' : 'CC'),
                        'COD' => $row->order_amount .' AED',
                        'SERVICECHRG' => ($row->status == 14 ? $row->service_charges : $row->rto_charges),
                        'GSTCHRG' => ($row->status == 14 ? $row->gst_charges : $row->rto_gst_charges),
                        'SSTCHRG' => $row->sst_charges,
                        'BACCHRG' => $row->bac_charges,
                        'HANDELINGCHRG' => $row->handling_charges,
                        'TOTALCHARGES' => $charges_amount,
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
    public function outstanding_details(Request $request)
    {
        if ($request->isMethod('GET')) {
            $customers_function = get_customers();
            $cities = get_all_cities();
            if (!session('status')) {
                get_all_status();
            }
            if (is_portal()) {
                $company_id = session('company_id');
                $customer_acno = session('acno');
                $data = compact('company_id', 'customer_acno');
                $result = getAPIdata('customers/sub-accounts/index', $data);
                $sub_acc = $result;
            } else {
                $sub_acc = [];
            }
            $customers = $customers_function->original['payload'];
            $title = "Outstanding Details";
            $data = compact("title", "customers", "sub_acc", "cities");
            return view("reports.outstanding_details")->with($data);
        }
        if ($request->isMethod('POST')) {
            if ($request->sub_acc != "") {
                $customer_acno[] = $request->sub_acc;
            }
            if (is_portal()) {
                $customer_acno[] = session('acno');
            }
            if (is_ops()) {
                $customer_acno = $request->customer_acno;
            }
            if (is_customer_sub()) {
                $customer_acno[] = session('acno');
            }
            $city_id = $request->destination_id;
            $type = $request->type;
            $status_id = $request->status_id;
            $start_date = $request->start_date;
            $end_date = $request->end_date;
            $company_id = session('company_id');
            $type = '0';
            $data = compact('customer_acno', 'city_id', 'status_id', 'start_date', 'end_date','type','company_id');
            $result = getAPIdata('reports/revenue-report', $data);
            $aaData = [];
            $resultsCount = 0;
            if ($result->status == 1) {
                $payload = $result->payload;
                $resultsCount = count($payload);
                $i = 1;
                $html = '';
                foreach ($payload as $key => $row) {
                    $statusBadgeClass = ($row->status == 14) ? ' badge-neutral-success text-success' : ' badge-neutral-danger text-danger';
                    $statusBadge = '<button class="btn badge badge-pill' . $statusBadgeClass . '">' . $row->status_name . '</button>';
                    $actions = '<div class="action-perform-btns">
                    <a style="color: #ba0c2f !important;" href="' . route('admin.cn_print', ['id' => base64_encode($row->consignment_no)]) . '" target="_blank" class="" data-toggle="tooltip" title="Print"><img src="' . asset('images/default/svg/print.svg') . '" width="15" alt="Print"></a>
                    </div>';
                    if($row->status == 14)
                    {
                       $total_charges = $row->service_charges+$row->gst_charges+$row->bac_charges+$row->sst_charges+$row->handling_charges;
                    }else{
                        $total_charges = $row->rto_charges+$row->rto_gst_charges+$row->bac_charges+$row->sst_charges+$row->handling_charges;                        
                    }

                    $charges_amount = number_format($total_charges);

                    $aaData[] = [
                        'SNO' => ++$key,
                        'CN' => $row->consignment_no,
                        'CONSIGNEENAME' => $row->consignee_name,
                        'REFERENCE' => $row->shipment_referance,
                        'DESTINATIONCITY' => $row->destination_city,
                        'PAYMENT' => ($row->payment_method_id == '1' ? 'COD' : 'CC'),
                        'COD' => $row->order_amount .' AED',
                        'SERVICECHRG' => ($row->status == 14 ? $row->service_charges : $row->rto_charges),
                        'GSTCHRG' => ($row->status == 14 ? $row->gst_charges : $row->rto_gst_charges),
                        'SSTCHRG' => $row->sst_charges,
                        'BACCHRG' => $row->bac_charges,
                        'HANDELINGCHRG' => $row->handling_charges,
                        'TOTALCHARGES' => $charges_amount,
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
}
