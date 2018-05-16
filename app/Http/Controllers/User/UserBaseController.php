<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\System\CoreController;
use App\Http\Controllers\System\MailController;
use App\Http\DbModel\UCenter_member_model;
use App\Http\DbModel\User_model;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;

class UserBaseController extends Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function LoginView(){

        return view('PC/User/Login')->with('data',$this->data);
    }
    public function Register()
    {
        return view('PC/User/Register')->with('data',$this->data);
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


        //redirect('/')
        return UserApiController::Api_DoLogin($request)
                                ? "<script>window.parent.location.reload();</script>"
                                : back()->withErrors('密码输入错误');
    }
    public function LogOut(Request $request)
    {
        $request->session()->pull('user_info');
        return redirect()->route('forum');
    }
    public function OldUser(Request $request)
    {
        if ($request->has('username'))
        {
            $UserName = $request->input('username');
            $cacheKey = CoreController::OLD_USER;
            $this->data['user-list'] = Cache::remember($cacheKey['key'].$UserName, $cacheKey['time'],
                function () use ($UserName){
                    return User_model::getUserListByUsername($UserName);
                });
        }
        $this->data['search-username'] = $UserName;

        return view('PC/User/OldUserView')->with('data',$this->data);
    }
    public function GetAccountByEmail(Request $request)
    {
        $this->data['by-email'] = $request->input('email');
        $this->data['backUrl']  = "/old-user?";
        return view('PC/User/GetAccountByEmail')->with('data',$this->data);
    }
    public function RetrieveMail(Request $request)
    {
        $userEmail = $request->input('email');
//        {
//            Cache::put($userEmail, 1234, 5);
//            return self::response(['status'=>true],200,'发送成功');
//        }

        //发送找回邮件
        $this->validate($request, ['email' => 'required|email'],['email' => '邮箱地址不能为空']);
        //检查用户60秒内有没有发送过找回邮件
        $cacheKey = CoreController::HAS_POST_MAIL_TO;
        $response = Cache::remember($cacheKey['key'].$userEmail ,$cacheKey['time'],function () use ($userEmail)
        {
            $accessToken = md5($userEmail.time());
            //发送邮件
            $data['url'] =  self::DOMAIN . "retrieve/?source=email&token=".$accessToken;
            $code = rand(1000,9999);
            $input = [
                'email' => $userEmail,
                'toUser' => "hentai@fantuanpu.com",
                'subject' => "饭团扑动漫-密码找回邮件",
                'msg' => '您的验证码为'.$code.',请在5分钟内填写~',
                'view' => 'Default'
            ];
            MailController::sendMail($input);
            Cache::put($userEmail, $code, 5);
            //添加缓存锁
            return time();
        });
        if ($response == time())
        {
            return self::response(['status'=>true],200,'发送成功');
        }
        else
        {
            return  self::response(['status'=>false],200,'发送失败,发送间隔为60秒');
        }
        //比较发送函数返回的时间戳和当前的时间戳,如果时间戳相等,则是发送成功
    }
    public function ResetPassword(Request $request)
    {
        $this->data['email'] = $request->input('email');
        return view('PC/User/ResetPasswordView')->with('data',$this->data);
    }
    public function DoResetPassword(Request $request)
    {
        foreach (['email','password','repassword','code'] as $value)
        {
            if (empty($request->input($value)))
            {
                return self::response([],40001,'缺少参数'.$value);
            }
        }
        $user_code = Cache::get($request->input('email'));
        //检查code是否正确
        if ($request->input('code') != $user_code)
        {
            return self::response([],40003,'验证码错误');
        }
        if ($request->input('password') != $request->input('repassword'))
        {
            return self::response([],40004,'两次密码输入不相等');
        }
        $user = UCenter_member_model::where('email','=',$request->input('email'))->select()->first();
        if (empty($user))
        {
            return self::response([],40005,'用户不存在');
        }
        $user->password = md5(md5( $request->input('password') ). $user->salt);
        $user->save();
        return self::response();
    }
    public function UserCenter(Request $request)
    {
        return view('PC/User/UserCenterView')->with('data',$this->data);
    }
    public function DoRegister(Request $request)
    {
        $ck = $this->checkRequest($request,['username','email','password','repassword']);
        if( $ck !== true)
        {
            return self::response([$request->input()],40001,'缺少参数'.$ck);
        }
        $userModel = UCenter_member_model
                        ::where('username', $request->input('username'))
                        ->where('email',    $request->input('email'))
                        ->select()->first();
        if ($userModel->uid)
        {
            return self::response([],40002,'用户已经注册');
        }
        if ($request->input('password') != $request->input('repassword'))
        {
            return self::response([],40003,'两次输入密码不等');
        }
        $user               = new UCenter_member_model();
        $user->username     = $request->input('username');
        $user->salt         = substr(md5(time()),0,6);
        $user->password     = md5(md5( $request->input('password') ). $user->salt);
        $user->email        = $request->input('email');
        $user->regip        = $request->getClientIp();
        $user->regdate        = time();
        $user->save();
        //检测用户名是否在userModel中存在,这种情况一般是因为usermodel中删号了uc中没删号

        /**
         * 同步userModel
         */
        $userModel = new User_model();
        $userModel->username =  $request->input('username');
        $userModel->email   =  $request->input('email');
        $userModel->password =  $user->password ;
        $userModel->regdate =  time() ;
        $userModel->groupid = 8;//等待验证会员
        $userModel->save();

        /**
         * 同步登陆状态
         */
        UserApiController::Api_DoLogin($request);
        return self::response();
    }

    /**
     *  检测用户名是否已经注册
     */
    public function checkUsername(Request $request)
    {
        $userinfo = UCenter_member_model::where('username',$request->input('username'))->select()->first();
        if ($userinfo->uid)
        {
            return self::response(['exists'=>true],200);
        }
        else
        {
            return self::response(['exists'=>false],200);
        }
    }
    /**
     *  检测email是否被注册
     */
    public function checkEmail(Request $request)
    {
        $userinfo = UCenter_member_model::where('email',$request->input('email'))->select()->first();
        if ($userinfo->id)
        {
            return self::response(['exists'=>true],200);
        }
        else
        {
            return self::response(['exists'=>false],200);
        }
    }
}
