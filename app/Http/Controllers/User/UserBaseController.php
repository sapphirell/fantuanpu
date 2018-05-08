<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\System\CoreController;
use App\Http\Controllers\System\MailController;
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
        //发送找回邮件
        $userEmail = $request->input('email');
        $this->validate($request, ['email' => 'required|email'],['email' => '邮箱地址不能为空']);
        //检查用户60秒内有没有发送过找回邮件
        $cacheKey = CoreController::HAS_POST_MAIL_TO;
        $response = Cache::remember($cacheKey['key'].$userEmail ,$cacheKey['time'],function () use ($userEmail)
        {
            $accessToken = md5($userEmail.time());
            //发送邮件
            $data['url'] =  self::DOMAIN . "retrieve/?source=email&token=".$accessToken;
            $input = [
                'email' => $userEmail,
                'toUser' => "hentai@fantuanpu.com",
                'subject' => "密码找回",
                'msg' => '1234',
                'view' => 'Default'
            ];
            MailController::sendMail($input);

            //添加缓存锁
            return time();
        });
        if ($response == time())
        {
            return json_encode(['status'=>true,'msg'=>'发送成功']);
        }
        else
        {
            return json_encode(['status'=>false,'msg'=>'发送失败,发送间隔为60秒']);
        }
        //比较发送函数返回的时间戳和当前的时间戳,如果时间戳相等,则是发送成功
    }

}
