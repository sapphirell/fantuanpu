<?php

namespace App\Http\Controllers\SukiWeb;

use App\Http\Controllers\Forum\ThreadController;
use App\Http\DbModel\CommonMemberCount;
use App\Http\DbModel\Forum_forum_model;
use App\Http\DbModel\ForumPostModel;
use App\Http\DbModel\ForumThreadModel;
use App\Http\DbModel\MemberFieldForumModel;
use App\Http\DbModel\MyLikeModel;
use App\Http\DbModel\SukiClockModel;
use App\Http\DbModel\SukiFriendModel;
use App\Http\DbModel\SukiFriendRequestModel;
use App\Http\DbModel\SukiMessageBoardModel;
use App\Http\DbModel\SukiNoticeModel;
use App\Http\DbModel\Thread_model;
use App\Http\DbModel\User_model;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class SukiWebController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->data["count"] = CommonMemberCount::find($this->data['user_info']->uid);
    }
    public function index(Request $request)
    {
        $this->data['nodes'] = (new Forum_forum_model())->get_suki_nodes();
        $this->data['thread'] = ForumThreadModel::get_new_thread(
            json_decode(session("setting")->lolita_viewing_forum),
            $request->input("page")?:1
        );
        return view('PC/Suki/News')->with('data',$this->data);
    }
    /**
     * 查看suki空间的follow
     * @param Request $request
     * @返回 $this
     */
    public function suki_myfollow(Request $request)
    {
        if ($request->input("like_type") == 1) // 用户
        {

            $this->data["my_follow"]= MyLikeModel::get_user_like($this->data['user_info']->uid,$request->input("like_type"));
            foreach ($this->data["my_follow"] as &$value)
            {
                $value->user = User_model::find($value->like_id,["username","uid"]);
            }
        }
        //            $this->data["follow"] = MyLikeModel::leftJoin("pre_common_member","pre_my_like.like_id",'=',"pre_common_member.uid")
        //                ->where("pre_common_member.uid",$this->data['user_info']->uid)
        //                ->where("pre_my_like.like_type",1)
        //                ->get();

        //        dd( $this->data["my_follow"]);
        return view("PC/Suki/SukiMyFollow")->with("data",$this->data);
    }

    /**
     * @param $uid
     * @返回 $this
     */
    public function suki_userhome($uid)
    {
        $this->data['user'] = User_model::find($uid);
        $this->data['thread'] = ForumThreadModel::get_user_thread($uid,1,2);
        $this->data['has_follow'] = MyLikeModel::has_like($this->data["user_info"]->uid,$uid,4);
        $this->data['message_board'] = SukiMessageBoardModel::get_user_message($uid,1);

        return view("PC/Suki/SukiUserHome")->with("data",$this->data);
    }

    /**
     * @param Request $request
     */
    public function suki_get_user_thread(Request $request)
    {
        $check = self::checkRequest($request,["uid","page","need"]);
        if ($check !== true)
            return self::response([],40001,"缺少参数".$check);
        $this->data['thread'] = ForumThreadModel::get_user_thread($request->input("uid"),$request->input("page"));


        return $request->input("need")  == "html" ? view("PC/Suki/SukiUcThreadlist")->with("data",$this->data) :self::response($this->data['thread']);
    }



    /***
     * 查看suki的帖子
     * @param Request $request
     */
    public function view_thread(Request $request,$tid,$page)
    {
//        dd($this->data);
        $this->data = (new ThreadController(new Thread_model()))->_viewThread($tid,$page);
        $this->data["count"] = CommonMemberCount::find($this->data['user_info']->uid);
        $this->data['has_collection'] = MyLikeModel::has_like(
            $this->data['user_info']->uid?:0,
            $this->data['thread']['thread_subject']->tid,
            3);
//        dd($this->data);
        return view('PC/Suki/SukiThread')->with('data',$this->data);
    }

    /**
     * 弹出的suki加好友申请的面板
     * @param Request $request
     */
    public function add_suki_friend_view(Request $request)
    {
        return  view('PC/Suki/SukiAddFriend')->with('data',$this->data);
    }

    /**
     * 用户提醒列表
     * @param Request $request
     */
    public function suki_notice(Request $request)
    {
        switch ($request->input("type"))
        {
            case "reply_me" :
                $this->data["reply_me"] = SukiNoticeModel::find_user_notice($this->data['user_info']->uid,1);
                break;
            case "my_message": //我的私信
                break;
            case "call_me": //@

                break;
            case "friends_request":
                $this->data['friends_request'] = SukiFriendRequestModel::get_user_friend_request(
                    $this->data['user_info']->uid,
                    $request->input('page')?:1
                );
                break;
            default :
                $this->data["reply_me"] = SukiNoticeModel::find_user_notice($this->data['user_info']->uid,1);
                break;
        }
//        dd($this->data);
        return  view('PC/Suki/SukiNoticeView')->with('data',$this->data);
    }

    //suki的 关注 粉丝 好友
    public function suki_relationship(Request $request)
    {

        switch ($request->input("type"))
        {
            case "my_follow" :
                $this->data['title'] = "我关注的";
                $this->data["my_follow"]= MyLikeModel::get_user_like($this->data['user_info']->uid,4);
                foreach ($this->data["my_follow"] as &$value)
                {
                    $value->user = User_model::find($value->like_id,["username","uid"]);
                }

                break;
            case "follow_me":
                $this->data['title'] = "关注我的";
                $this->data["follow_me"]= MyLikeModel::get_follow_that($this->data['user_info']->uid,4);
                foreach ($this->data["follow_me"] as &$value)
                {

                    $value->user = User_model::find($value->like_id,["username","uid"]);
                    $value->has_follow = MyLikeModel::has_like($this->data['user_info']->uid,$value->like_id,4);
                }


                break;

            case "friends":
                $this->data['title'] = "我的好友";
                $this->data['my_friends'] = SukiFriendModel::get_my_friends($this->data['user_info']->uid,$request->input("page"));
                break;
            default :

                break;
        }
//        dd($this->data);
        return  view('PC/Suki/SukiRelationship')->with('data',$this->data);
    }
    //suki补款闹钟
    public function suki_alarm_clock(Request $request)
    {
        $group = $request->input("group") ? : false;
        $this->data['title']    = "补款闹钟";
        $this->data["my_clock"] = SukiClockModel::get_user_clock($this->data['user_info']->uid,$group);
//        dd($this->data["my_clock"]);
        return view('PC/Suki/SukiAlarmClock')->with('data',$this->data);
    }
    //新增闹钟
    public function suki_clock_setting(Request $request)
    {
        $this->data['title'] = "补款闹钟";
        return view('PC/Suki/SukiClockSetting')->with('data',$this->data);
    }
    //信誉墙
    public function suki_tribunal(Request $request)
    {
        $this->data['title'] = "lolita信誉墙";
        return view('PC/Suki/SukiTribunal')->with('data',$this->data);
    }
    //用户信息
    public function suki_user_info(Request $request)
    {
        return  view('PC/Suki/SukiMyUserCenter')->with('data',$this->data);
    }
    public function about_suki()
    {
        return  view('PC/Suki/SukiAbout')->with('data',$this->data);
    }
    //suki 搜索
    public function suki_search(Request $request)
    {
    }
    //编辑帖子
    public function suki_editor_post_view(Request $request)
    {
        $this->data['posts'] = ForumPostModel::where([
            "tid"       => $request->input("tid"),
            "position"  => $request->input("position")
        ])->first();
        return view('PC/Suki/SukiEditThread')->with('data',$this->data);
    }
    //举报
    public function suki_report(Request $request)
    {
        $posts = ForumPostModel::where("pid",$request->input("pid"))->first();
        $this->data['origin'] = json_encode($posts);
        return view('PC/Suki/SukiReport')->with('data',$this->data);
    }
}
