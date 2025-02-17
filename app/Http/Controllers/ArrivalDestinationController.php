<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Facades\Excel;

class ArrivalDestinationController extends Controller
{
    // This is for Our arival but marked as pickup (arrival ar origin) 
    public function arrivals(Request $request)
    {
        if ($request->isMethod('GET')) {
            $title = "Arrivals";
            $data = compact("title");
            return view("arival-destination.arivals")->with($data);
        }
        if ($request->isMethod('POST')) {
            $start_date = $request->start_date;
            $end_date = $request->end_date;
            $company_id = session('company_id');
            $data = compact('start_date', 'end_date', 'company_id');
            $result = getAPIdata('arrival-destination/index', $data);
            // $result = getAPIJson('arrival-destination/index', $data);
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
                    //   <a data-bs-toggle="tooltip" data-bs-placement="top" title="Edit" style="color: #ba0c2f !important;" href="' . route('admin.add_edit_arrivals', ['id' => $row->arrival_no]) . '" class="" odidcn="28"><img src="' . asset('images/default/svg/edit.svg') . '" width="15" alt="EDIT"></a>
                    $actions = '<div class="action-perform-btns">
                      <a style="color: #ba0c2f !important;" target="_blank" href="' . route('admin.arrivalsheet-pdf', ['id' => $row->arrival_no]) . '" class="" data-toggle="tooltip" title="Print"><img src="' . asset('images/default/svg/print.svg') . '" width="15" alt="Print"></a>
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
        if (session('company_type') == 'D') {
            $riders = $commonController->get_riders_dropdown();
        } else {
            $riders = [];
        }
        if ($request->isMethod('GET')) {
            if ($id == null && $request->isMethod('GET')) {
                $title = "Add Arrival";
                $type = "add";
                $stations = json_decode(getAPIJson('stations/index', ['company_id' => session('company_id')]));
                $routes = json_decode(getAPIJson('routes/index', ['company_id' => session('company_id')]));
                $data = compact("title", "type", "cities", "stations", "routes", "riders");
                return view("arival-destination.add-arivals")->with($data);
            } elseif ($id != null && $request->isMethod('GET')) {
                $cities = get_all_cities();
                $title = "Edit Arrival";
                $company_id = session('company_id');
                $arrival_no = $request->id;
                $param = compact('company_id', 'arrival_no');
                $result = getAPIdata('arrival-destination/single', $param);
                $arrivals = $result->payload;
                $type = "edit";
                $data = compact('type', 'title', 'arrivals', "cities", "riders");
                return view('arival-destination.edit-arivals')->with($data);
            }
        }
        // edit arrival sheet
        if ($request->isMethod('POST')) {
            // dr($request);
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
                // dd($data);
                $result = getAPIdata('arrival-destination/update', ['company_id' => session('comapny_id'), 'updated_by' => session('logged_id'), 'data' => $data]);
                // dd($result);
                // $arrivals = $result->payload;
                $return = ['status' => $result->status, 'message' => $result->message, 'payload' => $result->payload];
                return response()->json($return);
            }
        }
    }
    // the ajax to fetch the data of the consignment no
    public function fetch_arival_cn(Request $request)
    {
        $company_id = session('company_id');
        if ($request->file('excel_file')) {
            $html = "";
            $file = $request->file('excel_file');
            $data = Excel::toArray([], $file);
            $headerRow = $data[0][0];
            if ($headerRow[0] == "Consignment No") {
                $excelData = array_slice($data[0], 1);
                foreach ($excelData as $key => $value) {
                    $length = Str::length($value[0]);
                    if ($length >= '9') {
                        $cn_number = $value[0];
                        $data = compact('company_id', 'cn_number');
                        $result = getAPIdata('arrival-destination/getData', $data);
                        if ($result->status == 1) {
                            $payload = $result->payload;
                            $html .= $this->append_html($payload);
                        }
                    }
                }
                if ($html != "") {
                    $return = ['status' => 1, 'message' => 'success', 'payload' => $html];
                    return response()->json($return);
                } else {
                    $return = ['status' => 0, 'message' => $result->message, 'payload' => $result->payload];
                    return response()->json($return);
                }
            }
        } else {
            $cn_number = $request->shipment_no;
            $data = compact('company_id', 'cn_number');
            $result = getAPIdata('arrival-destination/getData', $data);
            if ($result->status == 1) {
                $payload = $result->payload;

                $html = $this->append_html($payload);
                $return = ['status' => 1, 'message' => 'success', 'payload' => $html];
                return response()->json($return);
            } else {
                $return = ['status' => 0, 'message' => $result->message, 'payload' => $result->payload];
                return response()->json($return);
            }
        }
    }
    // for add and edit the arrivals
    public function insert_arival(Request $request)
    {
        // $rider_id = $request->rider_id;
        // $route_id = $request->route_id;
        $station_id = $request->station_id;
        $created_by = session('logged_id');
        $company_id = session('company_id');
        $data = $request->data;
        $params = compact('company_id', 'station_id', 'created_by', 'data');
        // dd($params);
        $result = getAPIdata('arrival-destination/add', $params);
        $cn_arr = [];
        if ($result->status == 1) {
            $error_array = $result->payload->error;
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

    private function append_html($payload)
    {
        $html = "";
        foreach ($payload as $records) {
            $data = (array) $records;
            extract($data);
            $actions = '<div class="action-perform-btns">
            <a class="rem_row" style="color: #ba0c2f !important;" href="javascript:void(0);" data-bs-toggle="tooltip" data-id="' . $consignment_no . '" data-bs-placement="top" title="Delete"><img src="' . asset('images/default/svg/delete.svg') . '" width="15" alt="Delete" ></a>
            </div>';
            $html .= '<tr>
                                    <td class="cn_no">' . $consignment_no . '</td>    
                                    <td class="">' . $name . '</td>    
                                    <td class="">' . $consignee_name . '</td>    
                                    <td class="">' . $city . '</td>    
                                    <td class="">' . $shipment_referance . '</td>    
                                    <td><input style="width:150px !important" value="' . $peices_charged . '" minlength="1" maxlength="8" type="text" readonly class="form-control-lg number" name="arrival_peices[]"></td>
                                    <td><input style="width:150px !important" value="' . $weight_charged . '" minlength="1" maxlength="8" type="text" readonly class="form-control-lg float" name="arrival_weight[]"></td>
                                    
                                    <td class="d-none origin_city" data-colum="origin">' . $city_id . '</td>
                                    <td class="d-none destination_city" data-colum="destination">' . $destination_city_id . '</td>
                                    <td class="d-none cod_amt" data-colum="cod">' . $order_amount . '</td>
                                    <td class="d-none service" data-colum="service">' . $service_id . '</td>
                                    <td class="d-none customer_acno" data-colum="customer_acno">' . $customer_acno . '</td>
                                    <td>' . $actions . '</td>    
                                </tr>';

        }
        return $html;

    }
}
