<?php
namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;

class authController extends Controller
{
    // ================= view routes ==============

    // login page
    public function login(Request $request)
    {
        $title = "Login";
        $data = compact("title");
        return view("auth.login")->with($data);
    }
    // account activation page
    public function acc_activation()
    {
        $title = "Login";
        $data = compact("title");
        return view("auth.activation")->with($data);
    }
    // register page
    public function register()
    {
        $title = "Register";
        $data = compact("title");
        return view("auth.signup")->with($data);
    }
    // forgot pass page
    public function forgot_pass()
    {
        $title = "Forgot Password";
        $data = compact("title");
        return view("auth.forgot-pass")->with($data);
    }
    public function reset_password(Request $request)
    {
        if ($request->isMethod('GET')) {
            $title = "Reset Password";
            $data = compact("title");
            return view("auth.reset-pass")->with($data);
        }
        if ($request->isMethod('POST')) {
            $new = $request->password;
            $user_name = base64_decode($request->user_name);
            $reset = 1;
            $data = compact('user_name', 'new', 'reset');
            // dd($data);
            $result = getAPIdata('auth/changePassword', $data);
            // $result = getAPIJson('auth/changePassword', $data);
            // dd($result);
            $return = ['status' => $result->status, 'message' => $result->message, 'payload' => $result->payload];
            return response()->json($return);
        }
    }
    // change password page
    public function change_pass()
    {
        $title = "Change Password";
        $data = compact('title');
        return view('auth.changePassword')->with($data);
    }
    // ================= end view routes ==============

    // ================= ajax routes ==============
    // account creation 
    public function store_registration(Request $request)
    {
        $request->validate([
            "first_name" => "required",
            "last_name" => "required",
            "email" => "required|email",
            "user_name" => "required",
            "password" => "required",
            "Confirmpass" => "required|same:password"
        ]);
        $first_name = $request->first_name;
        $last_name = $request->last_name;
        $email = $request->email;
        $user_name = $request->user_name;
        $password = $request->password;
        $token = Str::random(25);
        $data = compact('first_name', 'last_name', 'email', 'user_name', 'password', 'token');
        $result = getAPIdata('auth/signup', $data);
        // $result = getAPIJson('auth/signup', $data);
        // dd($result);
        if ($result->status == '1') {
            $send_mail = app(emailController::class);
            $send_mail->activation($email, $token . ':' . time() . '|' . base64_encode('companies'), '1', '');
        }
        $return = ['status' => $result->status, 'message' => $result->message, 'payload' => $result->payload];
        return response()->json($return);
    }
    // login check
    public function login_check(Request $request)
    {
        $request->validate([
            "user_name" => "required",
            "password" => "required",
        ]);
        $user_name = $request->user_name;
        $password = $request->password;
        $data = compact('user_name', 'password');
        $result = getAPIdata('auth/login', $data);
        // $result = getAPIJson('auth/login', $data);
        // dd($result);
        if ($result->status == 1) {
            $settings = getAPIdata('common/getcompanySetings', ['company_id' => $result->payload[0]->company_id]);
            if ($settings->status == 1) {
                $menus = json_encode($result->payload[0]->menus);
                $menues = json_decode($menus ?? '[]');
                // dd($result->payload[0]->company_type);
                session()->put('first_name', ($result->payload[0]->first_name != '' ? $result->payload[0]->first_name : ''));
                session()->put('logged_id', ($result->payload[0]->logged_id != '' ? $result->payload[0]->logged_id : ''));
                session()->put('employee_id', ($result->payload[0]->employee_id != '' ? $result->payload[0]->employee_id : ''));
                session()->put('primary_id', ($result->payload[0]->primary_id != '' ? $result->payload[0]->primary_id : ''));
                session()->put('email', ($result->payload[0]->email != '' ? $result->payload[0]->email : ''));
                session()->put('acno', ($result->payload[0]->acno != '' ? $result->payload[0]->acno : ''));
                session()->put('type', ($result->payload[0]->account_type != '' ? $result->payload[0]->account_type : ''));
                session()->put('company_type', ($settings->payload[0]->company_type != '' ? $settings->payload[0]->company_type : ''));
                session()->put('secret_key', ($result->payload[0]->secret_key != '' ? $result->payload[0]->secret_key : ''));
                session()->put('origin_city', ($result->payload[0]->city_id != '' ? $result->payload[0]->city_id : ''));
                session()->put('company_id', ($result->payload[0]->company_id != '' ? $result->payload[0]->company_id : ''));

                session()->put('company_name', ($settings->payload[0]->company_name != '' ? $settings->payload[0]->company_name : ''));
                session()->put('office_address', ($settings->payload[0]->office_address != '' ? $settings->payload[0]->office_address : ''));
                session()->put('company_logo', ($settings->payload[0]->company_logo != '' ? $settings->payload[0]->company_logo : ''));
                session()->put('base_currency', ($settings->payload[0]->base_currency != '' ? $settings->payload[0]->base_currency : ''));
                session()->put('prefix', ($settings->payload[0]->prefix != '' ? $settings->payload[0]->prefix : ''));
                session()->put('primary_color', ($settings->payload[0]->primary_color != '' ? $settings->payload[0]->primary_color : ''));
                session()->put('secondary_color', ($settings->payload[0]->secondary_color != '' ? $settings->payload[0]->secondary_color : ''));
                session()->put('font_color', ($settings->payload[0]->font_color != '' ? $settings->payload[0]->font_color : ''));

                // $type = ($result->payload[0]->account_type != '' ? $result->payload[0]->account_type : '');
                session()->put('menues', $menues);
            }
        }
        $return = ['status' => $result->status, 'message' => $result->message, 'payload' => $result->payload];
        return response()->json($return);
    }
    public function update_pass(Request $request)
    {
        $request->validate([
            "old_password" => "required",
            "new_password" => "required",
            "confirm_password" => "required",
        ]);
        $old = $request->old_password;
        $new = $request->new_password;
        $confirm = $request->confirm_password;
        $id = session('logged_id');
        if ($new == $confirm) {
            $data = compact('old', 'new', 'confirm', 'id');
            // dd($data);
            $result = json_decode(getAPIJson('auth/changePassword', $data));
            // $result = getAPIJson('auth/changePassword', $data);
            // dd($result);
            $return = ['status' => $result->status, 'message' => $result->message];
        } else {
            $return = ['status' => '0', 'message' => 'Confirm password dosent match with password'];
        }
        return response()->json($return);
    }
    // account activation 
    public function check_activaton(Request $request)
    {
        $token = $request->token;
        $tabel = $request->tabel;
        $data = compact('token', 'tabel');
        $result = getAPIdata('auth/activation', $data);
        // $result = getAPIJson('auth/activation', $data);
        // dd($result);
        $return = ['status' => $result->status, 'message' => $result->message, 'payload' => $result->payload];
        return response()->json($return);
    }
    public function check_forgot_pass(Request $request)
    {
        $user_name = $request->user_name;
        $data = compact('user_name');
        $result = getAPIdata('auth/forgotPass', $data);
        // dd($result);
        if ($result->status == '1') {
            $data = [
                "name" => $request->name,
                "user_name" => $request->user_name,
                "email" => $result->payload->email,
            ];
            $send_mail = app(emailController::class);
            $check = $send_mail->forgot_password($data);
        }
        $return = ['status' => $result->status, 'message' => $result->message, 'payload' => 'Please check your email'];
        return response()->json($return);
    }
    // ================= ajax routes ==============

    
}
