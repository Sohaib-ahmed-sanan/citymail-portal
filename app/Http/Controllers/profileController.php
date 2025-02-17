<?php

namespace App\Http\Controllers;

use BadFunctionCallException;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Config;

class profileController extends Controller
{

    private $common;
    public function _construct(commonController $common)
    {
        $this->common = $common;
    }

    // public function index(Request $request)
    // {
    //     if ($request->isMethod('GET')) {
    //         $couriers = get_all_couriers();
    //         $company_status = check_company_status();
    //         if ($company_status == 1) {
    //             $page_type = 1;
    //         } else {
    //             $page_type = 2;
    //         }
    //         $title = "Dashboard";
    //         $data = compact('title', 'couriers', 'page_type');
    //         return view("dashboard.index")->with($data);
    //     }
    //     if ($request->isMethod('POST')) {
    //         $company_id = session('company_id');
    //         $customer_acno = $employee_id = '';
    //         $start_date = $request->start_date;
    //         $end_date = $request->end_date;
    //         $acc_type = session('type');
    //         if (is_portal()) {
    //             $customer_acno = session('acno');
    //         }else{
    //             $employee_id = session('employee_id');
    //         }
    //         $params = compact('start_date','end_date','company_id','customer_acno','employee_id','acc_type');
    //         $result = getAPIdata('dashboard/index', $params);
    //         // dd($result);
    //         if ($result->status == 1) {
    //             $payload = $result->payload;
    //             // for first graph only for counts.
    //             $accounts_count = $payload->accounts_count[0]->accounts;
    //             $order_counts = $payload->statics[0]->order_counts;
    //             $order_counts_arr = $payload->statics[0]->order_counts_arr;
    //             $total_revenue = $payload->statics[0]->total_revenue;
    //             $total_revenue_arr = $payload->statics[0]->total_revenue_arr;
    //             $total_outstanding = $payload->statics[0]->total_outstanding;
    //             $total_outstanding_arr = $payload->statics[0]->total_outstanding_arr;
    //             if (count($order_counts_arr) === 1) {
    //                 array_unshift($order_counts_arr, 0);
    //             }
                
    //             if (count($total_revenue_arr) === 1) {
    //                 array_unshift($total_revenue_arr, 0);
    //             }
                
    //             if (count($total_outstanding_arr) === 1) {
    //                 array_unshift($total_outstanding_arr, 0);
    //             }
                
    //             // for shipment status
    //             $status = $payload->delivary_status;
    //             // top customer_array
    //             $customer_arr = $payload->top_customers;
    //             // tpl_accounts_arr
    //             $tpl_accounts_arr = $payload->tpl_accounts;
    //             $accounts = 0;             
    //             // for counting the accounts
    //             $account_count = [0];
    //             if (is_array($accounts_count) && count($accounts_count) > 0) {
    //                 foreach ($accounts_count as $count) {
    //                     $account_count[] = $count->accounts_count;
    //                     $accounts += $count->accounts_count;
    //                 }
    //             }
    //             $return = [
    //                 'account_count' => $account_count,
    //                 'accounts' => $accounts,
    //                 'order_counts' => $order_counts,
    //                 'order_counts_arr' => $order_counts_arr,
    //                 'total_revenue' => $total_revenue,
    //                 'total_revenue_arr' => $total_revenue_arr,
    //                 'total_outstanding' => $total_outstanding,
    //                 'total_outstanding_arr' => $total_outstanding_arr,
    //                 'status_arr' => $status,
    //                 'customer_details' => $customer_arr->customers,
    //                 'coutries_graph' => $customer_arr->countries_array,
    //                 'tpl_details' => $tpl_accounts_arr,
    //             ];
    //             return response()->json($return);
    //         }
    //     }
    // }
    
    public function index(Request $request)
    {
        if ($request->isMethod('GET')) {
            $couriers = get_all_couriers();
            $company_status = check_company_status();
            if ($company_status == 1) {
                $page_type = 1;
            } else {
                $page_type = 2;
            }
            $title = "Dashboard";
            $data = compact('title', 'couriers', 'page_type');
            return view("dashboard.index")->with($data);
        }
        if ($request->isMethod('POST')) {
            $company_id = session('company_id');
            $customer_acno = $employee_id = '';
            $start_date = $request->start_date;
            $end_date = $request->end_date;
            $acc_type = session('type');
            if (is_portal()) {
                $customer_acno = session('acno');
            }else{
                $employee_id = session('employee_id');
            }
            $params = compact('start_date','end_date','company_id','customer_acno','employee_id','acc_type');
            $result = getAPIdata('dashboard/index', $params);
            if ($result->status == 1) {
                $payload = $result->payload;
                // for first graph only for counts.
                $accounts_count = $payload->accounts_count[0]->accounts;
                $order_counts = $payload->statics[0]->order_counts;
                $order_counts_arr = $payload->statics[0]->order_counts_arr;
                $total_revenue = $payload->statics[0]->total_revenue;
                $total_revenue_arr = $payload->statics[0]->total_revenue_arr;
                $total_outstanding = $payload->statics[0]->total_outstanding;
                $total_outstanding_arr = $payload->statics[0]->total_outstanding_arr;
                if (count($order_counts_arr) === 1) {
                    array_unshift($order_counts_arr, 0);
                }
                if (count($total_revenue_arr) === 1) {
                    array_unshift($total_revenue_arr, 0);
                }
                if (count($total_outstanding_arr) === 1) {
                    array_unshift($total_outstanding_arr, 0);
                }
                // for shipment status
                $shipments_status = $payload->shipments_status;
                // top customer_array
                $customer_arr = $payload->top_customers;
                // tpl_accounts_arr
                $tpl_accounts_arr = $payload->tpl_accounts;
                $accounts = 0;             
                // for counting the accounts
                $account_count = [0];
                if (is_array($accounts_count) && count($accounts_count) > 0) {
                    foreach ($accounts_count as $count) {
                        $account_count[] = $count->accounts_count;
                        $accounts += $count->accounts_count;
                    }
                }
                $return = [
                    'account_count' => $account_count,
                    'accounts' => $accounts,
                    'order_counts' => $order_counts,
                    'order_counts_arr' => $order_counts_arr,
                    'total_revenue' => $total_revenue,
                    'total_revenue_arr' => $total_revenue_arr,
                    'total_outstanding' => $total_outstanding,
                    'total_outstanding_arr' => $total_outstanding_arr,
                    'status_arr' => $shipments_status,
                    'customer_details' => $customer_arr->customers,
                    'coutries_graph' => $customer_arr->countries_array,
                    'tpl_details' => $tpl_accounts_arr,
                ];
                return response()->json($return);
            }
        }
    }
    
    
    
    public function profile()
    {
        $title = "Profile";
        // api to get the customer
        $result = getAPIdata('profile/single', ['id' => session('logged_id')]);
        $company = $result->payload;
        $countries = get_all_countries();
        $cities = get_all_cities();

        $data = compact("title", "company","countries","cities");
        return view("settings.profile")->with($data);
    }
    public function customer_profile(Request $request)
    {
        if (!session('banks')) {
            get_all_banks();
        }
        $cities = get_all_cities();
        $countries = get_all_countries();
        if ($request->isMethod('GET')) {
            if (is_portal()) {
                $title = "Customer Profile";
                $result = getAPIdata('customers/single', ['id' => session('primary_id')]);
            } elseif (is_customer_sub()) {
                $title = "Sub Account Profile";
                $result = getAPIdata('customers/sub-accounts/single', ['id' => session('primary_id')]);
            }
            $payload = $result->payload;
            $type = "edit";
            $data = compact('payload', 'type', 'title','cities','countries');
            return view("settings.customer_profile")->with($data);
        }
        if ($request->isMethod('POST')) {
            $request->validate([
                'name' => 'required',
                'phone' => 'required',
                'address' => 'required',
                'business_name' => 'required',
                'cnic' => 'required',
                'country_id' => 'required',
                'city_id' => 'required',
            ]);
            if (is_portal()) {
                $request->validate([
                    'business_address' => 'required',
                    'bank' => 'required',
                    'account_number' => 'required',
                ]);
                $data = $request->only([
                    'name',
                    'phone',
                    'address',
                    'business_name',
                    'business_address',
                    'cnic',
                    'ntn',
                    'other_name',
                    'other_phone',
                    'bank',
                    'country_id',
                    'city_id',
                    'account_title',
                    'account_number',
                ]);
                $data['id'] = session('primary_id');
                if ($request->cnic_image != '') {
                    $data['cnic_image'] = $request->cnic_image;
                } else {
                    $data['cnic_image'] = $request->old_cnic_image;
                }
            $params = compact('data');
            $result = getAPIdata('profile/customer_profile', $data);
            } elseif (is_customer_sub()) {
                $data = $request->only([
                    'name',
                    'email',
                    'phone',
                    'address',
                    'account_title',
                    'country_id',
                    'city_id',
                    'business_name',
                    'cnic',
                    'ntn',
                ]);
                $data['id'] = session('primary_id');
                if($request->user_name != $request->old_user_name)
                {
                    $data['user_name'] = $request->user_name; 
                }else{
                    $data['user_name'] = ''; 
                }
                $params = compact('data');
                $result = getAPIdata('profile/subAccount_profile', $data);
            }
            $return = ['status' => $result->status, 'message' => $result->message, 'payload' => $result->payload];
            
            return response()->json($return);
        }
    }
    public function update_profile(Request $request)
    {
        $id = session('logged_id');
        $first_name = $request->f_name;
        $last_name = $request->l_name;
        $country = $request->country;
        $city = $request->city;
        $zip = $request->zip;
        $phone = $request->phone;
        $phone2 = $request->phone2;
        $company_name = $request->company_name;
        $ntn = $request->ntn;
        $cnic = $request->cnic;
        $logo_image = $request->logo_image;
        $cnic_image = $request->cnic_image;
        $ntn_image = $request->ntn_image;
        if ($request->logo_image != "") {
            $logo_image = $request->logo_image;
        } else {
            $logo_image = $request->ntn_old_image;
        }
        if ($request->cnic_image != "") {
            $cnic_image = $request->cnic_image;
        } else {
            $cnic_image = $request->cnic_old_image;
        }
        if ($request->ntn_image != "") {
            $ntn_image = $request->ntn_image;
        } else {
            $ntn_image = $request->old_ntn_image;
        }

        $data = compact('id', 'first_name', 'last_name', 'country', 'city', 'zip', 'phone', 'phone2', 'company_name', 'ntn', 'cnic', 'ntn_image', 'cnic_image', 'logo_image');
        $result = getAPIdata('profile/updateProfile', $data);
        session()->put('origin_city',$city);
        $return = ['status' => $result->status, 'message' => $result->message];
        return response()->json($return);
    }
    public function uploadProfile_images(Request $request)
    {
        $ImgName = null;
        if ($request->hasFile('file')) {
            $path = is_ops() ? public_path('images/' . session('company_id') . '/') : public_path('images/' . session('company_id') . '/' . session('acno') . '/');
            $image = $request->file('file');
            $imageName = Str::random(6) . '.' . $image->getClientOriginalExtension();
            $image->move($path, $imageName);
            $ImgName = $imageName;
            return response()->json(['status' => 1, 'message' => $imageName]);
        }
        return response()->json(['status' => 0, 'message' => 'File not uploaded']);
    }
    public function company_settings(Request $request)
    {
        if ($request->isMethod('GET')) {
            if(session('type') !== '1')
            {
                return redirect()->back();
            }
            $title = "Company Settings";
            $company_id = session('company_id');
            $param = compact('company_id');
            $result = getAPIdata('profile/getSettings', $param);
            $currencies = get_currencies();
            $company = $result->payload;
            $data = compact("title", "company","currencies");
            return view("settings.company_settings")->with($data);
        }
        if ($request->isMethod('POST')) {
            // dr($request);
            $request->validate([
                "name" => "required|regex:/^[A-Za-z\s'-]+$/",
                "office_address" => "required",
                "primary_color" => "required",
                "secondary_color" => "required",
                "font_color" => "required",
            ]);
            $data = $request->only([
                'name',
                'office_address',
                'primary_color',
                'secondary_color',
                'font_color',
                'pkr',
                'aed',
                'usd',
                'sar',
            ]);
            if($request->base_currency != '')
            {
                $data['base_currency'] = $request->base_currency;
            }
            if ($request->logo_image != '' && $request->logo_image != $request->old_logo_image) {
                $data['logo_image'] = $request->logo_image;
            } else {
                $data['logo_image'] = $request->old_logo_image;
            }
            $data['company_id'] = session('company_id');
            $result = getAPIdata('profile/updateCompanySetting', $data);
            if ($result->status == 1) {
                session()->forget('company_name');
                session()->forget('office_address');
                session()->forget('primary_color');
                session()->forget('secondary_color');
                session()->forget('font_color');
                session()->forget('company_logo');
                session()->forget('base_currency');
                session()->put('company_name', $request->name);
                session()->put('office_address', $request->office_address);
                session()->put('primary_color', $request->primary_color);
                session()->put('secondary_color', $request->secondary_color);
                session()->put('font_color', $request->font_color);
                session()->put('base_currency', $request->base_currency);
                if ($request->logo_image != '' && $request->logo_image != $request->old_logo_image) {
                    session()->put('company_logo', $request->logo_image);
                } else {
                    session()->put('company_logo', $request->old_logo_image);
                }
            }
            $return = ['status' => $result->status, 'message' => $result->message];
            // dd($return);
            return response()->json($return);
        }

     }

    public function developer_center()
    {
        // dd(sesion);
        $title = "Developer Center";
        $data = compact("title");
        return view("single_page_modules.developer-center")->with($data);
    } 
    
    public function logout()
    {
        session()->flush();
        return redirect()->route('auth.login');
    }
}
