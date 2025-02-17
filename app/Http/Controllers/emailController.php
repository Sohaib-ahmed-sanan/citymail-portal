<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mail;
use App\Mail\accountActivation;
use App\Mail\forgotPassword;
use App\Jobs\sendEmail;
use App\Jobs\sendEmailForgotPass;
class emailController extends Controller
{
    public function activation($to, $token, $type, $params)
    {
        if ($type == '6') {
            $body = '<p>Welcome to ' . ucfirst($params['co_name']) . ' !<br> 
            Thank you for becoming our customer your account credientials are <br>
             user name : <strong>' . $params['user_name'] . '</strong><br>
             password : <strong>' . $params['password'] . '</strong><br></p>
            <strong>PLEASE DONT SHARE THIS INFORMATION TO ANY ONE !</strong>
             <br>
             <p>before login please click on the link below to activate your account</p>';
            $mailData = [
                'title' => 'Mail From ' . ucfirst($params['co_name']),
                'body' => $body,
                'link' => config('app.url').'/account-activation?token=' . $token
            ];
        }
        if (in_array($type,['3','4','5','9'])) {
            $body = '<p>' . ucfirst($params['co_name']) . ' welcomes you onbord<br> 
            Below are your account credientials.<br>
            user name : <strong>' . $params['user_name'] . '</strong><br>
            password : <strong>' . $params['password'] . '</strong><br></p>
            <strong>PLEASE DONT SHARE THIS INFORMATION TO ANY ONE !</strong>
             <br>
             <p>before login please click on the link below to activate your account</p>';
            $mailData = [
                'title' => 'Mail From ' . ucfirst($params['co_name']),
                'body' => $body,
                'link' => config('app.url').'/account-activation?token=' . $token
            ];
        }
        if ($type == '7') {
            $body = '<p>' . ucfirst($params['co_name']) . ' welcomes you onbord<br> 
            Below are your account credientials.<br>
            user name : <strong>' . $params['user_name'] . '</strong><br>
            password : <strong>' . $params['password'] . '</strong><br></p>
            <strong>PLEASE DONT SHARE THIS INFORMATION TO ANY ONE !</strong>
             <br>
             <p>before login please click on the link below to activate your account</p>';
            $mailData = [
                'title' => 'Mail From ' . ucfirst($params['co_name']),
                'body' => $body,
                'link' => config('app.url').'/account-activation?token=' . $token
            ];
        }
        if ($type == '1') {
            $mailData = [
                'title' => 'Mail From Orio Express',
                'body' => 'Welcome to Orio express ! your account registration is just one step away please click on the link below to activate your account',
                'link' => config('app.url').'/account-activation?token=' . $token
            ];
        }
        dispatch(new SendEmail($to, $mailData));
    }
    // Mail::to($to)->send(new accountActivation($mailData));
    public function forgot_password($params)
    {
        $body = '<p>Dear ' . ucfirst($params['name']) . ' !<br> 
            Your password recovery request is in progress <br>
            <p>Click on the link below to recover your password</p>';
        $mailData = [
            'title' => 'Mail From Orio Express',
            'body' => $body,
            'link' => config('app.url').'/reset-password?token='.base64_encode($params['user_name']).':'.time()
        ];

        dispatch(new sendEmailForgotPass($params['email'], $mailData));
        // Mail::to($params['email'])->send(new forgotPassword($mailData));
    }
}
