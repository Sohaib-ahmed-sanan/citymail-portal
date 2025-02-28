<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class internationalTarrifController extends Controller
{
    public function international_tarrifs(Request $request)
    {
        if ($request->isMethod('GET')) {
            $title = 'International Tarrif';
            $data = compact('title');
            return view('international-tarrifs.index')->with($data);
        }
        if ($request->isMethod('POST')) {
            $company_id = (int) session('company_id');
            $start_date = $request->start_date;
            $end_date = $request->end_date;
      
            $data = compact('company_id','start_date','end_date');
            $result = getAPIdata('international-tarrif/index', $data);
            $aaData = [];
            $i = 1;
            $resultsCount = 0;
            if ($result->status == 1) {
                $payload = $result->payload;
                $resultsCount = count($payload);
                foreach ($payload as $key => $row) {
                  
                    $actions =
                        '<div class="action-perform-btns">
                            <a href="'. route('admin.view-international-tarrif', ['id' => $row->service_id]).'"
                                data-toggle="tooltip" title="View Details">
                                <i class="fa-solid fa-eye"></i>
                            </a>
                        </div>';
                    $aaData[] = [
                        'SNO' => ++$key,
                        'Service' => $row->service_name,
                        'COUNT' => $row->tariff_count,
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
    public function view_international_tarrif(Request $request, $id = null)
    {
        if ($request->isMethod('GET')) {
            get_all_services();
            $countries = get_all_countries();
            $title = 'Tarrif Details';
            $data = compact('title','countries');
            return view('international-tarrifs.add-edit')->with($data);
        }
        if ($request->isMethod('POST')) {
            $company_id = (int) session('company_id');
            $service_id = (int) $request->service_id;
            $data = compact('company_id','service_id');
            $result = getAPIdata('international-tarrif/single', $data);
            $aaData = [];
            $i = 1;
            $resultsCount = 0;
            if ($result->status == 1) {
                $payload = $result->payload;
                $resultsCount = count($payload);
                foreach ($payload as $key => $row) {
                    $edit_btn = '';
                    if (is_ops()) {
                        $edit_btn = '<a style="color: #ba0c2f !important;" href="' . route('admin.add_edit-express-shipments', ['id' => $row->id]) . '" class="" data-toggle="tooltip" title="Edit"><img src="' . asset('assets/icons/Edit.svg') . '" width="15" alt="Edit"></a>';
                    }

                    $actions =
                        '<div class="action-perform-btns">
                            <a table="customer_tariffs" class="delete" style="color: #ba0c2f !important;" href="javascript:void(0);" data-id="' . $row->id . '" data-toggle="tooltip" title="Delete" ><img src="' . asset('assets/icons/Delete.svg') . '" width="15" alt="Delete"></a>
                        </div>';
                    $checkBox =
                        '<div class="custom-control custom-checkbox">
                            <input type="checkbox" data-flag="'.$row->flag.'" data-service-id="'.$row->service_id.'" class="custom-control-input check_box" 
                            name="checked_id[]" value="'.$row->id.'" 
                            id="tarifCheck'.$key.'">
                            <label class="custom-control-label" for="tarifCheck'.$key.'"></label>
                    </div>';

                    $aaData[] = [
                        'SNO' => '<div class="d-flex">'.$checkBox.' '.++$key.'</div>',
                        'Service' => $row->service_name,
                        'Destination' => $row->country_name,
                        'StartWeight' => '<input type="text" class="form-control float" minlength="1" readonly maxlength="4" data-parsley-type="number" name="start_weight[]" value="'.$row->start_weight.'" required>',
                        'EndWeight' => '
                         <input type="text" class="form-control float" minlength="1" readonly maxlength="4" data-parsley-type="number" name="end_weight[]" value="'.$row->end_weight.'" required>',
                        'Charges' => '<input style"min-width: 150px;" type="text" class="form-control float" readonly minlength="1" maxlength="10" data-parsley-type="number" name="charges[]" value="'.$row->charges.'" required>',
                        'ADDWEIGHT' => '<input type="text" class="form-control float" readonly minlength="1" maxlength="10" data-parsley-type="number" name="add_weight[]" value="'.$row->additional_weight.'" required>',
                        'ADDCharges' => '<input type="text" class="form-control float" readonly minlength="1" maxlength="10" data-parsley-type="number" name="add_charges[]" value="'.$row->additional_charges.'" required>',
                        'ACTION' => $actions
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
    public function add_international_charges(Request $request){
        $request->validate([
            "charges" => "required|array",
            "charges.*.service_id" => "required|integer",
            "charges.*.origin_country" => "required|integer",
            "charges.*.destination_country" => "required|integer",
            "charges.*.start_weight" => "required|numeric|min:0",
            "charges.*.end_weight" => "required|numeric|gt:charges.*.start_weight",
            "charges.*.charges" => "required|numeric|min:1",
            "charges.*.additional_weight" => "nullable|numeric|min:0",
            "charges.*.additional_charges" => "nullable|numeric|min:0",
        ]);
        // for tariff
        $tarif_array = array();
        if (isset($request->charges) && count($request->charges) > 0) {
            foreach ($request->charges as $key => $tarifs) {
                $tarif_array['tarif_charges'][] = [
                    "service_id" => isset($tarifs['service_id']) ? $tarifs['service_id'] : '',
                    "region_type" => 'DEF',
                    "origin_country" => isset($tarifs['origin_country']) ? $tarifs['origin_country'] : '',
                    "destination_country" => isset($tarifs['destination_country']) ? $tarifs['destination_country'] : '',
                    "start_weight" => isset($tarifs['start_weight']) ? $tarifs['start_weight'] : '',
                    "end_weight" => isset($tarifs['end_weight']) ? $tarifs['end_weight'] : '',
                    "charges" => isset($tarifs['charges']) ? $tarifs['charges'] : '',
                    "additional_weight" => isset($tarifs['additional_weight']) && $tarifs['additional_weight'] != '' ? $tarifs['additional_weight'] : 0,
                    "additional_charges" => isset($tarifs['additional_charges']) && $tarifs['additional_charges'] != '' ? $tarifs['additional_charges'] : 0,
                    "flag" => 1,
                ];
            }
        }
       
        if(count($tarif_array) > 0){
            $data['charges'] = $tarif_array;
            $data['module'] = 'express';
            $data['created_by'] = session('logged_id');
            $result = getAPIdata('customers/addCharges', $data);
            $return = ['status' => $result->status, 'message' => $result->message,'payload' => $result->payload];
        }else{
            $return = ['status' => 0, 'message' => 'No data to insert'];
        }
        return response()->json($return);

    }

    public function update_international_charges(Request $request){
       
        $request->validate([
            "values" => "required|array",
            "values.*.tarrif_id" => "required|integer",
            "values.*.service_id" => "required|integer",
            "values.*.flag" => "required|integer",
            "charges.*.start_weight" => "required|numeric|min:0",
            "charges.*.end_weight" => "required|numeric|gt:charges.*.start_weight",
            "charges.*.charges" => "required|numeric|min:1",
            "charges.*.add_weight" => "nullable|numeric|min:0",
            "charges.*.add_charges" => "nullable|numeric|min:0",
        ]);
        $tarif_array = array();
        if (isset($request->values) && count($request->values) > 0) {
            foreach ($request->values as $key => $tarifs) {
                $tarif_array['tarif_charges'][] = [
                    "id" => isset($tarifs['tarrif_id']) ? $tarifs['tarrif_id'] : '',
                    "service_id" => isset($tarifs['service_id']) ? $tarifs['service_id'] : '',
                    "region_type" => 'DEF',
                    "start_weight" => isset($tarifs['start_weight']) ? $tarifs['start_weight'] : '',
                    "end_weight" => isset($tarifs['end_weight']) ? $tarifs['end_weight'] : '',
                    "charges" => isset($tarifs['charges']) ? $tarifs['charges'] : '',
                    "additional_weight" => isset($tarifs['add_weight']) && $tarifs['add_weight'] != '' ? $tarifs['add_weight'] : 0,
                    "additional_charges" => isset($tarifs['add_charges']) && $tarifs['add_charges'] != '' ? $tarifs['add_charges'] : 0,
                    "flag" => 1,
                ];
            }
        }
        if(count($tarif_array) > 0){
            $result = getAPIdata('customers/updateCharges', ['charges' => $tarif_array]);
            $return = ['status' => $result->status, 'message' => $result->message,'payload'=> $result->payload];
            return response()->json($return);
        }else{
            $return = ['status' => 0, 'message' => "No data to update",'payload'=> []];
        }
    }
}
