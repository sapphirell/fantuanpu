<?php

namespace App\Http\Controllers\SukiWeb;

use App\Http\Controllers\Forum\ThreadController;
use App\Http\DbModel\CommonMemberCount;
use App\Http\DbModel\Forum_forum_model;
use App\Http\DbModel\ForumPostModel;
use App\Http\DbModel\ForumThreadModel;
use App\Http\DbModel\GroupBuyingItemModel;
use App\Http\DbModel\GroupBuyingLogModel;
use App\Http\DbModel\GroupBuyingModel;
use App\Http\DbModel\GroupBuyingOrderModel;
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
use Illuminate\Support\Facades\DB;

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
            $request->input("page") ?: 1
        );

        return view('PC/Suki/News')->with('data', $this->data);
    }

    /**
     * 查看suki空间的follow
     *
     * @param Request $request
     * @返回 $this
     */
    public function suki_myfollow(Request $request)
    {
        if ($request->input("like_type") == 1) // 用户
        {

            $this->data["my_follow"] = MyLikeModel::get_user_like(
                $this->data['user_info']->uid,
                $request->input("like_type")
            );
            foreach ($this->data["my_follow"] as &$value)
            {
                $value->user = User_model::find($value->like_id, ["username", "uid"]);
            }
        }

        return view("PC/Suki/SukiMyFollow")->with("data", $this->data);
    }

    /**
     * @param $uid
     * @返回 $this
     */
    public function suki_userhome($uid)
    {
        $this->data['user'] = User_model::find($uid);
        $this->data['thread'] = ForumThreadModel::get_user_thread($uid, 1, 2, self::$suki_forum);
        $this->data['has_follow'] = MyLikeModel::has_like($this->data["user_info"]->uid, $uid, 4);
        $this->data['message_board'] = SukiMessageBoardModel::get_user_message($uid, 1);
        //查找该用户关注的和粉丝

        $this->data["user_relation"] = CommonMemberCount::find($uid);

        return view("PC/Suki/SukiUserHome")->with("data", $this->data);
    }

    /**
     * @param Request $request
     */
    public function suki_get_user_thread(Request $request)
    {
        $check = self::checkRequest($request, ["uid", "page", "need"]);
        if ($check !== true)
        {
            return self::response([], 40001, "缺少参数" . $check);
        }
        $this->data['thread'] = ForumThreadModel::get_user_thread(
            $request->input("uid"),
            $request->input("page"),
            2,
            self::$suki_forum
        );

        //        dd($this->data['thread']);
        return $request->input("need") == "html" ? view("PC/Suki/SukiUcThreadlist")->with(
            "data",
            $this->data
        ) : self::response($this->data['thread']);
    }


    /***
     * 查看suki的帖子
     *
     * @param Request $request
     */
    public function view_thread(Request $request, $tid, $page)
    {
        //        dd($this->data);
        $this->data = (new ThreadController(new Thread_model()))->_viewThread($tid, $page);
        $this->data["count"] = CommonMemberCount::find($this->data['user_info']->uid);
        $this->data['has_collection'] = MyLikeModel::has_like(
            $this->data['user_info']->uid ?: 0,
            $this->data['thread']['thread_subject']->tid,
            3
        );

        //        dd($this->data);
        return view('PC/Suki/SukiThread')->with('data', $this->data);
    }

    /**
     * 弹出的suki加好友申请的面板
     *
     * @param Request $request
     */
    public function add_suki_friend_view(Request $request)
    {
        return view('PC/Suki/SukiAddFriend')->with('data', $this->data);
    }

    /**
     * 用户提醒列表
     *
     * @param Request $request
     */
    public function suki_notice(Request $request)
    {
        switch ($request->input("type"))
        {
            case "reply_me" :
                $this->data["reply_me"] = SukiNoticeModel::find_user_notice($this->data['user_info']->uid, 1);
                //清理掉用户的小红点
                $user = User_model::find($this->data['user_info']->uid);
                $alert = json_decode($user->useralert, true);
                $alert["suki"]["reply"] = 0;
                $user->useralert = json_encode($alert, true);
                $user->save();
                User_model::flushUserCache($this->data['user_info']->uid);
                break;
            case "my_message": //我的私信
                break;
            case "call_me": //@

                break;
            case "friends_request":
                $this->data['friends_request'] = SukiFriendRequestModel::get_user_friend_request(
                    $this->data['user_info']->uid,
                    $request->input('page') ?: 1
                );
                break;
            default :
                $this->data["reply_me"] = SukiNoticeModel::find_user_notice($this->data['user_info']->uid, 1);
                break;
        }

        //        dd($this->data);
        return view('PC/Suki/SukiNoticeView')->with('data', $this->data);
    }

    //suki的 关注 粉丝 好友
    public function suki_relationship(Request $request)
    {

        switch ($request->input("type"))
        {
            case "my_follow" :
                $this->data['title'] = "我关注的";
                $this->data["my_follow"] = MyLikeModel::get_user_like($this->data['user_info']->uid, 4);
                foreach ($this->data["my_follow"] as &$value)
                {
                    $value->user = User_model::find($value->like_id, ["username", "uid"]);
                }

                break;
            case "follow_me":
                $this->data['title'] = "关注我的";
                $this->data["follow_me"] = MyLikeModel::get_follow_that($this->data['user_info']->uid, 4);
                foreach ($this->data["follow_me"] as &$value)
                {

                    $value->user = User_model::find($value->like_id, ["username", "uid"]);
                    $value->has_follow = MyLikeModel::has_like($this->data['user_info']->uid, $value->like_id, 4);
                }


                break;

            case "friends":
                $this->data['title'] = "我的好友";
                $this->data['my_friends'] = SukiFriendModel::get_my_friends(
                    $this->data['user_info']->uid,
                    $request->input("page")
                );
                break;
            default :

                break;
        }

        //        dd($this->data);
        return view('PC/Suki/SukiRelationship')->with('data', $this->data);
    }

    //suki补款闹钟
    public function suki_alarm_clock(Request $request)
    {
        $group = $request->input("group") ?: false;
        $this->data['title'] = "补款闹钟";
        $this->data["my_clock"] = SukiClockModel::get_user_clock($this->data['user_info']->uid, $group);

        //        dd($this->data["my_clock"]);
        return view('PC/Suki/SukiAlarmClock')->with('data', $this->data);
    }

    //新增闹钟
    public function suki_clock_setting(Request $request)
    {
        $this->data['title'] = "补款闹钟";

        return view('PC/Suki/SukiClockSetting')->with('data', $this->data);
    }

    //信誉墙
    public function suki_tribunal(Request $request)
    {
        $this->data['title'] = "lolita信誉墙";

        return view('PC/Suki/SukiTribunal')->with('data', $this->data);
    }

    //用户信息
    public function suki_user_info(Request $request)
    {
        return view('PC/Suki/SukiMyUserCenter')->with('data', $this->data);
    }

    public function about_suki()
    {
        return view('PC/Suki/SukiAbout')->with('data', $this->data);
    }

    //suki 搜索
    public function suki_search(Request $request)
    {
    }

    //编辑帖子
    public function suki_editor_post_view(Request $request)
    {
        $this->data['posts'] = ForumPostModel::where(
            [
                "tid" => $request->input("tid"),
                "position" => $request->input("position"),
            ]
        )->first();

        return view('PC/Suki/SukiEditThread')->with('data', $this->data);
    }

    //举报
    public function suki_report(Request $request)
    {
        $posts = ForumPostModel::where("pid", $request->input("pid"))->first();
        $this->data['origin'] = json_encode($posts);

        return view('PC/Suki/SukiReport')->with('data', $this->data);
    }

    //登录
    public function suki_login(Request $request)
    {
        $this->data['form'] = $request->input('form');

        return view('PC/Suki/SukiLogin')->with('data', $this->data);
    }

    //suki收藏
    public function suki_collection(Request $request)
    {
        $this->data["my_collection"] = MyLikeModel::get_user_like($this->data["user_info"]->uid, 3);

        //        dd($this->data["my_collection"]);
        return view('PC/Suki/SukiCollection')->with('data', $this->data);
    }

    //suki的团购
    public function suki_group_buying(Request $request)
    {
        $this->data['lastGroupingInfo'] = GroupBuyingModel::getLastGroup();
        if ($this->data['lastGroupingInfo'])
        {
            $this->data['items'] = GroupBuyingItemModel::getListInfo($this->data['lastGroupingInfo']->id,false);
            foreach ($this->data['items'] as & $value)
            {
                $value['item_image'] = explode("|", $value['item_image']);
                $value['item_color'] = explode("|", $value['item_color']);
                $value['item_size'] = explode("|", $value['item_size']);
            }
        }


        return view('PC/Suki/SukiGroupBuying')->with('data', $this->data);
    }

    public function suki_group_buying_item_info(Request $request)
    {
        //上一次购买记录
        $this->data["last"] = GroupBuyingLogModel::where(["uid" => $this->data["user_info"]->uid])->orderBy(
            "create_date",
            "desc"
        )->first();


        $this->data["item_info"] = GroupBuyingItemModel::find($request->input("item_id"));
        $this->data["group_info"] = GroupBuyingModel::find($this->data["item_info"]->group_id);

        $this->data["item_info"]->item_image = explode("|", $this->data["item_info"]->item_image);
        $this->data["item_info"]->item_color = explode("|", $this->data["item_info"]->item_color);
        $this->data["item_info"]->item_size = explode("|", $this->data["item_info"]->item_size);
        $item_follow = GroupBuyingLogModel::getNotCancelItemsLog( $request->input("item_id"));
        $this->data["item_follow"] = $item_follow["item_count"];
        $this->data["item_member"] = $item_follow["member_count"];


        return view('PC/Suki/SukiGroupBuyingItemInfo')->with('data', $this->data);;
    }

    public function suki_group_buying_item(Request $request)
    {
        $this->data['lastGroupingInfo'] = GroupBuyingModel::getLastGroup();
        $chk = $this->checkRequest($request, ["order_info", "item_id", "qq"]);
        if ($chk !== true)
        {
            return self::response([], 40001, "缺少参数" . $chk);
        }

        $item = GroupBuyingItemModel::find($request->input("item_id"));
        $item->item_color = explode("|", $item->item_color);
        $item->item_size = explode("|", $item->item_size);

        if (empty($item))
        {
            return self::response([], 40002, "不存在该团购商品");
        }

        $order_info = json_decode($request->input("order_info"), true);
        if (empty($order_info))
        {
            return self::response([], 40002, "订单详情为空");
        }

        $order_price = 0;
        $premium = 0;
        foreach ($order_info as $key => $value)
        {
            if ($value <= 0)
            {
                return self::response([], 40003, "欲购商品数量必须大于0");
            }
            $info = explode("_", $key);
            if (!in_array($info[0], $item->item_size))
            {
                return self::response([], 40003, "商品不存在该尺寸");
            }
            if (!in_array($info[1], $item->item_color))
            {
                return self::response([], 40003, "商品不存在该颜色" . var_export($item->item_color, true));
            }
            $premium += $value * $item->premium;
            $order_price += $value * $item->premium + $value * $item->item_price; // 辛苦费+商品原价
        }

        //        $order_price += $item->item_freight / $item->min_members  + 15; //公摊运费+私人运费

        $orderLog = new GroupBuyingLogModel();
        $orderLog->uid = $this->data['user_info']->uid;
        $orderLog->item_id = $item->id;
        $orderLog->status = 1;
        $orderLog->group_id = $item->group_id;
//        $orderLog->address = $request->input("address");
        $orderLog->private_freight = 0;
//        $orderLog->name = $request->input("name");
//        $orderLog->telphone = $request->input("telphone");
        $orderLog->premium = $premium;
        $orderLog->create_date = date("Y-m-d H:i:s");
        $orderLog->end_date = $this->data['lastGroupingInfo']->enddate;
        $orderLog->order_info = $request->input("order_info");
        $orderLog->order_price = $order_price;
//        $orderLog->qq = $request->input("qq");
        $orderLog->save();

        if (!$this->data['user_info']->qq)
        {

            $user = User_model::find($this->data['user_info']->uid);
            $user->qq = $request->input("qq");
            $user->save();
            User_model::flushUserCache($this->data['user_info']->uid);
        }
        return self::response();

    }

    public function suki_group_buying_myorders(Request $request)
    {
        $type = $request->input("type") ?: "all";
        $my_orders = GroupBuyingLogModel::leftJoin("pre_group_buying_item","pre_group_buying_item.id","=","pre_group_buying_log.item_id")
            ->select(DB::raw("pre_group_buying_log.* ,pre_group_buying_item.*,pre_group_buying_log.id as log_id"))
            ->where(["pre_group_buying_log.uid" => $this->data['user_info']->uid]);
        $last_group = GroupBuyingModel::getLastGroup(false);
        $orderInfo = GroupBuyingOrderModel::where("uid",$this->data["user_info"]->uid)->where("group_id",$last_group->id)->orderBy("id","desc")->first();
        if ($type == "all")
        {
            $my_orders = $my_orders->orderBy("pre_group_buying_log.id", "desc")->get();
        }
        else
        {

            $gid        = empty($last_group) ? 0 : $last_group->id;
            $my_orders  = $my_orders->where("pre_group_buying_log.group_id" ,$gid)->where("pre_group_buying_log.status","!=", "4")->get();
            //当前是否可以提交付款证明

            $this->data["order_commit_status"] = empty($orderInfo->status) ? -1 : $orderInfo->status;

        }

        $this->data["orders"] = $my_orders;

        $this->data["order_info"]["status"] = 0;

        $this->data["order_info"]["private_freight"] = $orderInfo->private_freight;
        $this->data["order_info"]["all_price"] = $orderInfo->order_price;
        $this->data["order_info"]["id"] = $orderInfo->id;




        foreach ($this->data["orders"] as & $value)
        {
            $value->order_info = json_decode($value->order_info, true);
            //订单的集合状态
            if (!$this->data["order_info"]["status"] || $this->data["order_info"]["status"] == $value->status)
                $this->data["order_info"]["status"] = $value->status ;
        }

        //        dd($this->data["orders"] );

        return view('PC/Suki/SukiGroupBuyingMyOrders')->with('data', $this->data);
    }

    public function suki_group_buying_cancel_orders(Request $request)
    {
        if (!$request->input("orderId"))
        {
            return self::response([], 40001, "缺少参数orderId");
        }
        $this->data["orders"] = GroupBuyingLogModel::where(["id" => $request->input("orderId")])->first();
        if (empty($this->data["orders"]))
        {
            return self::response([], 40002, "缺少orders");
        }

        if ($this->data["orders"]->status != 1 && $this->data["orders"]->status != 2)
        {
            return self::response([], 40003, "订单状态不对");
        }
        $this->data["orders"]->status = 4;
        $this->data["orders"]->save();

        return self::response();
    }

    public function suki_group_buying_paying(Request $request)
    {

        return view('PC/Suki/SukiGroupBuyingPaying')->with('data', $this->data);
    }

    public function suki_group_buying_confirm_orders(Request $request)
    {
        $chk = $this->checkRequest($request,[ "qq","name", "address", "telphone","orderId"]);
        if ($chk !== true)
        {
            return self::response([], 40001, "缺少参数" . $chk);
        }

        $this->data["orders"] = GroupBuyingOrderModel::where(["id" => $request->input("orderId")])->first();
        if (empty($this->data["orders"]))
        {
            return self::response([], 40002, "缺少orders");
        }
        if ($this->data["orders"]->status != 1)
        {
            return self::response([], 40003, "订单状态不对");
        }
        $this->data["orders"]->status = 2;
        $this->data["orders"]->name = $request->input("name");
        $this->data["orders"]->telphone = $request->input("telphone");
        $this->data["orders"]->qq = $request->input("qq");
        $this->data["orders"]->address = $request->input("address");
        $this->data["orders"]->save();
        foreach (json_decode($this->data["orders"]->log_id,true) as $lid)
        {
            $log = GroupBuyingLogModel::find($lid);
            $log->status = 8;
            $log->save();
        }
        return self::response();
    }
}
