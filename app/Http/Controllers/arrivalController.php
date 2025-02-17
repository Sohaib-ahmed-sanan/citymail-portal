<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class arrivalController extends Controller
{
    // This is for Our arival but marked as pickup (arrival ar origin) 
    public function arrivals(Request $request)
    {
        if ($request->isMethod('GET')) {
            $title = "Pickups";
            $data = compact("title");
            return view("arivals.arivals")->with($data);
        }
        if ($request->isMethod('POST')) {
            $start_date = $request->start_date;
            $end_date = $request->end_date;
            $company_id = session('company_id');
            $data = compact('start_date', 'end_date', 'company_id');
            $result = getAPIdata('arrival-origin/index', $data);
           
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
                 <a data-bs-toggle="tooltip" data-bs-placement="top" title="Edit" style="color: #ba0c2f !important;" href="' . route('admin.add_edit_arrivals', ['id' => $row->arrival_no]) . '" class="" odidcn="28"><img src="' . asset('images/default/svg/edit.svg') . '" width="15" alt="EDIT"></a>
                    <a style="color: #ba0c2f !important;" target="_blank" href="' . route('admin.pickup-sheet-pdf', ['id' => $row->arrival_no]) . '" class="" data-toggle="tooltip" title="Print"><img src="' . asset('images/default/svg/print.svg') . '" width="15" alt="Print"></a>
                 </div>';
                    $aaData[] = [
                        'SNO' => ++$key,
                        'SHEET' => $row->arrival_no,
                        'DATE' => Carbon::parse($row->created_at)->format('d-m-Y'),
                        'CNCOUNT' => $row->arrival_count,
                        'ACTION' => $actions,
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
    public function add_edit_arrivals(Request $request, $id = null)
    {
        $cities = get_all_cities();
        $commonController = app(commonController::class);
        if ($request->isMethod('GET')) {
            if ($id == null && $request->isMethod('GET')) {
                $title = "Add Pickup";
                $type = "add";
                $stations = json_decode(getAPIJson('stations/index', ['company_id' => session('company_id')]));
                $routes = json_decode(getAPIJson('routes/index', ['company_id' => session('company_id')]));
                $data = compact("title", "type", "cities","stations", "routes");
                return view("arivals.add-arivals")->with($data);
            } elseif ($id != null && $request->isMethod('GET')) {
                $cities = get_all_cities();
                $title = "Edit Pickup";
                $company_id = session('company_id');
                $arrival_no = $request->id;
                $param = compact('company_id', 'arrival_no');
                $result = getAPIdata('arrival-origin/single', $param);
                $arrivals = $result->payload;
                $type = "edit";
                $data = compact('type', 'title', 'arrivals',"cities");
                return view('arivals.edit-arivals')->with($data);
            }
        }

        // edit arrival sheet
        if ($request->isMethod('POST')) {
            if ($id == null && $request->isMethod('POST')) {
                $data = array();
                foreach ($request->cn_no as $key => $single_cn) {
                    $data[] = [
                        'cn_number' => $single_cn,
                        'weight' => $request->weight[$key],
                        'peices' => $request->peices[$key],
                        'origin' => $request->origin[$key],
                        'destination' => $request->destination[$key],
                        'cod_amt' => $request->cod_amt[$key],
                        'service_id' => $request->service_id[$key],
                    ];
                }
                $result = getAPIdata('arrival-origin/update', ['company_id' => session('comapny_id'), 'updated_by' => session('logged_id'), 'data' => $data]);
                $return = ['status' => $result->status, 'message' => $result->message, 'payload' => $result->payload];
                return response()->json($return);
            }
        }
    }
    // the ajax to fetch the data of the consignment no
    public function fetch_arival_cn(Request $request)
    {
        $cn_number = $request->shipment_no;
        $company_id = session('company_id');
        $data = compact('company_id', 'cn_number');
        $result = getAPIdata('arrival-origin/getData', $data);
        // dd($result);
        if ($result->status == 1) {
            $payload = $result->payload;
            $html = '';
            $form_inputs = '';
            // if ($request->weight != '' && $request->peice) {
               foreach ($payload as $records) {
                    $actions = '<div class="action-perform-btns">
                            <a class="rem_row" style="color: #ba0c2f !important;" href="javascript:void(0);" data-bs-toggle="tooltip" data-id="' . $cn_number . '" data-bs-placement="top" title="Delete"><img src="' . asset('images/default/svg/delete.svg') . '" width="15" alt="Delete" ></a>
                            </div>';
                    $data = (array) $records;
                    extract($data);
                    $html .= '<tr>
                                <td class="cn_number">' . $cn_number . '</td>    
                                <td>' . $name . '</td>    
                                <td>' . $consignee_name . '</td>    
                                <td>' . $city . '</td>    
                                <td>' . $shipment_referance . '</td>    
                                <td><input style="width:150px !important" value="' . $peices . '" minlength="1" maxlength="8" type="text" class="form-control-lg number" name="arrival_peices[]"></td>
                                <td><input style="width:150px !important" value="' . $weight . '" minlength="1" maxlength="8" type="text" class="form-control-lg float" name="arrival_weight[]"></td>
                                <td>' . $actions . '</td>    
                                <td class="d-none origin_city">' . $result->payload[0]->city_id . '</td>    
                                <td class="d-none origin_country">' . $result->payload[0]->country_id . '</td>    
                                <td class="d-none destination_country">' . $result->payload[0]->destination_country . '</td>    
                                <td class="d-none destination_city">' . $result->payload[0]->destination_city_id . '</td>    
                                <td class="d-none cod_amt">' . $result->payload[0]->order_amount . '</td>    
                                <td class="d-none service_id">' . $result->payload[0]->service_id . '</td>    
                                <td class="d-none customer_acno">' . $result->payload[0]->customer_acno . '</td>    
                            </tr>';
                   
                }
                $return = ['status' => 1, 'message' => 'success', 'payload' => $html];
            // } else {
            //     $return = ['status' => 1, 'message' => 'success', 'weight' => $result->payload[0]->weight, 'peices' => $result->payload[0]->peices];
            // }
            return response()->json($return);
        } else {
            $return = ['status' => 0, 'message' => $result->message, 'payload' => $result->payload];
            return response()->json($return);
        }
    }
    // for add and edit the arrivals
    public function insert_arival(Request $request)
    {
        $data = array();
        foreach ($request->shipments as $key => $ship) {
            $data[] = [
                'cn_number' => $ship['cn_number'],
                'weight' => $ship['arrival_weight'],
                'peices' => $ship['arrival_peices'],
                'origin_city' => $ship['origin_city'],
                'destination_city' => $ship['destination_city'],
                'origin_country' => $ship['origin_country'],
                'destination_country' => $ship['destination_country'],
                'customer_acno' => $ship['customer_acno'],
                'cod_amt' => $ship['cod_amt'],
                'service_id' => $ship['service_id'],
            ];
        }
        // $rider_id = $request->rider_id;
        // $route_id = $request->route_id;
        $station_id = $request->station_id;
        $created_by = session('logged_id');
        $company_id = session('company_id');
        $params = compact('company_id','station_id','created_by','data');
        // dd($params);
        $result = getAPIdata('arrival-origin/add', $params);
        // $result = getAPIJson('arrival-origin/add', $params);
        // dd($result);
        if ($result->status == 1) {
            $error_array = $result->payload->error;
            $cn_arr = [];
            if (count($error_array) > 0) {
                foreach ($error_array as $cn) {
                    $cn_arr[] = $cn->consignment_no;
                }
            }
            $return = ['status' => $result->status, 'message' => $result->message . implode(',', $cn_arr), 'sheet_no' => $result->payload->sheet_id];
        } else {
            $return = ['status' => $result->status, 'message' => $result->message, 'payload' => $result->payload];
        }
        return response()->json($return);

    }
}
