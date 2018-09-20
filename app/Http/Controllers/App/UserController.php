<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\System\CoreController;
use App\Http\Controllers\User\UserBaseController;
use App\Http\DbModel\CommonMemberCount;
use App\Http\DbModel\ForumThreadModel;
use App\Http\DbModel\FriendModel;
use App\Http\DbModel\MyLikeModel;
use App\Http\DbModel\PmIndexesModel;
use App\Http\DbModel\PmListsModel;
use App\Http\DbModel\PmMessageModel;
use App\Http\DbModel\User_model;
use App\Http\DbModel\UserReportModel;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redis;

class UserController extends Controller
{
    //
    public function test()
    {
        //修改pm_lists lastmessage
        foreach (PmListsModel::all() as $value)
        {
            $lastmessage = json_encode(common_unserialize($value->lastmessage));
            $pl = PmListsModel::find($value->plid);
            $pl->lastmessage = $lastmessage;
            $pl->save();
        }
    }
    public function user_center(Request $request)
    {
        $cacheKey = CoreController::USER_TOKEN;
        $cacheKey = $cacheKey['key'] . $request->input('token');
        $this->data['uid'] = Redis::get($cacheKey);
        $this->data['user_info'] = User_model::find($this->data['uid']);
        $this->data['user_count'] = CommonMemberCount::GetUserCoin($this->data['uid']);
        $this->data['user_avatar'] = config('app.online_url').\App\Http\Controllers\User\UserHelperController::GetAvatarUrl($this->data['uid']);

        /**
         * 用户私信
         */
        $this->data['letter'] = PmListsModel::where('min_max','like',$this->data['uid']."\_%")->orwhere('min_max','like',"%\_".$this->data['uid'])
            ->orderBy('dateline','desc')
            ->get();

        foreach ($this->data['letter'] as $value)
        {
            //获取往来私信用户的uid
            $value->to_uid = preg_replace("/^{$this->data['uid']}\_/",'',$value->min_max);
            $value->to_uid = preg_replace("/\_{$this->data['uid']}$/",'',$value->to_uid);

            $value->avatar =  config('app.online_url').\App\Http\Controllers\User\UserHelperController::GetAvatarUrl($value->to_uid);

            $value->dateline = date("Y-m-d H:i:s",$value->dateline );
//            $pmMessage = new PmMessageModel();
//            $value->message = $pmMessage->find_message_by_plid($value->plid);
//            $value->lastmessage = common_unserialize($value->lastmessage);
            $value->lastmessage = json_decode($value->lastmessage);
        }
        return self::response($this->data);
    }

    //查看私信接口
    public function read_letter(Request $request)
    {
        if(!$request->input('plid') && !$request->input('to_uid'))
            return self::response([],40001,'缺少参数plid或to_uid');
        $uid = Redis::get(CoreController::USER_TOKEN['key'] . $request->input('token'));
        $plid = $request->input('plid');
        if ($request->input('to_uid'))
        {

            //拼接min_max uid组合 -_-discuz为毛要这样拼啊!!
            $min_max = $uid < $request->input('to_uid') ? $uid ."_". $request->input('to_uid') : $request->input('to_uid') ."_".$uid ;
            $letter = PmListsModel::where('min_max',$min_max)->first();

            if (!$letter->plid)
                return self::response();

            $plid = $letter->plid;
            $to_uid = $request->input('to_uid');
        }
        else
        {
            $letter = PmListsModel::find($plid);
            //提供聊天对方的信息
            $to_uid = preg_replace("/^{$uid}\_/",'',$letter->min_max);
            $to_uid = preg_replace("/\_{$uid}$/",'',$to_uid);
        }
        $this->data['to_uid'] = $to_uid;
        $data = $this->_read_letter($plid);


//

//        dd($data);
        return $data;
    }
    //查看私信
    public function _read_letter($plid)
    {
        if(!$plid)
            return self::response([],40001,'缺少参数plid');
        $pmMessage = new PmMessageModel();
        $this->data['message'] = $pmMessage->find_message_by_plid($plid);
        foreach ($this->data['message'] as &$value)
        {
            $value->avatar = config('app.online_url').\App\Http\Controllers\User\UserHelperController::GetAvatarUrl($value->authorid);
            $value->dateline = date("Y-m-d H:i:s",$value->dateline );
        }

        return self::response($this->data);
    }
    //发送私信
    public function send_letter(Request $request)
    {
        if (!$request->input('to_uid'))
            return self::response([],40001,'缺少参数to_uid');
        if (!$request->input('message'))
            return self::response([],40001,'缺少参数message');
        //检查以前是否有私信往来
        $uid        = Redis::get(CoreController::USER_TOKEN['key'] . $request->input('token'));
        $user       = User_model::find($uid);
//        $to_user    = User_model::find($request->input('to_uid'));
        //拼接min_max uid组合
        $min_max    = $uid < $request->input('to_uid') ? $uid ."_". $request->input('to_uid') : $request->input('to_uid') ."_".$uid ;
        $pmlist     = PmListsModel::where('min_max',$min_max)->first();
        if ($pmlist->plid)
        {
            //有的话更新lists
            $pmlist->dateline = time();
            $pmlist->lastmessage = json_encode([
                'lastauthorid'  => $uid,
                'lastauthor'    => $user->username,
                'lastsummary'   => $request->input('message'),
            ]);
            $pmlist->save();
        }
        else
        {
            //没有的话则新建一条私信lists
            $pmlist = new PmListsModel();
            $pmlist->authorid = $uid;
            $pmlist->pmtype = 1;
            $pmlist->subject = $request->input('message');
            $pmlist->members = 2;
            $pmlist->min_max = $min_max;
            $pmlist->dateline = time();
            $pmlist->lastmessage = json_encode([
                'lastauthorid'  => $uid,
                'lastauthor'    => $user->username,
                'lastsummary'   => $request->input('message'),
            ]);
            $pmlist->save();

        }
        //更新pm_indexs获取到分表的index主键 (-_-这表到底干嘛用的
        $index = new PmIndexesModel();
        $index->plid = $pmlist->plid;
        $index->save();
        //插入一个message
        $pmMessage = new PmMessageModel();
        $pmMessage->table = $pmMessage->get_table($pmlist->plid);
        $pmMessage->plid = $pmlist->plid;
        $pmMessage->pmid = $index->pmid;
        $pmMessage->authorid = $uid;
        $pmMessage->message = $request->input('message');
        $pmMessage->delstatus = 0;
        $pmMessage->dateline = time();
        $pmMessage->save();


        return self::response();
    }

    public function user_friends(Request $request)
    {
        $cacheKey   = CoreController::USER_TOKEN['key'] . $request->input('token');
        $uid        = Redis::get($cacheKey);
//        $data = FriendModel::where('uid',$uid)->get();
        $data       = FriendModel::where('uid',$uid);
        if($request->input('keywords'))
            $data   = $data->where('fusername','like',"%{$request->input('keywords')}%");

        $data       = $data->paginate(10)->toArray()['data'];
        foreach ($data as &$value)
        {
            $value['favatar'] =  config('app.online_url').\App\Http\Controllers\User\UserHelperController::GetAvatarUrl($value['fuid']);
        }
        return self::response($data);
    }
    public function user_report(Request $request)
    {
        $uid = Redis::get(CoreController::USER_TOKEN['key'] . $request->input('token'));
        $user = User_model::find($uid);
        $userReport = New UserReportModel();
        $userReport->title      = $request->input('title');
        $userReport->message    = $request->input('content');
        $userReport->type       = $request->input('type');
        $userReport->uid        = $user->uid;
        $userReport->user_name  = $user->username;

        $userReport->save();
        return self::response();
    }
    public function user_view(Request $request)
    {
        if (!$request->input('uid'))
            return self::response([],40001,'未传参数uid');

        $this->data['user']             = User_model::find($request->input('uid'));
        $this->data['user']->regdate    = date("Y-m-d H:i",$this->data['user']->regdate);

        if (!$this->data['user']->uid)
            return self::response([],40001,'用户不存在');

        $this->data['user']->avatar     = config('app.online_url').\App\Http\Controllers\User\UserHelperController::GetAvatarUrl($this->data['user']->uid);
        $this->data['user_count']       = CommonMemberCount::GetUserCoin($request->input('uid'));
        //查询用户最近发的帖子
        $this->data['thread']           = ForumThreadModel::where('authorid',$request->input('uid'))->orderBy('dateline','desc')->paginate(15)->toArray()['data'];
        foreach ($this->data['thread'] as &$value)
        {
            $value['dateline'] = date('Y-m-d H:i', $value['dateline']);
        }
        //如果登录用户,则需要获得用户关系
        if ($request->input('token'))
        {
            $mine_uid = Redis::get(CoreController::USER_TOKEN['key'] . $request->input('token'));
            $relation = FriendModel::where('uid',$mine_uid)->where('fuid',$request->input('uid'))->first();

        }
        $this->data['relation'] = $relation->uid ? true : false;
        return self::response($this->data);
    }
    //查询用户最近发的帖子
    public function get_user_thread(Request $request)
    {
        //查询用户最近发的帖子
        $this->data['thread'] = ForumThreadModel::where('authorid',$request->input('uid'))->orderBy('dateline','desc')->paginate(15)->toArray()['data'];
        foreach ($this->data['thread'] as &$value)
        {
            $value['dateline'] = date('Y-m-d H:i', $value['dateline']);

        }
        return self::response($this->data);
    }
    //我发的帖子
    public function get_my_thread(Request $request)
    {
        $uid    = Redis::get(CoreController::USER_TOKEN['key'] . $request->input('token'));
        $thread = ForumThreadModel::where('authorid',$uid)->orderBy('tid','desc')->paginate(15);
        foreach ($thread as $value)
        {
            $this->data['thread'][date("Y / m / d",$value->dateline)][] = $value;
        }
        return self::response($this->data);
    }

    /**
     * 添加我喜欢的帖子
     * @param Request $request
     */
    public function add_my_like(Request $request)
    {
        if (!$request->input('like_id'))
            return self::response([],40001,'缺少参数tid');
        $uid    = Redis::get(CoreController::USER_TOKEN['key'] . $request->input('token'));
        //是否已经有记录了
        $haslike = MyLikeModel::where('uid',$uid)->where('like_id',$request->input('like_id'))->where('like_type',1)->first();
        if($haslike->id)
            return self::response([],40002,'已经喜欢该帖子了!');

        $likeModel = new MyLikeModel();
        $likeModel->uid         = $uid;
        $likeModel->like_id     = $request->input('like_id');
        $likeModel->like_type   = 1;
        $likeModel->create_at   = time();
        $likeModel->save();

        return self::response();
    }

    /**
     * 显示我喜欢的帖子
     * @param Request $request
     * @返回 mixed
     */
    public function show_my_like(Request $request)
    {
        $uid    = Redis::get(CoreController::USER_TOKEN['key'] . $request->input('token'));
        $data   = MyLikeModel::leftJoin('pre_forum_thread','pre_my_like.like_id','=','pre_forum_thread.tid')
                    ->where('uid',$uid)
                    ->where('like_type',1)
                    ->get();
        foreach ($data as &$value)
        {
            $value->avatar  = config('app.online_url').\App\Http\Controllers\User\UserHelperController::GetAvatarUrl($value->authorid);
            $value->date    = date("Y-m-d",$value->create_at);
        }
        return self::response($data);
    }
}
