<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use ZanySoft\LaravelPDF\PDF;
use Illuminate\Support\Facades\Http;

class operationsController extends Controller
{
    public function assign_driver(Request $request)
    {
        if ($request->isMethod('GET')) {
            $title = 'Driver Assign';
            $customers_function = get_customers();
            $customers = $customers_function->original['payload'];
            $data = compact('title', 'customers');
            return view('single_page_modules.assign-driver')->with($data);
        }
        if ($request->isMethod('POST')) {
            $type = 'all';
            $city_id = '';
            if (session('type') != '1') {
                $city_id = session('origin_city');
            }
            $customer_acno = $request->customer_acno;
            $compnay_id = session('company_id');
            $status = $request->status_id == 'NA' ? null : $request->status_id;
            $data = compact('type', 'customer_acno', 'compnay_id', 'status', 'city_id');
            $result = getAPIdata('pickups/index', $data);
            
            $commonController = app(commonController::class);
            $riders = $commonController->get_riders_dropdown();
            $aaData = [];
            $i = 1;
            $resultsCount = 0;
            if ($result->status == 1) {
                $payload = $result->payload;
                $resultsCount = count($payload);
                foreach ($payload as $key => $row) {
                    $actions =
                        '<div class="action-perform-btns">
                <div class="row">
                <div class="mb-3 col-md-9">
                <select disabled required class="form-control select form-select riders riders_id_' .
                        $key .
                        ' form-control-lg input_field "
                id="riders_id' .
                        $key .
                        '" data-toggle="select2" name="riders_id[]" size="1"
                label="Select Rider" data-placeholder="Select Rider" data-allow-clear="1"> <option value="">Select Rider</option>';
                    foreach ($riders as $rider) {
                        $actions .= '<option value="' . $rider->id . '" ' . ($row->asigned_rider == $rider->id ? 'selected' : '') . '>' . $rider->first_name . '</option>';
                    }
                    $actions .= '</select>
            </div>';
                    $checkBox =
                        '<div class="custom-control custom-checkbox">
            <input type="checkbox" ' .
                        ($row->status != null ? 'disabled' : '') .
                        ' class="custom-control-input ' .
                        ($row->status == null ? 'check_box' : '') .
                        '" name="checked_id[]" value="' .
                        $row->sheet_no .
                        '" data-key="' .
                        $key .
                        '" id="customCheck' .
                        $key .
                        '">
            <label class="custom-control-label" for="customCheck' .
                        $key .
                        '"></label>
        </div>';
                    $aaData[] = [
                        'SNO' =>'<div class="d-flex">'.$checkBox.' '.++$key.'</div>',
                        'DATE' => Carbon::parse($row->created_at)->format('d-m-Y'),
                        'PICKUP' => $row->pickup_location,
                        'CITY' => $row->pickup_city,
                        'CUSTOMER' => $row->acno,
                        'SHIPMENT' => $row->cn_count,
                        'ACCTYPE' => $row->parent_id === '0' || $row->parent_id == '' ? 'Main Account' : 'Sub Account',
                        'STATUS' => $row->status == null ? 'N/A' : ($row->status == 1 ? 'Assigned' : ''),
                        'ACTION' => $actions,
                    ];
                    $i++;
                    $resultsCount++;
                }
            }
            $arraylist = [
                'TotalRecords' => $resultsCount,
                'aaData' => $aaData,
            ];
            echo json_encode($arraylist);
        }
    }

    public function generate_assign_driver(Request $request)
    {
        // dr($request);
        $request->validate([
            'values' => 'required|array',
        ]);
        $data = $request->values;
        $company_id = session('company_id');
        $created_by = session('logged_id');
        $params = compact('company_id', 'created_by', 'data');
        // $result = getAPIJson('pickups/add', $params);
        // dd($result);
        $result = getAPIdata('pickups/add', $params);
        $return = ['status' => $result->status, 'message' => $result->message, 'payload' => $result->payload];
        // dd($return);
        return response()->json($return);
    }

    // ------------------------------ End pickup
    // list manifist view
    public function manifists(Request $request)
    {
        if ($request->isMethod('GET')) {
            $title = 'Manifestation';
            $data = compact('title');
            return view('manifists.manifists')->with($data);
        }
        if ($request->isMethod('POST')) {
            $company_id = session('company_id');
            $start_date = $request->start_date;
            $end_date = $request->end_date;
            $data = compact('company_id', 'start_date', 'end_date');
            $result = getAPIdata('manifists/index', $data);
            $aaData = [];
            $i = 1;
            $resultsCount = 0;
            if ($result->status == 1) {
                $payload = $result->payload;
                $resultsCount = count($payload);
                foreach ($payload as $key => $row) {
                    // <a style="color: #ba0c2f !important;" href="' . route('admin.add_edit_manifist', ['id' => $row->id]) . '" class="" data-toggle="tooltip" title="Edit" odidcn="28"><img src="' . asset('assets/icons/Edit.svg') . '" width="15" alt="Edit"></a>
                    $actions =
                        '<div class="action-perform-btns">
                        <a style="color: #ba0c2f !important;" target="_blank" href="' .
                        route('admin.manifistsheet-pdf', ['id' => $row->id]) .
                        '" class="" data-toggle="tooltip" title="Print"><img src="' .
                        asset('images/default/svg/print.svg') .
                        '" width="15" alt="Print"></a>
                   </div>';
                        // <a table="manifists" class="delete" style="color: #ba0c2f !important;" href="javascript:void(0);" data-id="' .
                        // $row->id .
                        // '" data-toggle="tooltip" title="Delete"><img src="' .
                        // asset('assets/icons/Delete.svg') .
                        // '" width="15" alt="Delete"></a>

                    $aaData[] = [
                        'SNO' => ++$key,
                        'BATCH' => $row->batch_name,
                        'SEAL' => $row->seal_no,
                        'STATION' => $row->name,
                        'DATE' => Carbon::parse($row->created_at)->format('d-m-Y'),
                        'CNCOUNT' => $row->consignment_count,
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
            echo json_encode($arraylist);
        }
    }
    // the ajax to fetch the data of all manifist
    public function add_edit_manifist(Request $request, $id = null)
    {
        // to manage the add and edit view page
        if ($request->isMethod('GET')) {
            if ($id == null && $request->isMethod('GET')) {
                $title = 'Add Manifists';
                $type = 'add';
                $param = ['company_id' => session('company_id')];
                $result = getAPIdata('stations/index', $param);
                $stations = $result;
                $data = compact('title', 'type', 'stations');
                return view('manifists.addEditManifist')->with($data);
            } elseif ($id != null && $request->isMethod('GET')) {
                $title = 'Edit Manifists';
                $type = 'edit';
                $param = ['company_id' => session('company_id')];
                $result = getAPIdata('stations/index', $param);
                $stations = $result;
                $manifist_data = getAPIdata('manifists/single', ['company_id' => session('company_id'), 'manifist_id' => $id]);
                $manifists = $manifist_data->payload;
                $data = compact('title', 'type', 'stations', 'manifists');
                return view('manifists.addEditManifist')->with($data);
            }
        }
        // to manage the insert and update function
        if ($request->isMethod('POST')) {
            // dd($request->all());
            if ($id == null && $request->isMethod('POST')) {
                $station_id = $request->station_id;
                // $rider_id = $request->rider_id;
                $cn_numbers = $request->cn_numbers;
                $company_id = session('company_id');
                $seal_no = $request->seal_no;
                $batch_name = $request->batch_name;
                $params = compact('station_id', 'batch_name', 'cn_numbers', 'company_id', 'seal_no');
                $result = getAPIdata('manifists/add', $params);
                $return = ['status' => $result->status, 'message' => $result->message, 'payload' => $result->payload];
                return response()->json($return);
            } elseif ($id != null && $request->isMethod('POST')) {
                $station_id = $request->station_id;
                $manifist_id = $id;
                $params = compact('station_id', 'manifist_id');
                $result = getAPIdata('manifists/update', $params);
                $return = ['status' => $result->status, 'message' => $result->message, 'payload' => $result->payload];
                return response()->json($return);
            }
        }
    }
    public function fetch_manifist_data(Request $request)
    {
        $request->validate([
            'shipment_no' => 'required',
        ]);

        $param = ['company_id' => session('company_id'), 'station_id' => $request->station_id, 'cn_number' => $request->shipment_no];
        $result = getAPIdata('manifists/getData', $param);
        if ($result->status == 1) {
            $payload = $result->payload;
            $html = '';
            foreach ($payload as $records) {
                $actions =
                    '<div class="action-perform-btns">
                          <a class="rem_row" style="color: #ba0c2f !important;" href="javascript:void(0);" data-bs-toggle="tooltip" data-id="' .
                    $request->shipment_no .
                    '" data-bs-placement="top" title="Delete"><img src="' .
                    asset('assets/icons/Delete.svg') .
                    '" width="15" alt="Delete" ></a>
                      </div>';
                $data = (array) $records;
                extract($data);
                $html .=
                    '<tr>
                            <td>' .
                    $request->shipment_no .
                    '</td>
                            <td>' .
                    $name .
                    '</td>
                            <td>' .
                    $consignee_name .
                    '</td>
                            <td>' .
                    $city .
                    '</td>
                            <td>' .
                    $shipment_referance .
                    '</td>
                            <td>' .
                    $actions .
                    '</td>
                        </tr>';
            }
            $return = ['status' => 1, 'message' => 'success', 'payload' => $html];
            return response()->json($return);
        } else {
            $return = ['status' => $result->status, 'message' => $result->message, 'payload' => $result->payload];
            return response()->json($return);
        }
    }
    // -------------------------- MANIFIST END -------------------
    public function de_manifists(Request $request)
    {
        if ($request->isMethod('GET')) {
            $title = 'DeManifestation';
            $data = compact('title');
            return view('demanifists.demanifists')->with($data);
        }
        if ($request->isMethod('POST')) {
            $company_id = session('company_id');
            $start_date = $request->start_date;
            $end_date = $request->end_date;
            $data = compact('company_id', 'start_date', 'end_date');
            $result = getAPIdata('de_manifists/index', $data);
            $aaData = [];
            $i = 1;
            $resultsCount = 0;
            if ($result->status == 1) {
                $payload = $result->payload;
                $resultsCount = count($payload);
                foreach ($payload as $key => $row) {
                    //  <a style="color: #ba0c2f !important;" href="' . route('admin.add_edit_de_manifist', ['id' => $row->id]) . '" class="" data-toggle="tooltip" title="Edit" odidcn="28"><img src="' . asset('assets/icons/Edit.svg') . '" width="15" alt="Edit"></a>
                    $actions =
                        '<div class="action-perform-btns">
                    <a style="color: #ba0c2f !important;" target="_blank" href="' .
                        route('admin.de-manifistsheet-pdf', ['id' => $row->id]) .
                        '" class="" data-toggle="tooltip" title="Print"><img src="' .
                        asset('images/default/svg/print.svg') .
                        '" width="15" alt="Print"></a>
                 </div>';
                    //  <a table="de_manifist" class="delete" style="color: #ba0c2f !important;" href="javascript:void(0);" data-id="' .
                    //     $row->id .
                    //     '" data-toggle="tooltip" title="Delete"><img src="' .
                    //     asset('assets/icons/Delete.svg') .
                    //     '" width="15" alt="Delete"></a>

                    $aaData[] = [
                        'SNO' => ++$key,
                        'SEAL' => $row->seal_no,
                        'DATE' => Carbon::parse($row->created_at)->format('d-m-Y'),
                        'MANICOUNT' => $row->manifist_count,
                        'CNCOUNT' => $row->consignment_count,
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
            echo json_encode($arraylist);
        }
    }
    // for ajax of cn number
    public function fetch_demanifest_data(Request $request)
    {
        $param = ['company_id' => session('company_id'), 'seal_no' => $request->seal_no, 'cn_number' => $request->shipment_no];
        $result = getAPIdata('de_manifists/getData', $param);
        // $result = getAPIJson('de_manifists/getData', $param);
        // dd($result);
        if ($result->status == 1) {
            $html = '';
            $form_inputs = '';
            foreach ($result->payload as $value) {
                $batch_name = $value->batch_name;
                $actions =
                    '<div class="action-perform-btns">
                    <a class="rem_row" style="color: #ba0c2f !important;" href="javascript:void(0);" data-bs-toggle="tooltip" data-id="' .
                    $value->consignment_no .
                    '" data-bs-placement="top" title="Delete"><img src="' .
                    asset('assets/icons/Delete.svg') .
                    '" width="15" alt="Delete" ></a>
                    </div>';
                $html .=
                    '<tr>
                            <td>' .
                    $value->consignment_no .
                    '</td>
                            <td>' .
                    $value->customer_name .
                    '</td>
                            <td>' .
                    $value->shipper_name .
                    '</td>
                            <td>' .
                    $value->consignee_name .
                    '</td>
                            <td>' .
                    $value->destination_city .
                    '</td>
                            <td>' .
                    $value->ref .
                    '</td>
                            <td>' .
                    $actions .
                    '</td>
                        </tr>';
                $form_inputs .=
                    '<div id="' .
                    $value->consignment_no .
                    '">
                    <input value="' .
                    $value->consignment_no .
                    '" type="hidden" name="cn_number[]">
                    <input value="' .
                    $value->manifist_id .
                    '" type="hidden" name="manifist_id[]">
                    <div>';
            }
            $return = ['status' => 1, 'message' => 'success', 'payload' => $html, 'batch_name' => $batch_name, 'form' => $form_inputs];
            return response()->json($return);
        } else {
            $return = ['status' => $result->status, 'message' => $result->message, 'payload' => $result->payload];
            return response()->json($return);
        }
    }
    public function add_edit_de_manifist(Request $request, $id = null)
    {
        // to manage the add and edit view page
        if ($request->isMethod('GET')) {
            $result = getAPIdata('stations/index', ['company_id' => session('company_id')]);
            $stations = $result;
            if ($id == null && $request->isMethod('GET')) {
                $title = 'Add DeManifestation';
                $type = 'add';
                $data = compact('title', 'type', 'stations');
                return view('demanifists.addEditDemanifist')->with($data);
            } elseif ($id != null && $request->isMethod('GET')) {
                $title = 'DeManifestation Details';
                $type = 'edit';
                $de_manifist_id = $id;
                $data = compact('id');
                $result = getAPIdata('de_manifists/single', $data);
                $de_manifist = $result->payload;
                $data = compact('title', 'type', 'de_manifist', 'stations');
                return view('demanifists.addEditDemanifist')->with($data);
            }
        }
        // to manage the insert and update function
        if ($request->isMethod('POST')) {
            if ($id == null && $request->isMethod('POST')) {
                $data = [];
                foreach ($request->cn_number as $key => $cn) {
                    $data[] = [
                        'consignment_no' => $cn,
                        'manifist_id' => $request->manifist_id[$key],
                    ];
                }
                $seal_no = $request->seal_no;
                $station_id = $request->station_id;
                // $rider_id = $request->rider_id;
                $company_id = session('company_id');
                $created_by = session('logged_id');
                $params = compact('seal_no', 'company_id', 'station_id', 'created_by', 'data');
                $result = getAPIdata('de_manifists/add', $params);
                $return = ['status' => $result->status, 'message' => $result->message, 'payload' => $result->payload];
                return response()->json($return);
            } elseif ($id != null && $request->isMethod('POST')) {
            }
        }
    }
    // ----------------- DE manifist END ---------------
    public function delivery_sheet(Request $request)
    {
        if ($request->isMethod('GET')) {
            $title = 'Delivery Sheet';
            $data = compact('title');
            return view('delivery_sheet.delivery_sheet')->with($data);
        }
        if ($request->isMethod('POST')) {
            $company_id = (int) session('company_id');
            $start_date = $request->start_date;
            $end_date = $request->end_date;
            $data = compact('company_id', 'start_date', 'end_date');
            $result = getAPIdata('delivery_sheet/index', $data);
            $aaData = [];
            $i = 1;
            $resultsCount = 0;
            if ($result->status == 1) {
                $payload = $result->payload;
                $resultsCount = count($payload);
                $aaData = [];
                $i = 1;
                // <a table="delivery_sheet" class="delete" style="color: #ba0c2f !important;" href="javascript:void(0);" data-id="' . $row->id . '" data-toggle="tooltip" title="Delete"><img src="' . asset('assets/icons/Delete.svg') . '" width="15" alt="Delete"></a>
                foreach ($payload as $key => $row) {
                    $actions =
                        '<div class="action-perform-btns">
                <a style="color: #ba0c2f !important;" href="' .
                        route('admin.add_edit_deliverySheet', ['id' => $row->sheet_no]) .
                        '" class="" data-toggle="tooltip" title="Edit" odidcn="28"><img src="' .
                        asset('assets/icons/Edit.svg') .
                        '" width="15" alt="Edit"></a>
                <a style="color: #ba0c2f !important;" target="_blank" href="' .
                        route('admin.dileverySheetPDF', ['id' => $row->sheet_no]) .
                        '" class="" data-toggle="tooltip" title="Print" odidcn="28"><img src="' .
                        asset('images/default/svg/print.svg') .
                        '" width="15" alt="Print"></a>
                 </div>';

                    $aaData[] = [
                        'SNO' => ++$key,
                        'SHEET' => $row->sheet_no,
                        'DATE' => Carbon::parse($row->created_at)->format('d-m-Y'),
                        'RIDER' => $row->rider_name,
                        'ROUTE' => Str::limit($row->route_address, 100, $end = '...'),
                        'CNCOUNT' => $row->consignment_count,
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
    public function add_edit_deliverySheet(Request $request, $id = null)
    {
        $commonController = app(commonController::class);
        $riders = $commonController->get_riders_dropdown();
        get_all_status();
        get_all_cities();
        if ($request->isMethod('GET')) {
            if ($id == null && $request->isMethod('GET')) {
                $title = 'Add Delivery Sheet';
                $type = 'add';
                $param = ['company_id' => session('company_id')];
                $routes_data = getAPIdata('routes/index', $param);
                $rouets = $routes_data;
                $data = compact('title', 'type', 'riders', 'rouets');
                return view('delivery_sheet.addDeliverySheet')->with($data);
            } elseif ($id != null && $request->isMethod('GET')) {
                $title = 'Edit Delivery Sheet';
                $sheet_no = intval($id);
                $param = ['sheet_no' => $sheet_no, 'company_id' => (int) session('company_id')];
                $type = 'edit';
                $result = getAPIdata('delivery_sheet/single', $param);
                $details = $result->payload;
                $data = compact('title', 'type', 'details', 'riders', 'sheet_no');
                return view('delivery_sheet.addDeliverySheet')->with($data);
            }
        }
        // to manage the insert and update function
        if ($request->isMethod('POST')) {
            if ($id == null && $request->isMethod('POST')) {
                $rider_id = $request->rider_id;
                $route_id = $request->route_id;
                $details = $request->details;
                $company_id = (int) session('company_id');
                $cn_count = count($details);
                $company_id = (int) session('company_id');
                $params = compact('details', 'company_id', 'rider_id', 'route_id','cn_count');
                $result = getAPIdata('delivery_sheet/add', $params);
                $return = ['status' => $result->status, 'message' => $result->message, 'payload' => $result->payload];
                return response()->json($return);
            }
            if ($id != null && $request->isMethod('POST')) {
                $details = $request->details;
                $sheet_no = intval($request->id);
                $company_id = session('company_id');
                $updated_by = session('logged_id');
                $params = compact('details', 'company_id', 'sheet_no', 'updated_by');
                $result = getAPIdata('delivery_sheet/update', $params);
                $return = ['status' => $result->status, 'message' => $result->message, 'payload' => $result->payload];
                return response()->json($return);
            }
        }
    }
    public function fetch_delivery_data(Request $request)
    {
        get_all_status();
        $riders_id = $request->riders_id;
        $route_id = $request->route_id;
        $shipment_no = $request->shipment_no;
        $company_id = session('company_id');
        $params = compact('shipment_no', 'company_id');
        $result = getAPIdata('delivery_sheet/getData', $params);
        // dd($result);
        if ($result->status == 1) {
            $payload = $result->payload;
            $html = '';
            $form_inputs = '';
            $actions =
                '<div class="action-perform-btns">
                    <a class="rem_row" style="color: #ba0c2f !important;" href="javascript:void(0);" data-bs-toggle="tooltip" data-id="' .
                $shipment_no .
                '" data-bs-placement="top" title="Delete"><img src="' .
                asset('assets/icons/Delete.svg') .
                '" width="15" alt="Delete" ></a>
                    </div>';
            $data = (array) $payload;
            extract($data);
            $html .=
                '<tr>
                            <td class="cn_no">' .
                $shipment_no .
                '</td>
                            <td>' .
                $customer_name .
                '</td>
                            <td>' .
                $shipper_name .
                '</td>
                            <td>' .
                $consignee_name .
                '</td>
                            <td>' .
                $ref .
                '</td>
                            <td>' .
                $destination .
                '</td>
                            <td>' .
                $peices_charged .
                '</td>
                            <td>' .
                $weight_charged .
                '</td>
                            <td class="currency_code">' .
                $currency_code .
                '</td>
                            <td>' .
                $order_amount .
                '</td>
                            <td>
                            <select required
                                    class=" form-control form-select status_single form-control-lg input_field"
                                    id="status_single_' .
                $shipment_no .
                '" data-toggle="select2" name="status_single[]"
                                    size="1" label="Select Status"
                                    data-placeholder="Select Status" data-allow-clear="1">
                                    <option value="">Select Status</option>';
            foreach (session('status') as $st) {
                if (!in_array($st->id, [1, 4, 2, 21, 22, 23, 17])) {
                    $html .= '<option ' . ($st->name == $status ? 'selected' : '') . ' value="' . $st->id . '">' . $st->name . '</option>';
                }
            }
            $html .=
                '</select>
                                    </td>
                    <td><input style="width: 300px !important;" type="text" class="form-control form-control-lg "
                         id="remarks" name="remarks[]"
                        placeholder="Enter Remarks" value="' .
                ($remarks != '' ? $remarks : '') .
                '"></td>
                            <td>' .
                $actions .
                '</td>
                        </tr>';

            $return = ['status' => 1, 'message' => 'success', 'payload' => $html];
            return response()->json($return);
        } else {
            $return = ['status' => $result->status, 'message' => $result->message, 'payload' => $result->payload];
            return response()->json($return);
        }
    }
    // ----------- end dilevary sheet
    // list couriers view
    public function couriers(Request $request)
    {
        if ($request->isMethod('GET')) {
            $title = 'Couriers';
            $couriers = get_all_couriers();
            $company_id = session('company_id');
            $data = compact('company_id');

            $accounts = getAPIdata('couriers_details/index', $data);
            $data = compact('title', 'couriers', 'accounts');
            return view('single_page_modules.couriers')->with($data);
        }
        if ($request->isMethod('POST')) {
            $company_id = session('company_id');
            $start_date = $request->start_date;
            $end_date = $request->end_date;
            $data = compact('company_id', 'start_date', 'end_date');
            $result = json_decode(getAPIJson('couriers_details/index', $data));
            $aaData = [];
            $i = 1;
            $resultsCount = 0;
            if ($result->status == 1) {
                $payload = $result->payload;
                $resultsCount = count($payload);
                $aaData = [];
                $i = 1;
                foreach ($payload as $key => $row) {
                    $code = '';
                    if ($row->courier_id != 22) {
                        $code = '<a class="view-codes" style="color: #ba0c2f !important; width:15px" href="javascript:void(0);" data-id="' . $row->id . '" data-route="' . route('admin.add_edit_courier_code', ['id' => $row->id]) . '" data-toggle="tooltip" title="View Codes"><i class="fa fa-list" aria-hidden="true"></i></a>';
                    }
                    $actions =
                        '<div class="action-perform-btns">
                    ' .
                        $code .
                        '
                <a type="button" style="color: #ba0c2f !important;" href="javascript:void(0);" data-id="' .
                        $row->id .
                        '" data-route="' .
                        route('admin.add_edit_couriers') .
                        '" class="edit-item" data-toggle="tooltip" title="Edit" odidcn="28"><img src="' .
                        asset('assets/icons/Edit.svg') .
                        '" width="15" alt="Edit"></a>
              <a table="courier_details" class="delete" style="color: #ba0c2f !important;" href="javascript:void(0);" data-id="' .
                        $row->id .
                        '" data-toggle="tooltip" title="Delete"><img src="' .
                        asset('assets/icons/Delete.svg') .
                        '" width="15" alt="Delete"></a>
          </div>';
                    $aaData[] = [
                        'SNO' => ++$key,
                        'COURIER' => $row->courier_name,
                        'ACCTITLE' => $row->account_title,
                        'ACCNO' => $row->account_no,
                        'USER' => $row->user,
                        'ACTIONS' => $actions,
                    ];
                    $i++;
                    $resultsCount++;
                }
            } else {
                $aaData[] = [
                    'SNO' => '',
                    'COURIER' => '',
                    'ACCTITLE' => '',
                    'ACCNO' => '',
                    'USER' => '',
                    'ACTIONS' => '',
                ];
            }
            $arraylist = [
                'TotalRecords' => $resultsCount,
                'aaData' => $aaData,
            ];
            echo json_encode($arraylist);
        }
    }
    public function add_edit_couriers(Request $request, $id = null)
    {
        if ($request->isMethod('POST') && isset($request->type) && $request->type == 'edit_modal') {
            $couriers = get_all_couriers();
            $account_id = $request->id;
            $data = compact('account_id');
            $result = getAPIdata('couriers_details/single', $data);
            $payload = $result->payload;
            extract((array) $payload);
            $return =
                '<form id="edit_sales_men_from" enctype="multipart/form-data">
                <input type="hidden" name="_token" value="' .
                csrf_token() .
                '" autocomplete="off">
                <div class="form-row">
                    <div class="mb-3 col-md-6">
                    <label class="form-label" for="city_id" id="">Select Courier<span class="req">*</span></label>
                    <select required
                        class=" form-control form-select city_id form-control-lg input_field "
                        id="courier_id" data-toggle="select2" name="courier_id" size="1"
                        label="Select Courier" data-placeholder="Select Courier" data-allow-clear="1">
                        <option value="">Select Courier</option>';
            foreach ($couriers as $courier) {
                $return .= '<option value="' . $courier->id . '" ' . (isset($payload->courier_id) && $courier->id == $payload->courier_id ? 'selected' : '') . '>' . $courier->courier_name . '</option>';
            }
            $return .=
                '</select>
                </div>
                <div class="col-md-6">
                        <label for="inputEmail4">Account Title<span class="req">*</span></label>
                        <input type="text" name="account_title" value="' .
                $account_title .
                '" class="form-control"
                            id="account_title" label="Account Title" required placeholder="Account Title">
                    </div>
                    <div class="col-md-6">
                        <label for="inputEmail4">Account No<span class="req">*</span></label>
                        <input type="text" name="account_no" value="' .
                $account_no .
                '" class="form-control"
                            id="account_no" label="Account No" required placeholder="Account No">
                    </div>
                    <div class="col-md-6">
                        <label for="inputEmail4">User<span class="req">*</span></label>
                        <input type="text" name="user" value="' .
                $user .
                '" class="form-control"
                            id="user" label="user" required placeholder="User">
                    </div>
                    <div class="col-md-6 mt-3">
                        <label for="inputEmail4">Password<span class="req">*</span></label>
                        <input type="password" name="password" value="' .
                $password .
                '"
                            class="form-control passwordField" id="password" label="Password" placeholder="Password">
                        <span class="show_pass_btn"><i class="fa-regular fa-eye"></i></span>
                    </div>
                    <div class="col-md-6 mt-3">
                        <label for="inputEmail4">API Key</label>
                        <input type="text" name="api_Key"
                            value="' .
                $api_key .
                '" class="form-control passwordField" id="api_Key"
                            label="API Key" placeholder="API Key">
                    </div>
                <input type="hidden" name="id" value="' .
                $id .
                '">
                <input type="hidden" class="url" value="' .
                route('admin.add_edit_couriers') .
                '">
            </form> ';

            return response()->json($return);
        }
        $request->validate([
            'user' => 'required',
            'courier_id' => 'required',
            'account_no' => 'required',
            'account_title' => 'required',
        ]);
        // to manage the insert and update function
        if ($request->isMethod('POST') && $request->id == null) {
            $common = app(commonController::class);
            $request->validate([
                'password' => 'required',
            ]);
            $courier_id = $request->courier_id;
            $account_title = $request->account_title;
            $account_no = $request->account_no;
            $user = $request->user;
            $api_Key = $request->api_Key;
            $password = $request->password;
            $company_id =  (int) session('company_id');
            $param = ['courier_id' => $courier_id, 'account_no' => $account_no, 'account_user' => $user, 'account_password' => $password, 'apikey' => $api_Key];
            $api_check = $common->courier_authenticate($param);
            if ($api_check->original['status'] == 1) {
                $data = compact('company_id', 'courier_id', 'user', 'account_no', 'account_title', 'password', 'api_Key');
                $result = getAPIdata('couriers_details/add', $data);
                // $result = getAPIJson('couriers_details/add', $data);
                // dd($result);
                $return = ['status' => $result->status, 'message' => $result->message, 'payload' => $result->payload];
                return response()->json($return);
            } else {
                $return = ['status' => 0, 'message' => 'Invalid credential', 'payload' => 'The api credentials are not valid'];
                return response()->json($return);
            }
        } elseif (isset($request->id) && $request->id != null && $request->isMethod('POST')) {
            $data = $request->only(['user', 'courier_id', 'account_no', 'account_title', 'api_Key', 'id']);
            if ($request->password) {
                $data['password'] = $request->password;
            }
            $result = getAPIdata('couriers_details/update', $data);
            // $result = getAPIJson('couriers_details/update', $data);
            // dd($result);
            $return = ['status' => $result->status, 'message' => $result->message, 'payload' => $result->payload];
            return response()->json($return);
        }
    }
    public function add_edit_courier_code(Request $request, $id = null)
    {
        if ($request->isMethod('POST') && isset($request->type) && $request->type == 'edit_modal') {
            $id = $request->id;
            $data = compact('id');
            $result = getAPIdata('couriers_details/code-single', $data);
            $payload = $result->payload;
            // dd($payload);
            $return = '
            <table class="example2 display nowrap table table-hover mt-4" width="100%">
            <thead class="thead">
                <tr>
                    <th>SNO</th>
                    <th>Account</th>
                    <th>CODE</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="tarif_display">';
            if (count($payload) > 0) {
                foreach ($payload as $key => $rows) {
                    $return .=
                        '<tr>
                <td>' .
                        ++$key .
                        '</td>
                <td>' .
                        $rows->account_title .
                        '</td>
                <td>
                    <input type="text" name="code" class="form-control"
                        id="code" label="code" value="' .
                        $rows->code .
                        '" required placeholder="Code">
                </td>
                <td>
                <button type="button" href="javascript:void(0);" data-id="' .
                        $rows->id .
                        '" data-route="' .
                        route('admin.add_edit_courier_code') .
                        '" class="edit-code btn btn-sm btn-orio" data-toggle="tooltip" title="Update">Update</button>
                </td>
            </tr>';
                }
            } else {
                $return .= '<tr>
                <td colspan="4">
                    No codes found
                </td>
            </tr>';
            }
            $return .= '
            </tbody>
            </tabel> ';

            return response()->json($return);
        }

        // to manage the insert and update function
        if ($request->isMethod('POST') && $request->id == null) {
            $request->validate([
                'account_id' => 'required',
                'code' => 'required',
            ]);
            $company_id = session('company_id');
            $account_id = $request->account_id;
            $code = $request->code;
            $data = compact('company_id', 'account_id', 'code');
            $result = getAPIdata('couriers_details/add-code', $data);
            // $result = getAPIJson('couriers_details/add', $data);
            // dd($result);
            $return = ['status' => $result->status, 'message' => $result->message, 'payload' => $result->payload];
            return response()->json($return);
        } elseif (isset($request->id) && $request->id != null && $request->isMethod('POST')) {
            $request->validate([
                'code' => 'required',
            ]);
            $data = $request->only(['id', 'code']);
            // dd($data);
            $result = getAPIdata('couriers_details/code-update', $data);
            // $result = getAPIJson('couriers_details/code-update', $data);
            // dd($result);
            $return = ['status' => $result->status, 'message' => $result->message, 'payload' => $result->payload];
            return response()->json($return);
        }
    }
    // load sheets
    public function loadsheets(Request $request)
    {
        if ($request->isMethod('GET')) {
            $title = 'Load Sheets';
            if (is_portal()) {
                $fetch_sub_acc = get_customers_sub(session('acno'));
                $sub_accounts = $fetch_sub_acc->original;
            } else {
                $sub_accounts = [];
            }
            $data = compact('title', 'sub_accounts');
            return view('shipments.loadsheet')->with($data);
        }
        if ($request->isMethod('POST')) {
            // dr($request);
            $start_date = $request->start_date;
            $end_date = $request->end_date;
            switch (session('type')) {
                case '6':
                    if ($request->sub_account == '') {
                        $prams = ['acno' => session('acno')];
                        $get_childs = getAPIdata('common/getSubAccounts', $prams);
                        $sub_account_acnos = $get_childs->payload ?? '';
                        $customer_acno = $sub_account_acnos != '' ? session('acno') . ',' . $sub_account_acnos : session('acno');
                    } else {
                        $customer_acno = isset($request->sub_account) ? implode(',', $request->sub_account) : '';
                    }
                    break;
                case '7':
                    $customer_acno = session('acno');
                    break;
            }

            $data = compact('start_date', 'end_date', 'customer_acno');
            $result = getAPIdata('loadSheets/index', $data);
            $aaData = [];
            $i = 1;
            $resultsCount = 0;
            if ($result->status == 1) {
                $payload = $result->payload;
                $resultsCount = count($payload);
                $aaData = [];
                $i = 1;
                foreach ($payload as $key => $row) {
                    $actions =
                        '<div class="action-perform-btns">
                 <a style="color: #ba0c2f !important;" target="_blank" href="' .
                        route('admin.loadsheet-pdf', ['id' => $row->sheet_no]) .
                        '" class="" odidcn="28"><img src="' .
                        asset('images/default/svg/print.svg') .
                        '" width="15" alt="Print"></a>
           </div>';
                    $aaData[] = [
                        'SNO' => ++$key,
                        'SHEET' => $row->sheet_no,
                        'DATE' => Carbon::parse($row->created_at)->format('d-m-Y'),
                        'SHIPMENT' => $row->cn_count,
                        'PICKUP' => $row->pickup_location,
                        'CITY' => $row->pickup_city,
                        'ACCTYPE' => $row->parent_id === '0' || $row->parent_id == '' ? 'Main Account' : 'Sub Account',
                        'ACTION' => $actions,
                    ];
                    $i++;
                    $resultsCount++;
                }
            }
            $arraylist = [
                'TotalRecords' => $resultsCount,
                'aaData' => $aaData,
            ];
            echo json_encode($arraylist);
        }
    }
    public function create_loadsheet(Request $request)
    {
        $data = ['company_id' => session('company_id'), 'created_by' => session('logged_id'), 'consignments_array' => $request->order_ids];
        $result = getAPIdata('loadSheets/add', $data);
        $return = ['status' => $result->status, 'message' => $result->payload];
        return response()->json($return);
    }
    // tracking
    public function tracking()
    {
        $title = 'Tracking';
        $data = compact('title');
        return view('single_page_modules.tracking')->with($data);
    }
    public function get_tracking_data(Request $request)
    {
        if ($request->ajax()) {
            $request->validate([
                'cn_no' => 'required',
            ]);
            $cn_numbers = $request->cn_no;
            $params = compact('cn_numbers');
            $result = getAPIdata('tracking/index', $params);
            $modal = $html = '';
            if ($result->status == 1) {
                foreach ($result->payload as $data) {
                    $traking_data = '';
                    foreach ($data->tracking_info as $more_info) {
                        $html .=
                            '
                            <div><span class="border-bottom">' .
                            Carbon::parse($more_info->created_datetime)->format('d-m-Y h:i: A') .
                            ' - ' .
                            $more_info->status_name .
                            ' - ' .
                            ($more_info->tpl_message == '' ? $more_info->status_message : $more_info->tpl_message) .
                            '</span></div>
                        ';
                    }
                    $modal .=
                    '
                        <div class="w-100">
                            <div style="justify-content: start !important;" class="main_detail ticketinfowrap clearfix">
                                <div class="infodiv">
                                    <span class="boldspan" style="font-weight: 600;">CN# </span>
                                    <br>
                                    <span class="boldbl" style="font-size: 14px;font-weight: 400;">' .$data->shipment_no .'</span>
                                    </div>
                                    <div class="infodiv">
                                        <span class="boldspan" style="font-weight: 600;">BOOKING DATE</span>
                                        <br>
                                        <span>' . Carbon::parse($data->booking_date)->format('d-m-Y h:i: A') . '</span>
                                    </div>
                                    <div class="infodiv">
                                        <span class="boldspan" style="font-weight: 600;">CUSTOMER</span>
                                        <br>
                                        <span  class="boldbl" style="font-size: 14px;font-weight: 400;">'.$data->customer_name.' ('.$data->customer_account.')' .'</span>
                                    </div>
                                    <div class="infodiv">
                                        <span class="boldspan" style="font-weight: 600;">SHIPMENT REF</span>
                                        <br>
                                        <span class="d-block" style="margin-bottom:8px;" >' . $data->shipment_referance . '</span>
                                    </div>
                                    <div class="infodiv">
                                        <span class="boldspan" style="font-weight: 600;">FROM TO</span>
                                        <br>
                                        <span class="boldbl" style="font-size: 14px;font-weight: 400;">'. $data->origin_city .' &nbsp;<i class="fa fa-arrows-h"></i>&nbsp; ' .$data->destination_city .'</span>
                                    </div>
                                </div>
                            </div>
                            <div class="ordertrackingdetail p-3">
                                <div class="popheading">
                                    <h5 class="display-5 my-1 font-weight-bold">TRACKING DETAILS: <span class="cn_div"></span>
                                    </h5>
                                </div>
                                <div class="track-details">
                                    '.$html.'
                                </div>
                            </div>
                        </div>
                    ';
                }

                $return = ['status' => $result->status, 'message' => $result->message, 'payload' => $modal];
                return response()->json($return);
            } else {
                $return = ['status' => $result->status, 'message' => $result->message, 'payload' => $result->payload];
                return response()->json($return);
            }
        }
    }
    //  ----------- end tracking

    // Shipper Advice
    public function shipper_advice(Request $request)
    {
        if ($request->isMethod('GET')) {
            $title = 'Shipper Advice';
            $customers_function = get_customers();
            $customers = $customers_function->original['payload'];
            $data = compact('title', 'customers');
            return view('shipper-advice.index')->with($data);
        }
        if ($request->isMethod('POST')) {
            $company_id = session('company_id');
            $start_date = $request->start_date;
            $end_date = $request->end_date;
            $status_id = $request->shipment_status;
            $tableId = $request->tableId;
            if (is_portal() && $request->customer_acno == '') {
                $customer_acno = session('acno');
            } elseif (is_customer_sub()) {
                $customer_acno = session('acno');
            } else {
                $customer_acno = $request->customer_acno;
            }
            $data = compact('company_id', 'start_date', 'end_date', 'customer_acno', 'status_id');
            $result = getAPIdata('shipper-advise/index', $data);
            // dd($data);
            $aaData = [];
            $i = 1;
            $resultsCount = 0;
            if ($result->status == 1) {
                $payload = $result->payload;
                $resultsCount = count($payload);
                $aaData = [];
                $i = 1;
                foreach ($payload as $key => $row) {
                    $status_class = ' badge-neutral-' . getStatusBadge($row->status) . ' text-' . getStatusBadge($row->status);
                    $statusBadge = '<button table="" data-id="' . $row->id . '" data-status="" class="btn badge badge-pill' . $status_class . '">' . $row->status_name . '</button>';
                    $action_btn = '';
                    if ($row->status == 15) {
                        $action_btn =
                            '
                        <a style="color: #ba0c2f !important;" href="javascript:void(0)" data-consignment_no="' .
                            $row->consignment_no .
                            '" class="chat_modal" data-toggle="tooltip" title="Start Chat"><i data-toggle="tooltip" title="Start Chat" class="fas fa-envelope-open"></i></a>
                        <a href="javascript:void(0)" data-id="' .
                            $row->id .
                            '" class=" re_attempt" data-toggle="tooltip" title="Edit"><i data-toggle="tooltip" title="Edit" class="fa-solid fa-rotate-right"></i></a>
                        <a href="javascript:void(0)" table="shipments" data-dataTabel="' .
                            $tableId .
                            '" data-id="' .
                            $row->id .
                            '" data-status="' .
                            ($row->status == '15' ? '16' : '') .
                            '" class="status_btn"><i class="fas fa-close"></i></a>

                        ';
                    }

                    $actions =
                        '<div class="action-perform-btns">
                  ' .
                        $action_btn .
                        '
                    </div>';

                    $checkBox =
                        '<div class="custom-control custom-checkbox">
                    <input data-status="' .
                        $row->status .
                        '" type="checkbox" class="custom-control-input check_box" name="checked_id[]" data-customer-id="' .
                        $row->customer_acno .
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
                    } else {
                        $account = $row->account_no;
                    }
                    $aaData[] = [
                        'CHECK' => $checkBox,
                        'SNO' => ++$key,
                        'ACNO' => $account,
                        'BUSINESSNAME' => $row->business_name,
                        'CN' => $row->consignment_no,
                        'NAME' => $row->consignee_name,
                        'EMAIL' => $row->consignee_email,
                        'PHONE' => $row->consignee_phone,
                        'SHIPREF' => $row->shipment_referance,
                        'DESTINATION' => country_name($row->destination_country),
                        'ADDRESS' => $row->consignee_address,
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
            $arraylist = [
                'TotalRecords' => $resultsCount,
                'aaData' => $aaData,
            ];
            echo json_encode($arraylist);
        }
    }

    public function chats_shipper_advice(Request $request)
    {
        // dd($request->all());
        $company_id = session('company_id');
        $consignment_no = $request->consignment_no;
        $data = compact('company_id', 'consignment_no');
        $result = getAPIdata('shipper-advise/single', $data);
        $html = '';
        if ($result->status == 1) {
            $payload = $result->payload;
            if (count($payload) > 0) {
                foreach ($payload as $key => $data) {
                    $html .=
                        '
                    <div class="chat-item ' .
                        ($data->user_id == session('logged_id') ? 'chat-item-reverse' : '') .
                        '  p-2 mb-2">
                        <div class="align-box-row ' .
                        ($data->user_id == session('logged_id') ? 'flex-row-reverse' : '') .
                        '">
                            <div class="avatar-icon-wrapper avatar-icon-lg align-self-start">
                                <div class="avatar-icon rounded border-0">
                                    <img src="' .
                        asset('images/default/svg/avatar.svg') .
                        '" alt="">
                                </div>
                            </div>
                            <div>
                                <div class="text-primary">
                                    <p class="m-0">' .
                        $data->chat .
                        '</p>
                                </div>
                                <small class="mt-2 d-block text-black-50">
                                    <i class="fas fa-clock mr-1 opacity-5"></i>
                                    ' .
                        Carbon::parse($data->created_at)->format('d-M-Y h:i:A') .
                        '
                                    <br>
                                    ' .
                        $data->first_name .
                        '
                                </small>
                            </div>
                        </div>
                    </div>
                    ';
                }
            } else {
                $html = '<h6>Start conversation</h6>';
            }
        }
        $return = ['status' => $result->status, 'message' => $result->message, 'payload' => $html];
        return response()->json($return);
    }

    public function store_shipper_advice(Request $request)
    {
        $company_id = session('company_id');
        $consignment_no = $request->consignment_no;
        $message = $request->msg;
        $sender_id = session('logged_id');
        $data = compact('company_id', 'consignment_no', 'message', 'sender_id');
        $result = getAPIdata('shipper-advise/add', $data);
        $return = ['status' => $result->status, 'message' => $result->message, 'payload' => $result->payload];
        return response()->json($return);
    }

    // ops sub users
    // list sub - users
    public function sub_users(Request $request)
    {
        if ($request->isMethod('GET')) {
            $title = 'Sub Users';
            $data = compact('title');
            return view('sub-users.sub_users')->with($data);
        }
        if ($request->isMethod('POST')) {
            $company_id = session('company_id');
            $start_date = $request->start_date;
            $end_date = $request->end_date;
            $data = compact('company_id', 'start_date', 'end_date');
            $result = getAPIdata('ops-sub-users/index', $data);
            $aaData = [];
            $i = 1;
            $resultsCount = 0;
            if ($result->status == 1) {
                $payload = $result->payload;
                $resultsCount = count($payload);
                $aaData = [];
                $i = 1;
                foreach ($payload as $key => $row) {
                    $statusBadgeClass = $row->active == 1 ? ' badge-neutral-success text-success' : ' badge-neutral-danger text-danger';
                    $statusBadge = '<button table="employees" data-id="' . $row->id . '" data-status="' . ($row->active == 1 ? '0' : '1') . '" class="status_btn btn badge badge-pill' . $statusBadgeClass . '">' . ($row->active == 1 ? 'Active' : 'Inactive') . '</button>';
                    $actions =
                        '<div class="action-perform-btns">
                    <a style="color: #ba0c2f !important;" href="' .
                        route('ops.add-edit-sub-users', ['id' => $row->id]) .
                        '" class="" data-toggle="tooltip" title="Edit"><img src="' .
                        asset('assets/icons/Edit.svg') .
                        '" width="15" alt="Edit"></a>
                  <a table="employees" class="delete" style="color: #ba0c2f !important;" href="javascript:void(0);" data-id="' .
                        $row->id .
                        '" data-toggle="tooltip" title="Delete"><img src="' .
                        asset('assets/icons/Delete.svg') .
                        '" width="15" alt="Delete"></a>
              </div>';
                    $aaData[] = [
                        'SNO' => ++$key,
                        'DEP' => $row->department,
                        'NAME' => $row->first_name,
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
            $arraylist = [
                'TotalRecords' => $resultsCount,
                'aaData' => $aaData,
            ];
            echo json_encode($arraylist);
        }
    }
    public function add_edit_sub_user(Request $request, $id = null)
    {
        // to manage the add and edit view page
        get_all_banks();
        $countries = get_all_countries();
        $departments = getAPIdata('common/getDepartments', ['company_id' => session('company_id')]);
        if ($request->isMethod('GET')) {
            if ($id == null && $request->isMethod('GET')) {
                $title = 'Add Sub User';
                $type = 'add';
                $data = compact('title', 'type', 'countries', 'departments');
                return view('sub-users.add_sub_users')->with($data);
            } elseif ($id != null && $request->isMethod('GET')) {
                $cities = get_all_cities();
                $title = 'Edit Sub User';
                $employee_id = $request->id;
                $params = [
                    'company_id' => session('comapny_id'),
                    'employee_id' => $employee_id,
                ];
                $result = getAPIdata('ops-sub-users/single', $params);
                $payload = $result->payload;
                $type = 'edit';
                $data = compact('payload', 'cities', 'type', 'title', 'id', 'countries', 'departments');
                return view('sub-users.add_sub_users')->with($data);
            }
        }
        // to manage the insert and update function
        if ($request->isMethod('POST')) {
            $request->validate([
                'name' => 'required',
                'user_name' => 'required',
                'phone' => 'required',
                'email' => 'required|email',
                'address' => 'required',
                'country_id' => 'required',
                'department_id' => 'required',
                'city_id' => 'required',
            ]);
            // for add
            if ($id == null && $request->isMethod('POST')) {
                $request->validate([
                    'password' => 'required',
                ]);
                $data = $request->only(['name', 'user_name', 'phone', 'email', 'country_id', 'city_id', 'department_id', 'address', 'password']);
                $data['company_id'] = session('company_id');
                $data['token'] = $token = Str::random(25);
                $result = getAPIdata('ops-sub-users/add', $data);
                if ($result->status == '1') {
                    $data = [
                        'co_name' => session('company_name'),
                        'user_name' => $request->user_name,
                        'password' => $request->password,
                    ];
                    $send_mail = app(emailController::class);
                    $check = $send_mail->activation($request->email, $token . ':' . time() . '|' . base64_encode('customers'), '7', $data);
                }
                $return = ['status' => $result->status, 'message' => $result->message, 'payload' => $result->payload];
                return response()->json($return);
            } elseif ($id != null && $request->isMethod('POST')) {
                $data = $request->only(['name', 'phone', 'email', 'country_id', 'city_id', 'address', 'department_id', 'password']);
                if ($request->password != '') {
                    $request->validate([
                        'password' => 'required',
                    ]);
                    $data['password'] = $request->password;
                }

                if ($request->user_name != $request->old_user_name) {
                    $data['user_name'] = $request->user_name;
                } else {
                    $data['user_name'] = '';
                }

                $data['company_id'] = session('company_id');
                $data['employee_id'] = $id;
                $result = getAPIdata('ops-sub-users/update', $data);
                // $result = getAPIJson('ops-sub-users/update', $data);
                // dd($result);
                $return = ['status' => $result->status, 'message' => $result->message, 'payload' => $result->payload];
                return response()->json($return);
            }
        }
    }
    
    public function city_list(Request $request)
    {
        if ($request->isMethod('GET')) {
            $title = 'City List';
            $countries = get_all_countries();
            $data = compact('title', 'countries');
            return view('single_page_modules.cities-list')->with($data);
        }
        if ($request->isMethod('POST')) {
            $country_id = $request->country_id;
            $all_cities = get_all_cities();
            $cities = collect($all_cities)->where('country_id', (int) $country_id);
            if ($cities instanceof \Illuminate\Support\Collection) {
                $cities = $cities->values()->toArray();
            }
            $aaData = [];
            $resultsCount = 0;
            if (count($cities) > 0) {
                $resultsCount = count($cities);
                foreach ($cities as $key => $row) {
                    $aaData[] = [
                        'SNO' => ++$key,
                        'CITYNAME' => $row->city,
                        'COUNTRYCODE' => $row->country_id,
                        'CITYID' => $row->id,
                        'ZONE' => $row->zone??' - ',
                    ];
                    $resultsCount++;
                }
            }
            $arraylist = [
                'TotalRecords' => $resultsCount,
                'aaData' => $aaData,
            ];
            echo json_encode($arraylist);
        }
    }
}
