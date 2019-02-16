<?php

namespace App\Http\Controllers\SukiWeb;

use App\Http\Controllers\Forum\ThreadApiController;
use App\Http\Controllers\Sukiapp\CommonApiController;
use App\Http\DbModel\CommonMemberCount;
use App\Http\DbModel\Forum_forum_model;
use App\Http\DbModel\ForumPostModel;
use App\Http\DbModel\ForumThreadModel;
use App\Http\DbModel\MemberFieldForumModel;
use App\Http\DbModel\MyLikeModel;
use App\Http\DbModel\SukiClockModel;
use App\Http\DbModel\SukiFriendRequestModel;
use App\Http\DbModel\SukiMessageBoardModel;
use App\Http\DbModel\Thread_model;
use App\Http\DbModel\UCenter_member_model;
use App\Http\DbModel\User_model;
use App\Http\DbModel\UserReportModel;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class SukiWebApiController extends Controller
{
    /**
     * 回复suki帖子
     * @param Request $request
     */
    public function suki_reply_thread(Request $request,ThreadApiController $threadApiController)
    {
        return $threadApiController->PostsThread($request,false,"suki");
    }
    public function get_thread(Request $request,Thread_model $thread_model)
    {
        //                dd($request->input("view_forum"));
        //设置用户访问的板块
        self::set_suki_view(session("user_info")->uid ?: 0, $request->input("view_forum") ?: [157]);

        //获取帖子
        $this->data['thread'] = ForumThreadModel::get_new_thread(
            $request->input("view_forum"),
            $request->input("page") ?: 1
        );

        if ($request->input("need") == 'html')
        {
            return empty($this->data['thread']) ? "" : view('PC/Suki/SukiThreadList')->with('data', $this->data);
        }
        elseif($request->input("need") == 'json')
        {
            return self::response($this->data);
        }
        else
        {
            return self::response([],40000,"缺少参数need");
        }

    }

    /**
     * 在suki发表新的帖子
     */
    public function suki_new_thread(Request $request,ThreadApiController $threadApiController)
    {
        $user_info      = session('user_info');

        if (empty($user_info))
            return self::response([],40002,'需要登录');
        if($user_info->groupid == 4 || $user_info->groupid == 5)
            return self::response([],40003,'您的账户已被禁言');
        if($user_info->groupid == 8)
            return self::response([],40003,'您的账户邮箱未验证,因此不能发表主题');

        $checkParams = $this->checkRequest($request,['subject','message']);
        if($checkParams !== true)
        {
            return self::response([],40001,'缺少参数'.$checkParams);
        }

        $fid    = $request->input('fname')
            ? Forum_forum_model::where('name',"=",$request->input('fname'))->first()->fid
            : $request->input('fid');
        if (!$fid)
            return self::response([],40004,'请选择发帖分类');

        $threadApiController->_newThread(
            $fid,
            $request->input('subject'),
            $request->input('message'),
            $request->getClientIp(),
            $user_info,
            "suki"
        );
        return self::response();
    }


    /***
     * 用户空间留言
     * @param Request $request
     * @返回 mixed
     */
    public function suki_reply_board(Request $request)
    {
        $check = self::checkRequest($request,["uid","message"]);
        if ($check !== true)
            return self::response([],40001,"缺少参数".$check);

        $message = new SukiMessageBoardModel();
        $message->uid = $request->input("uid");
        $message->authorid = $this->data['user_info']->uid;
        $message->message = $request->input("message");
        $message->send_time = time();
        $message->save();

        return self::response([],200,"留言成功");

    }

    /**
     * 关注用户
     * @param Request $request
     */
    public function suki_follow_user(Request $request)
    {

        $check = self::checkRequest($request,["uid","to_uid","to_do"]);
        if ($check !== true)
            return self::response([],40001,"缺少参数$check");
        if ($request->input("uid") == $request->input("to_uid"))
            return self::response([],40003,"不能关注或取关自己");
        $like_all = MyLikeModel::get_user_like($request->input("uid"),4);
        $uid_arr =[];
        foreach ($like_all as $value)
        {
            $uid_arr[] = $value->like_id;
        }


        if ($request->input("to_do") == "follow" )
        {
            if (in_array($request->input("to_uid"),$uid_arr))
            {
                return self::response([],40002,"已经关注了");
            }
            else
            {
                MyLikeModel::add_user_like($this->data["user_info"]->uid,$request->input("to_uid"),4);
                CommonMemberCount::AddUserCount($this->data["user_info"]->uid,"followsuki");
                CommonMemberCount::AddUserCount($request->input("to_uid"),"followsuki");
                return self::response([],200,"关注成功了");
            }


        }
        if ($request->input("to_do") == "unfollow" )
        {
            if (in_array($request->input("to_uid"),$uid_arr))
            {
                MyLikeModel::rm_user_like($this->data["user_info"]->uid,$request->input("to_uid"),4);
                CommonMemberCount::AddUserCount($this->data["user_info"]->uid,"followsuki",-1);
                CommonMemberCount::AddUserCount($request->input("to_uid"),"followsuki",-1);
                return self::response([],200,"取消关注成功");
            }
            else
            {
                return self::response($request->input(),40002,"您还未关注");
            }


        }
    }

    /**
     * 添加suki好友
     * @param Request $request
     */
    public function add_suki_friend(Request $request)
    {
        $check = self::checkRequest($request,["friend_id","message"]);
        if ($check !== true)
            return self::response([],40001,"缺少参数".$check);
        if ($request->input("friend_id") == $this->data["user_info"]->uid)
            return self::response([],40002,"您不能和自己成为朋友-_-");
        $res = CommonApiController::_suki_send_friend_request($this->data["user_info"]->uid,$request->input("friend_id"),$request->input("message"));

        return $res ? self::response([],200,"已经发送申请") : self::response([],40002,"你们已经是好友了");
    }

    /***
     * suki添加喜欢帖子
     */
    public function add_suki_like(Request $request)
    {
        $check = self::checkRequest($request,["tid","todo"]);
        if ($check !== true)
            return self::response([],40001,"缺少参数{$check}");
        $has_follow = MyLikeModel::has_like($this->data['user_info']->uid,$request->input("tid"),3);

        if ($request->input("todo") == "follow")
        {
            if ($has_follow)
                return self::response([],40002,"已经喜欢过该帖子了~");

            CommonApiController::_suki_add_my_like_thread($this->data['user_info']->uid,$request->input('tid'));
            return self::response([],40002,"收藏成功");
        }
        else
        {
            if (!$has_follow)
                return self::response([],40002,"尚未关注~");
            CommonApiController::_suki_rm_my_like_thread($this->data['user_info']->uid,$request->input('tid'));
            return self::response([],40002,"取关成功");
        }
    }

    /**
     * 添加suki的好友
     */
    public function apply_suki_friends(Request $request)
    {
        $check = self::checkRequest($request,["applicant_id","ship_id","to_do"]);
        if ($check !== true)
            return self::response([],40001,"缺少参数$check");

        $res = SukiFriendRequestModel::apply_suki_friend_request(
                $request->input("applicant_id"),
                $request->input("ship_id"),
                $request->input("to_do")
            );

        if ($res == true)
            return self::response();
        else
            return self::response([],40002,"操作失败,该申请已失效。");
    }
    // suki闹钟增删改查
    public function setting_clock(Request $request)
    {
        $check = self::checkRequest($request,['name','money','date']);
        if ($check !== true)
            return self::response([],40001,"缺少参数$check");
        if ($request->input('cid'))
            $data = SukiClockModel::find($request->input('cid'));
        else
        {
            $data = new SukiClockModel();

            if (empty($data))
                return self::response([],40002,"记录不存在");
        }
        if ($request->input('to_do') == 'del')
        {
            $data->delete();
            return self::response();
        }

        $data->uid = $this->data['user_info']->uid;
        $data->clock_name = $request->input("name");
        $data->clock_money = $request->input("money");
        $data->clock_date = $request->input("date");
        $data->clock_end = $request->input("clock_end");
        $data->save();

        return self::response();
    }

    //suki闹钟提醒方式修改
    public function setting_clock_alert(Request $request)
    {
        $check = self::checkRequest($request,['id','alert_type']);
        if ($check !== true)
            return self::response([],40001,"缺少参数$check");

        $clock = SukiClockModel::find($request->input("id"));
        if (empty($clock->cid))
            return self::response([],40001,"该闹钟不存在");

        $clock->alert_type = $request->input("alert_type");
        $clock->save();

        return self::response();
    }
    //修改suki的用户信息
    public function update_suki_user_info(Request $request)
    {
        $user = User_model::find($this->data['user_info']->uid);
        if ($request->input("sightml") != $this->data['field_forum']->sightml)
        {
            MemberFieldForumModel::update_field($this->data['user_info']->uid,["sightml"=>$request->input("sightml")]);
        }
        $old_password = $request->input("old_password");
        $new_password = $request->input("new_password");
        $repeat_password = $request->input("repeat_password");
        if ($old_password || $new_password || $repeat_password)
        {
            $check = self::checkRequest($request,["old_password","new_password","repeat_password"]);
            if ($check !== true)
                return self::response([],40001,"缺少参数{$check}");
            if ($new_password != $repeat_password)
                return self::response([],40002,"两次输入密码不相符");

            $uc_data = UCenter_member_model::find($this->data['user_info']->uid);
            if ($uc_data->password != UCenter_member_model::GetSaltPass($old_password,$uc_data->salt))
                return self::response([],40003,"原密码输入错误");
            UCenter_member_model::UpdateUserPassword($this->data['user_info']->uid,$uc_data->password);

        }

        User_model::flushUserCache($this->data['user_info']->uid);
        return self::response();
    }
    //获取suki下一页帖子
    public function suki_next_page(Request $request,Thread_model $thread_model)
    {
        if (empty($request->input('tid')))
            return self::response([],40001,'缺少tid');
        if (empty($request->input('page')))
            return self::response([],40001,'缺少page');

        $data = $thread_model->getPostOfThread($request->input('tid'),$request->input('page'));
        foreach ($data as &$value)
        {
            $value->avatar = config('app.online_url').\App\Http\Controllers\User\UserHelperController::GetAvatarUrl($value>authorid);
        }
        $anonymous = in_array($data[0]->fid,self::$anonymous_forum);

        return $request->input('need') == 'html' ? view("PC/Suki/SukiReply")->with('data',['thread_post'=>$data,'anonymous'=>$anonymous]): self::response($data);
    }
    //修改suki的帖子 (标题不可以修改)
    public function update_suki_thread(Request $request)
    {
        $check = self::checkRequest($request,["tid","position","message"]);
        if ($check !== true)
            return self::response(40001,[],"缺少参数{$check}");
        Thread_model::updatePost(
            $request->input("tid"),
            $request->input("position"),
            $request->input("message")
        );
        return self::response();
    }
    //发起举报
    public function suki_post_report(Request $request)
    {
        $check = self::checkRequest($request,["type","message"]);
        if ($check !== true)
            return self::response(40001,[],"缺少参数{$check}");

        $report = new UserReportModel();
        $report->message = $request->input("message");
        $report->uid = $this->data['user_info']->uid;
        $report->user_name = $this->data['user_info']->username;
        $report->message = $request->input("message");
        $report->title = "suki用户举报/反馈";
        $report->type = $request->input("type");
        $report->origin = $request->input("origin");
        $report->save();
        return self::response([],200,"举报成功,反馈结果会以站内私信的形式通知您。如果您非常急切得到反馈,可以在站内发帖联系我们。");
    }

    public function suki_set_top_thread(Request $request)
    {
        $check = self::checkRequest($request,["tid","todo"]);

        if (!in_array($this->data['user_info']->uid,self::MASTER_USER))
            return self::response([],40002,"您无权操作");

        $update = ForumThreadModel::set_top_thread($request->input("tid"),$request->input("todo"));
        return self::response([],200,'设置成功,请等待一分钟后生效');
    }
}
