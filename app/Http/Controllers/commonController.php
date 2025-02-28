<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Artisan;
class commonController extends Controller
{
    public function delete(Request $request)
    {
        $id = $request->id;
        $table = $request->table;
        $data = compact('id', 'table');
        $result = getAPIdata('common/delete', $data);
        $return = ['status' => $result->status, 'message' => $result->message];
        return json_encode($return);
    }

    public function update_status(Request $request)
    {
        $id = $request->id;
        $table = $request->table;
        $status = $request->status;
        $data = compact('id', 'table', 'status');
        // dd($data);
        $result = getAPIdata('common/statusupdate', $data);
        $return = ['status' => $result->status, 'message' => $result->message];
        return json_encode($return);
    }

    public function pickuplocation_specific(Request $request)
    {
        $customer_acno = $request->customer_acno;
        $param = ['company_id' => session('company_id'), 'customer_acno' => $customer_acno];
        $result = getAPIdata('pickupLocation/index', $param);
        if ($result->status == 1) {
            $payload = $result->payload;
            $html = '';
            $html .= '<option value="">Select Pickup Location</option>';
            if (count($payload) > 0) {
                foreach ($payload as $location) {
                    $data = (array) $location;
                    extract($data);
                    $html .= '<option value="' . $id . '" data-location-id="' . $id . '" >' . $title . '</option>';
                }
                $return = ['status' => 1, 'message' => 'success', 'payload' => $html];
            } else {
                $return = ['status' => 2, 'message' => 'error', 'payload' => 'No pickup location found'];
            }
            return response()->json($return);
        }
    }

    public function get_cities(Request $request)
    {
        $country_id = $request->country_id;
        $result = getAPIdata('common/getCities', ['country_id' => $country_id]);
        $return = ['status' => '1', 'payload' => $result];

        return response()->json($return);
    }

    public function get_sub_accounts(Request $request)
    {
        $fetch_sub_acc = get_customers_sub($request->customer_acno);
        $sub_accounts = $fetch_sub_acc->original;
        $html = '';
        $html .= '<option value="">Select Sub Account</option>';
        foreach ($sub_accounts as $sub_account) {
            $html .= '<option value="' . $sub_account->acno . '">' . $sub_account->name . ' (' . $sub_account->acno . ')</option>';
        }
        $return = ['status' => 1, 'message' => 'success', 'payload' => $html];
        return response()->json($return);
    }


    public function get_riders_dropdown()
    {
        $param = ['company_id' => session('company_id'), 'account_type' => session('type'), 'user_id' => session('logged_id'),'type'=>"riders"];
        $result = getAPIdata('common/listings', $param);
        $payload = $result;
        return $payload;
    }
    public function cleare_cache()
    {
        Artisan::call('cache:clear');
        // Clear configuration cache
        Artisan::call('config:clear');
        // Clear route cache
        Artisan::call('route:clear');
        // Clear view cache
        Artisan::call('view:clear');

        return response()->json(200);
    }

    public function order_tracking($cn_number)
    {
        $data = getAPIdata('tpl/manual/status_updates', ['cn_number' => $cn_number]);
        return $data;
    }

    public function get_courier_services($courier_id)
    {
        $data = ['account_id' => $courier_id];
        $result = getAPIdata('tpl/courier-services', $data);
        $return = $result->payload;

        return response()->json($return);
    }

    public function get_courier_code(Request $request)
    {
        $data = ['id' => $request->courier_id];
        $result = getAPIdata('couriers_details/code-single', $data);
        $codes = $result->payload;

        return response()->json($codes);
    }

    public function courier_authenticate($payload)
    {
        extract($payload);
        switch ($courier_id) {
            case '1': // BlueEx
                $url = 'https://bigazure.com/api/json_v2/user_auth/user_authentication.php?auth=' . urlencode('{"acno":"' . $account_no . '","userid": "' . $account_user . '","password": "' . $account_password . '"}');
                $result = json_decode(Http::get($url));
                $status = $result->message == 'Authorized !' ? 1 : 0;
                break;
            case '2': //Tcs
                $url = 'https://api.tcscourier.com/production/v1/cod/cities';
                $header = ['Accept: application/json', 'Content-type: application/json', "x-ibm-client-id: $apikey"];
                $result = json_decode(Http::withHeaders($header)->get($url));
                $status = isset($result->returnStatus->code) && $result->returnStatus->code == '200' ? 1 : 0;
                break;
            case '3': // Leopards
                $url = 'https://merchantapi.leopardscourier.com/api/getAllCities/format/json/';
                $data = ['api_key' => $apikey, 'api_password' => $account_password];
                $result = json_decode(Http::post($url, $data));
                $status = $result->status;
                break;
            case '4': //MNP
                $data = ['username' => $account_user, 'password' => $account_password, 'AccountNo' => $account_no];
                $url = 'http://mnpcourier.com/mycodapi/api/Branches/Get_Cities?' . http_build_query($data);
                $result = json_decode(Http::get($url));
                if (isset($result->Message)) {
                    $status = 0;
                } else {
                    $status = count($result[0]->City) > 1 ? 1 : 0;
                }
                break;
            // case '6': //Riders
            //     $data = ['loginId' => '4163', 'apikey' => $apikey];
            //     $url = "http://api.withrider.com/rider/v1/GetCityList?".http_build_query($data);
            //     $result = json_decode(curlFunction($url,"","","","GET"));
            //     $status = ((isset($result->statuscode))&&($result->statuscode=='401' || $result->statuscode == '400'))?0:1;
            // break;
            case '7': //Trax
                $url = 'https://sonic.pk/api/cities';
                $headers = ["Authorization: $apikey"];
                $result = json_decode(Http::withHeaders($headers)->get($url));
                $status = $result->status == 1 ? 0 : 1;
                break;
            case '13': //Fly
                $url = 'https://app.flycourier.com.pk/api/authentication';
                $data = [
                    'api_key' => $apikey,
                ];
                $result = json_decode(Http::post($url, $data));
                $status = $result->status == 1 && $result->data->response == 200 ? 1 : 0;
                break;
            case '18': //PostEx
                $url = 'https://api.postex.pk/services/integration/api/order/v1/get-operational-city';
                $headers = ["token: $apikey"];
                $result = json_decode(Http::withHeaders($headers)->get($url));
                $status = isset($result->status) ? 0 : 1;
                break;
            case '21': //Daewoo
                $data = ['apiKey' => $apikey, 'apiUser' => $account_user, 'apiPassword' => $account_password];
                $url = 'https://codapi.daewoo.net.pk/api/cargo/getLocations?' . http_build_query($data);
                $result = json_decode(Http::post($url, $data));
                $status = $result->Success == 1 ? 1 : 0;
                break;
            default:
                $status = 1;
                break;
        }

        if ($status == 1) {
            $return = ['status' => 1, 'message' => 'Authorized !'];
        } else {
            $return = ['status' => 0, 'message' => 'Invalid Credentials / API Key'];
        }
        return response()->json($return);
    }

    public function get_stations(Request $request)
    {
        $data = ['company_id' => session('company_id'), 'city_id' => $request->city_id];
        $stations = getAPIdata('stations/index', $data);
        $html = '';
        foreach ($stations as $station) {
            $html .= '<option value="' . $station->id . '">' . $station->name . '</option>';
        }
        return response()->json($html);
    }

    public function get_customer_service(Request $request)
    {
        get_all_services();
        $data = ['customer_acno' => $request->customer_acno, 'type' => '6'];
        $result = getAPIdata('common/getServices', $data);
        $services = explode(',', $result[0]->service_id);
        $html = '';
        foreach (session('services') as $s) {
            if (in_array($s->id, $services)) {
                $html .= '<option value="' . $s->id . '">' . $s->service_name . '</option>';
            }
        }
        return response()->json($html);
    }

    public function web_view_track()
    {
        return view('single_page_modules.web-track');
    }

    public function get_courier_city(Request $request)
    {
        if ($request->ajax()) {
            $data = ['country' => $request->country, 'courier' => $request->courier, 'country_code' => $request->country_code];
            $check = get_all_courier_cities($data);
            return response()->json($check);
        }
        return response()->json(['error' => 'Invalid request'], 400);
    }

    public function add_city(Request $request){
        $data = ['city_name' => $request->city_name, 'country_id' => (int) $request->country_id];
        $result = getAPIdata('common/addCity', $data);
        if($result->status == '1'){
            $directory = base_path('app/Listings/Cities/cities.txt');
            if (file_exists($directory)) {
                unlink($directory);
                get_all_cities();
            }
        }
        return response()->json($result);
    }
}
