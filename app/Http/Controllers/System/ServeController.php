<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Forum\ForumBaseController;
use App\Http\Controllers\News\SukiController;
use App\Http\Controllers\SukiWeb\SukiWebController;
use App\Http\Controllers\User\UserBaseController;
use App\Http\DbModel\CommonMemberCount;
use App\Http\DbModel\Forum_forum_model;
use App\Http\DbModel\ForumPostModel;
use App\Http\DbModel\ForumThreadModel;
use App\Http\DbModel\SukiClockModel;
use App\Http\DbModel\Thread_model;
use App\Http\DbModel\UCenter_member_model;
use App\Http\DbModel\User_model;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ServeController extends Controller
{
    public static function ss(){
//        dd(session()->all());
        self::change_username();
    }
    public static function info(){
        phpinfo();
    }
    public static function mem(){}

    public function index(Request $request)
    {
        $domain = $request->getHost();
        if (in_array($domain,self::$local_domain))
            return view("PC/Common/LocalhostIndex");
        if (in_array($domain,self::$fantuanpu_domain))
            return (new ForumBaseController((new Forum_forum_model()) , (new Thread_model())))
                ->ForumIndex($request,(new UserBaseController())); // -_-什么鬼...
        if (in_array($domain,self::$local_domain));
            return (new SukiWebController())->index($request);
    }
    public function clock_alert()
    {
        $data = SukiClockModel::where(["clock_date" => date("Y-m-d"),"alert_type"=>2])->get();
        $user_clock = [];
        //今天的提醒
        foreach ($data as $value)
        {
            //按人分
            $user_clock[$value->uid]["today"][] = $value;
        }
        //明天的提醒
        $data = SukiClockModel::where(["clock_date" =>  date("Y-m-d",strtotime("+1 day")),"alert_type"=>2 ])->get();
        foreach ($data as $value)
        {
            //按人分
            $user_clock[$value->uid]["tomorrow"][] = $value;
        }
        //补款最后一天
        $data = SukiClockModel::where(["clock_end" =>  date("Y-m-d"),"alert_type"=> 2 ])->get();
        foreach ($data as $value)
        {
            //按人分
            $user_clock[$value->uid]["lastday"][] = $value;
        }
        //开始提醒
        foreach ($user_clock as $uid => $value)
        {
            $user = User_model::find($uid);
            $param["msg"] = $value;
            $param["subject"] = "Suki闹钟提醒";
            return MailController::email_to($user->email,"RemindersMail",$param,function () {});
        }
        return "ok";
    }

    public function del_thread(Request $request)
    {
        if (!$request->input("tid"))
            return self::response([],40001,"缺少参数tid");

        if (!$this->data["user_info"]->uid)
            return self::response([],40002,"请先登录");
        if (!in_array($this->data["user_info"]->uid,self::MASTER_USER))
            return self::response([],40003,"您无权操作");
        ForumThreadModel::delThread($request->input("tid"),$request->input("todo"));
        return self::response();
    }

    public function del_post(Request $request)
    {
        if (!$request->input("pid"))
            return self::response([],40001,"缺少参数pid");
        if (!$this->data["user_info"]->uid)
            return self::response([],40002,"请先登录");
        if (!in_array($this->data["user_info"]->uid,self::MASTER_USER))
            return self::response([],40003,"您无权操作");
        ForumPostModel::delPosts($request->input("pid"),$request->input("todo"));

        return self::response();
    }

    public function change_username()
    {
        $uid = 1;
        $newName = "Ran";
        $user = User_model::find($uid);
        $user->username = $newName;
        $user->save();
        User_model::flushUserCache($uid);
        $user = UCenter_member_model::find($uid);
        $user->username = $newName;
        $user->save();
        ForumThreadModel::where(['authorid'=>$uid])->update(['author'=>$newName]);
        ForumPostModel::where(['authorid'=>$uid])->update(['author'=>$newName]);
    }
}
