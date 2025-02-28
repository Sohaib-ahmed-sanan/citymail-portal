<?php

use App\Http\Controllers\commonController;

use Illuminate\Support\Facades\Http;

if (!function_exists('GET_API_CONTENT')) {
    function GET_API_CONTENT($API_URL, $json)
    {
        $token_str = base64_encode(session('type').'%'.session('secret_key').'%'.session('company_id').'%'.session('acno').'%internal%'.time());
        // $headers = ['Content-Type: application/json', 'Api-Key: ' . base64_encode(session('type')) . '%' . session('secret_key') . '!' . session('company_id') . ':' . time(), 'Client-Id: ' . session('logged_id')];
        $headers = ['Content-Type: application/json', 'Api-Key: '.$token_str, 'Client-Id: '.session('logged_id')];

       
        $ch = curl_init();

        curl_setopt_array(
            $ch,

            [
                CURLOPT_URL => $API_URL,

                CURLOPT_RETURNTRANSFER => true,

                CURLOPT_ENCODING => '',

                CURLOPT_MAXREDIRS => 10,

                CURLOPT_TIMEOUT => 0,

                CURLOPT_FOLLOWLOCATION => true,

                CURLOPT_SSL_VERIFYHOST => false,

                CURLOPT_SSL_VERIFYPEER => false,

                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,

                CURLOPT_HTTPHEADER => $headers,

                CURLOPT_CUSTOMREQUEST => 'POST',

                CURLOPT_POSTFIELDS => $json,
            ],
        );

        $result = curl_exec($ch);

        $err = curl_error($ch);

        curl_close($ch);

        if ($err) {
            return $err;
        } else {
            return $result;
        }
    }
}

if (!function_exists('getAPIdata')) {
    function getAPIdata($url, $data)
    {
        $api_url = config('app.api_url');

        $json = json_encode($data);

        $response = GET_API_CONTENT($api_url . $url . '.php', $json);

        $result = json_decode($response);

        return $result;
    }
}

if (!function_exists('getAPIJson')) {
    function getAPIJson($url, $data)
    {
        $api_url = config('app.api_url');

        return GET_API_CONTENT($api_url . $url . '.php', json_encode($data));
    }
}

if (!function_exists('getTarifs')) {
    function getTarifs($params)
    {
        $result = getAPIJson('customers/getCharges', $params);

        $tarifs = json_decode($result);

        return $tarifs;
    }
}

if (!function_exists('getsalesPersons')) {
    function getsalesPersons($params)
    {
        $result = getAPIdata('salesPersons/index', $params);
        return $result;
    }
}

if (!function_exists('calculate_tariff')) {
    function calculate_tariff($params)
    {
        $result = getAPIdata('arrivals/tariffCalculation', $params);

        // $result = getAPIJson('arrivals/tariffCalculation', $params);

        return $result;
    }
}

if (!function_exists('dr')) {
    function dr($params)
    {
        return dd($params->all());
    }
}

// for third party

function curlFunction($url, $data, $headers = '', $userpwd = '', $type = '')
{
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $url);

    if ($headers != '') {
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    }

    if ($userpwd != '') {
        curl_setopt($ch, CURLOPT_USERPWD, $userpwd);
    }

    if (in_array($type, ['PUT', 'PATCH', 'DELETE'])) {
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $type);

        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    } elseif ($type != '') {
        curl_setopt($ch, CURLOPT_POST, 0);
    } else {
        curl_setopt($ch, CURLOPT_POST, 1);

        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    }

    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

    $result = curl_exec($ch);

    $err = curl_error($ch);

    curl_close($ch);

    if ($err) {
        return $err;
    } else {
        return $result;
    }
}

if (!function_exists('is_ops')) {
    function is_ops()
    {
        $check = in_array(session('type'), ['1', '3', '4', '5', '9']);

        return $check;
    }
}

if (!function_exists('is_portal')) {
    function is_portal()
    {
        $check = in_array(session('type'), ['6', '8']);

        return $check;
    }
}

if (!function_exists('is_customer_sub')) {
    function is_customer_sub()
    {
        $check = in_array(session('type'), ['7']);

        return $check;
    }
}

if (!function_exists('getStatusBadge')) {
    function getStatusBadge($status_id)
    {
        switch ($status_id) {
            case '1':
                $badge = 'shipped';
                break;
            case '7':
                $badge = 'rejected';
                break;
            case '8':
            case '14':
                $badge = 'success';
                break;
            case '9':
            case '12':
            case '13':
            case '28':
            case '16':
            case '26':
                $badge = 'returned';
                break;
            case '10':
            case '39':
                $badge = 'replacement';
                break;
            case '13':
            case '15':
                $badge = 'deleted';
                break;
            case '18':
                $badge = 'in-transit';
                break;
            case '23':
            case '24':
                $badge = 'rejected';
                break;
            case '29':
            case '31':
                $badge = 'onroute';
                break;
            case '28':
                $badge = 'delivered';
                break;
            case '4':
            case '19':
                $badge = 'arrival';
                break;
            default:
                $badge = 'primary';
                break;
        }
        return $badge;
    }
}

if (!function_exists('get_all_couriers')) {
    function get_all_couriers()
    {
        $param = ['type' => 'couriers'];
        $couriers = getAPIdata('common/listings', $param);
        return $couriers;
    }
}

if (!function_exists('generateFile')) {
    function generateFile($path, $data)
    {
        $fw = fopen($path, 'w');

        if ($fw === false) {
            return false;
        }

        fwrite($fw, $data);

        fclose($fw);

        return true;
    }
}

if (!function_exists('make_txt_file')) {
    function make_txt_file($api_path, $directory, $file_name)
    {
        $directory = base_path('app/Listings/' . $directory);
        $filename = $directory . '/' . $file_name . '.txt';
        if (!file_exists($directory)) {
            mkdir($directory, 0755, true);
        }
        // Check if the file exists and is up to date
        if (!file_exists($filename)) {
            $resp = getAPIdata($api_path, ['company_id' => session('company_id'), 'type' => $file_name]);
            generateFile($filename, json_encode($resp));
            $return = json_decode(file_get_contents($filename));
        } else {
            $filetime = filemtime($filename);
            if (round((time() - $filetime) / (60 * 60 * 24)) >= 1) {
                $resp = getAPIdata($api_path, ['company_id' => session('company_id'), 'type' => $file_name]);
                generateFile($filename, json_encode($resp));
                $return = json_decode(file_get_contents($filename));
            } else {
                $return = json_decode(file_get_contents($filename));
            }
        }
        return $return;
    }
}


if (!function_exists('get_all_countries')) {
    function get_all_countries()
    {
        $filename ='Countries/countries.txt';
        
        if (!file_exists($filename)) {
            return make_txt_file('common/listings', 'Countries', 'countries');
        } else {
            $return = json_decode(file_get_contents($filename));            
        }
    }
}

if (!function_exists('get_all_cities')) {
    function get_all_cities(){
        $filename ='Cities/cities.txt';
        if (!file_exists($filename)) {
            return make_txt_file('common/getCities', 'Cities', 'cities');
        } else {
            $return = json_decode(file_get_contents($filename));            
        }
    }
}

if (!function_exists('get_currencies')) {
    function get_currencies(){
        $filename ='Currencies/currencies.txt';
        if (!file_exists($filename)) {
            return make_txt_file('common/listings', 'Currencies', 'currencies');
        } else {
            $return = json_decode(file_get_contents($filename));            
        }
    }
}

if (!function_exists('get_all_banks')) {
    function get_all_banks()
    {
        $filename ='Banks/banks.txt';
        if (!file_exists($filename)) {
            $banks = make_txt_file('common/listings', 'Banks', 'banks');
        } else {
            $return = json_decode(file_get_contents($filename));            
        }
        return session()->put('banks', $banks);
    }
}


if (!function_exists('get_customers')) {
    function get_customers($flag = "0")
    {
        $param = ['company_id' => session('company_id'),'flag' => $flag];
        $result = getAPIdata('common/getCustomers', $param);
        if ($result->status == 1) {
            $payload = $result->payload;
            $return = ['status' => 1, 'message' => 'success', 'payload' => $payload];
            return response()->json($return);
        } else {
            return response()->json([]);
        }
    }
}

if (!function_exists('get_customers_sub')) {
    function get_customers_sub($acno)
    {
        $param = ['company_id' => session('company_id'), 'customer_acno' => $acno];

        $result = getAPIdata('customers/sub-accounts/index', $param);

        $return = $result;

        return response()->json($return);
    }
}

if (!function_exists('get_all_services')) {
    function get_all_services($type = '')
    {
        if ($type == '') {
            $param = ['type' => 'all'];
        } else {
            $param = ['type' => $type];
        }

        if (!session('services')) {
            $services = getAPIdata('common/getServices', $param);

            session()->put('services', $services);
        }
    }
}

if (!function_exists('get_all_status')) {
    function get_all_status()
    {
        if (!session('status')) {
            $param = ['type' => 'all', 'type' => 'status'];
            $status = getAPIdata('common/listings', $param);
            session()->put('status', $status);
        }
    }
}

if (!function_exists('country_name')) {
    function country_name($country_id)
    {
        $countries = get_all_countries();

        $filtered_country = array_filter($countries, function ($country) use ($country_id) {
            return $country->id == $country_id;
        });

        $filtered_country = reset($filtered_country);

        return $filtered_country->country_name;
    }
}

if (!function_exists('city_name')) {
    function city_name($city_id)
    {
        $cities = get_all_cities();
        $filtered_city = array_filter($cities, function ($city) use ($city_id) {
            return $city->id == $city_id;
        });
        $filtered_city = reset($filtered_city);
        return $filtered_city->city;
    }
}

if (!function_exists('check_company_status')) {
    function check_company_status()
    {
        $param = ['company_id' => session('company_id')];

        $result = getAPIdata('common/company_check', $param);

        $data = $result->payload;

        $return = 1;

        if ($data->cnic_number == null || $data->cnic_img == null || $data->phone == null || $data->city_id == null || $data->name == null || $data->headoffice_address == null) {
            $return = 0;
        }

        return $return;
    }
}

if (!function_exists('restricted_ip')) {
    function restricted_ip($ip)
    {
        // $current_ip = $request->ip();
        $current_ip = '';
        if ($current_ip === $ip) {
            $return = true;
        } else {
            $return = false;
        }
        return $return;
    }
}

if (!function_exists('compressJson')) {
    function compressJson($array)
    {
        $json = json_encode($array);
        $compress = gzencode($json, 9);
        header('Content-Encoding: gzip');
        return $compress;
    }
}