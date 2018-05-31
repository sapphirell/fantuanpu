<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\System\CoreController;
use App\Http\Controllers\System\MailController;
use App\Http\Controllers\System\PictureController;
use App\Http\DbModel\ImModel;
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

    public function LoginView(Request $request)
    {
        $this->data['form'] = $request->input('form');
        return view('PC/User/Login')->with('data',$this->data);
    }
    public function Register()
    {
        return view('PC/User/Register')->with('data',$this->data);
    }
    public function DoLogin(Request $request){
        $messages = [
            'email.required'    => '邮箱不能为空',
            'password.required' =>'密码不能为空'
        ];
        $rules = [
            'email'     => 'required',
            'password'  => 'required'
        ];


        self::validate($request, $rules, $messages);

        $login_status = UserApiController::Api_DoLogin($request);
        if (!$login_status)
        {
            return back()->withErrors('密码输入错误');
        }
        else
        {
            if ($request->input('form') == 'layer')
            {
                //layer提交特殊处理
                return "<script>window.parent.location.reload();</script>";
            }
            else
            {
                return redirect('/');
            }
        }
        //redirect('/')

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
                'email'     => $userEmail,
                'toUser'    => "hentai@fantuanpu.com",
                'subject'   => "饭团扑动漫-密码找回邮件",
                'msg'       => '您的验证码为'.$code.',请在5分钟内填写~',
                'view'      => 'Default'
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

    /**
     * 修改头像
     * @param Request $request
     * @返回 $this|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function DoUploadAvatar(Request $request)
    {

        if ($request->file('file'))
        {
            if ($request->file('file')->getSize() > 2000000){//图片大小
                return back()->withErrors('图片过大');
            }

            $file       = $request->file('file');
            $mimeType   = '.'.$file->getClientOriginalExtension();//文件后缀
            $newFile    = $file->move(public_path('uploads/avatar/temporary'),md5(time()).$mimeType)->getRealPath();
        }
        else
        {
            //编辑已有头像
            $user = session('user_info');
            $newFile = public_path(UserHelperController::GetAvatarUrl($user->uid,'big'));
            $cp     = public_path('uploads/avatar/temporary').md5($user->uid).'.gif';
            copy($newFile,$cp);
            $newFile = $cp;
        }

        $canvas     = $request->input('position');

        $CutResult  = PictureController::AvaCut($canvas,$newFile);

        return back();



    }
    public function live2d()
    {
        //查询10条历史消息
        $this->data['msg'] = ImModel::orderBy('id','desc')->paginate(15);
        $user = session('user_info');
        $this->data['im_username'] = $user->username;
        if (!session('im_username'))
        {
            session(['im_username' => ['name'=>$this->rand_name(),'show_im_name'=>true,'id'=>  md5(microtime(true)) ]]);
        }
        //决定是否显示im名字
        $im = session('im_username');
        if (!$im['show_im_name'] && $user->username)
        {
            //只有登录并且设置为不显示im名字时候才显示username
            $this->data['username']  = $user->username;
        }
        else
        {
            $this->data['username']  = $im['name'];
        }
        $this->data['im_userid'] = $im['id'];

        return view('PC/User/Live2d')->with('data',$this->data);
    }
    public function rand_name()
    {
        $ornament = ['头戴草帽','手持巨剑','身负重甲','膝盖中箭','穿遇到异世界','擅长魔法','被qb选中'];
        $pre = ['蓝头发的','粉头发的','红头发的','长尾巴的','有一对猫耳的','赤瞳的','貌若天仙的','肌肉发达的','家财万贯的'];
        $center = ['痴呆','怨念','元气','弱气','弱渣','强气','笨蛋','机智','可爱','呆萌','凶猛','卑鄙'];
        $last = ['兔娘','猫娘','小恶魔','史莱姆','小公举','骑士','穿越者','飞龙','冒险者','勇者','王子'];
        return $ornament[rand(0,count($ornament)-1)].$pre[rand(0,count($pre)-1)].$center[rand(0,count($center)-1)].$last[rand(0,count($last)-1)];
    }

}
