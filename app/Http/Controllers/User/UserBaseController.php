<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\System\CoreController;
use App\Http\Controllers\System\MailController;
use App\Http\Controllers\System\PictureController;
use App\Http\Controllers\System\RedisController;
use App\Http\DbModel\CommonMemberCount;
use App\Http\DbModel\CommonUsergroupModel;
use App\Http\DbModel\ForumThreadModel;
use App\Http\DbModel\ImModel;
use App\Http\DbModel\MedalModel;
use App\Http\DbModel\MemberFieldForumModel;
use App\Http\DbModel\UCenter_member_model;
use App\Http\DbModel\User_model;
use App\Http\DbModel\UserMedalModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redis;

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
        $chk = $this->checkRequest($request,['email','password']);

        if ($request->input('form') == 'app' && $chk !== true)
        {
            return self::response([],40001,'缺少参数'.$chk);
        }
        else
        {
            $messages = [
                'email.required'    => '邮箱不能为空',
                'password.required' =>'密码不能为空'
            ];
            $rules = [
                'email'     => 'required',
                'password'  => 'required'
            ];
        }



        self::validate($request, $rules, $messages);

        $login_status = UserApiController::Api_DoLogin($request);
        if (!$login_status)
        {
            if ($request->input('form') == 'app')
                return self::response([],40002,'密码输入错误');
            return back()->withErrors('密码输入错误');
        }

        if (!$request->input('form'))
            return redirect('/');
        if ($request->input('form') == 'layer') //layer提交特殊处理
            return "<script>window.parent.location.reload();</script>";
        if ($request->input('form') == 'app')
        {
            $data = User_model::getUserByEmial($request->input('email'));
            //用户登录token
            $data->token = md5( $data->uid. time());
            $cacheKey = CoreController::USER_TOKEN;
            $user_token = $cacheKey['key'] . $data->token ;

            Redis::setex($user_token,$cacheKey['time']*60,$data->uid);
        }
            return self::response($data);
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
                    return User_model::getUserListByNameOrMail($UserName);
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
        $this->data['user_info'] = session('user_info');
        $cacheKey = CoreController::USER_FIELD . $this->data['user_info']->uid;
        $this->data['field_forum'] =  Cache::remember($cacheKey['key'],$cacheKey['time'],function ()
        {
            return MemberFieldForumModel::find($this->data['user_info']->uid);
        });
        $this->data['user_count'] = CommonMemberCount::GetUserCoin($this->data['user_info']->uid);

//                dd($this->data);
        return view('PC/User/UserCenterView')->with('data',$this->data);
    }

    public function my_thread(Request $request)
    {
        $this->data['user_info'] = session('user_info');
        //查询用户最近发的帖子
        $this->data['my_thread'] = ForumThreadModel::where('authorid',$this->data['user_info']->uid)->orderBy('dateline','desc')->paginate(15);
        return view('PC/UserCenter/MyThread')->with('data',$this->data);
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
        $user->regdate      = time();
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
        $user->sellmedal    = 2;
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
    public function get_im_message()
    {
        //查询10条历史消息
        $this->data['msg'] = ImModel::orderBy('id','desc')->paginate(15);
        $user = session('user_info');
        if (!session('im_username'))
        {
            //未生成虚拟名称时候生成一次
            session(['im_username' => ['name'=>$this->rand_name(),'show_im_name'=>true,'id'=> session('access_id') ]]);
        }

        $this->data['im_username'] = $user->username ?: session('im_username')['name'];


        return $this->data;
    }
    public function live2d()
    {
        $this->get_im_message();
        return view('PC/User/Live2d')->with('data',$this->data);
    }
    public function rand_name()
    {
        $ornament = ['头戴草帽','手持巨剑','身负重甲','膝盖中箭','穿遇到异世界','擅长魔法','被qb选中'];
        $pre = ['蓝头发的','粉头发的','红头发的','长尾巴的','有一对猫耳的','赤瞳的','貌若天仙的','肌肉发达的','家财万贯的','短路的'];
        $center = ['痴呆','怨念','元气','弱气','弱渣','强气','笨蛋','机智','可爱','呆萌','凶猛','卑鄙'];
        $last = ['兔娘','猫娘','小恶魔','史莱姆','小公举','骑士','穿越者','飞龙','冒险者','勇者','王子','智者','先知','国王','机器人','人气偶像','过气偶像','魔法师','死宅'];
        return $ornament[rand(0,count($ornament)-1)].$pre[rand(0,count($pre)-1)].$center[rand(0,count($center)-1)].$last[rand(0,count($last)-1)];
    }
    public function get_my_message(Request $request)
    {}
    public function update_user_avatar(Request $request)
    {
        return view("PC/User/UpdateUserAvatar");
    }
    public function sell_old_medal(Request $request)
    {

        $user_session = User_model::find(session('user_info')->uid);

        if ($user_session->sellmedal != 1)
            return self::response([],40002,'已经兑换过了!');

        $user_session->sellmedal = 2;
        $user_session->save();
        UserHelperController::SetLoginStatus($user_session);
        $my_old_medal = DB::table('pre_forum_medalmybox')
                    ->leftJoin('pre_forum_medal','pre_forum_medalmybox.medalid','=','pre_forum_medal.medalid')
                    ->where('uid',$user_session->uid)->get();
        $user_score =[];
        foreach (CommonMemberCount::$extcredits as $key => $value)
        {
            $user_score[$key] = 0;
        }

        foreach ($my_old_medal as &$value)
        {
            $value->permission = common_unserialize($value->permission);
            if (strpos($value->permission[0], "extcredits") !== false)
            {
                //统计所有可贩卖价格
//                echo "\{ ".$value->permission[0] ."\}" ."<br>";
                $extcredits = explode(" ",$value->permission[0])[0];
                if ($extcredits && CommonMemberCount::$extcredits[$extcredits])
                    $user_score[$extcredits] += explode(" ",$value->permission[0])[2];
                $value->price = ['type'=>explode(" ",$value->permission[0])[0] , 'num'=>explode(" ",$value->permission[0])[2]];
            }
        }
        $user = User_model::find($user_session->uid);
        $user->sellmedal = 2;
        $user->save();
//        dd($user_score);
        CommonMemberCount::BatchAddUserCount($user_session->uid,$user_score);
        //标记用户为已经兑换


        return self::response();
    }
    public function my_medal(Request $request)
    {
        $this->data['user_info'] = session('user_info');
        $this->data['extcredits_name'] = CommonMemberCount::$extcredits;
        //查询我的旧勋章
        if ($this->data['user_info']->sellmedal == 1)
        {
            $this->data['my_old_medal'] = DB::table('pre_forum_medalmybox')->leftJoin('pre_forum_medal','pre_forum_medalmybox.medalid','=','pre_forum_medal.medalid')->where('uid',$this->data['user_info']->uid)->get();
            foreach ( $this->data['my_old_medal'] as &$value)
            {
                $value->permission = common_unserialize($value->permission);
                if (strpos($value->permission[0], "extcredits") !== false)
                {
                    //统计所有可贩卖价格
                    $this->data['old_score'][explode(" ",$value->permission[0])[0]] += explode(" ",$value->permission[0])[2];
                    $value->price = ['type'=>explode(" ",$value->permission[0])[0] , 'num'=>explode(" ",$value->permission[0])[2]];
                }
            }
        }
        //        dd( $this->data['old_score']);
//        UserMedalModel::flush_user_medal(session('user_info')->uid);
        //查询我佩戴的勋章,我的保管箱等
        $this->data['my_medal'] = UserMedalModel::get_user_medal(session('user_info')->uid);
//        dd($this->data['my_medal']);

        return view('PC/UserCenter/MyMedal')->with('data',$this->data);

    }

    /**
     * 戴起勋章
     * @param Request $
     */
    public function adorn_mine(Request $request)
    {
        //检查是否有该勋章
        $medal = UserMedalModel::find($request->input('mid'));
        if (empty($medal))
            return self::response([],40002,'勋章记录不存在');
        //勋章归属
        if ($medal->uid != session('user_info')->uid )
            return self::response([],40003,'该勋章不属于你');
        //该勋章是否在保管箱中
        if ($medal->status != 2)
            return self::response([],40004,'勋章必须存储于保管箱中');
        //佩戴数目是否少于4
        $count = count(UserMedalModel::get_user_medal(session('user_info')->uid)['in_adorn']);
        if ($count > 3)
            return self::response([],40005,'同一时间佩戴的勋章最多4枚');

        $medal->status = 1;
        $medal->save();
        //刷新用户佩戴缓存
        UserMedalModel::flush_user_medal(session('user_info')->uid);
        return self::response([],200,'佩戴成功');
    }

    /**
     * 放入保管箱
     * @param Request $request
     */
    public function put_in_box(Request $request)
    {
        //检查是否有该勋章
        $medal = UserMedalModel::find($request->input('mid'));
        if (empty($medal))
            return self::response([],40002,'勋章记录不存在');
        //勋章归属
        if ($medal->uid != session('user_info')->uid )
            return self::response([],40003,'该勋章不属于你');
        //该勋章是否佩戴中
        if ($medal->status != 1)
            return self::response([],40004,'勋章必须佩戴中');

        $medal->status = 2;
        $medal->save();
        //刷新用户佩戴缓存
        UserMedalModel::flush_user_medal(session('user_info')->uid);
        return self::response([],200,'成功取下');
    }
    /**
     * 购买勋章
     * @param Request $request
     */
    public function buy_medal(Request $request)
    {
        if($request->input('source') == 'medal_shop')
        {
            //购买一手勋章
            //勋章是否存在
            $medal = MedalModel::find($request->input('medal_id'));
            if (empty($medal))
                return self::response([],40001,'勋章不存在');
            //库存是否足够
            if ($medal->limit < 1)
                return self::response([],40002,'勋章库存不足');
            //是否在售
            if (time() < strtotime($medal->sell_start))
                return self::response([],40003,'勋章还未开售');
            if (time() > strtotime($medal->sell_end))
                return self::response([],40003,'勋章已经截止出售');
            //积分是否足够
            $need_score = json_decode($medal->medal_sell,true);
            $user_count = CommonMemberCount::find(session('user_info')->uid);
            $pay = [];

            foreach ($need_score as $value)
            {
                if ($user_count[$value['score_type']] < $value['score_value'])
                    return self::response([],40004,'您的'.CommonMemberCount::$extcredits[$value['score_type']]
                        .'不足,需要'.$value['score_value'].',您有'.$user_count[$value['score_type']] );
                $pay[$value['score_type']] -=  $value['score_value'];
            }

//            CommonMemberCount::BatchAddUserCount();

        }
        $res = DB::transaction(function () use ($pay,$request,$medal) {
            //用户扣钱
            CommonMemberCount::BatchAddUserCount(session('user_info')->uid,$pay,'BNM',$request->input('medal_id'));
            //用户加勋章
            $userMedal = new UserMedalModel();
            $userMedal->uid = session('user_info')->uid;
            $userMedal->mid = $request->input('medal_id');
            $userMedal->status = 2;
            $userMedal->save();
            if ($request->input('source') == 'medal_shop')
            {
                //买一手勋章,要扣除库存
                $medal->limit -= 1;
                $medal->save();
            }
            else{
                //TODO:如果是买二手,还需要扣除勋章
            }

        });


        //更新用户佩戴勋章缓存
        UserMedalModel::flush_user_medal(session('user_info')->uid);
        //更新勋章缓存
        MedalModel::flush_medal($request->input('medal_id'));
        return self::response([],200,'购买成功,请查看保管箱');
    }

}
