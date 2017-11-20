<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserBaseController extends Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function LoginView(){
        return view('PC/User/Login')->with('data',$this->data);
    }

    public function DoLogin(Request $request){
        $messages = [
            'email.required' => '邮箱不能为空',
            'password.required' =>'密码不能为空'
        ];
        $rules = [
            'email' => 'required',
            'password' => 'required'
        ];


        self::validate($request, $rules, $messages);



        return UserApiController::Api_DoLogin($request)
                                ? redirect('/')
                                : back()->withErrors('密码输入错误');
    }
    public function LogOut(Request $request){
        $request->session()->pull('user_info');
        return redirect()->route('home');
    }


}
