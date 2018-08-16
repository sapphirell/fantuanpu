<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\System\CoreController;
use App\Http\Controllers\User\UserBaseController;
use App\Http\DbModel\CommonMemberCount;
use App\Http\DbModel\FriendModel;
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
        for($i=0;$i<10;$i++){
            $this->data[] = ['name'=>aa123a.rand(10000000,99999999),'time'=>123];
        }


        return json_encode($this->data);
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
        $this->data['letter'] = PmListsModel::where('min_max','like',$this->data['uid']."_%")->where('min_max','like',"%_".$this->data['uid'])->get();
        foreach ($this->data['letter'] as &$value)
        {
            $value->avatar =  config('app.online_url').\App\Http\Controllers\User\UserHelperController::GetAvatarUrl($value->authorid);
//            $value->lastmessage= preg_replace('!s:(\d+):"(.*?)";!se', "'s:'.strlen('$2').':\"$2\";'", $value->lastmessage );
//            $value->lastmessage= str_replace("\r", "", $value->lastmessage);
            $value->lastmessage = common_unserialize($value->lastmessage);
        }
        return self::response($this->data);
    }

    //查看私信
    public function read_letter(Request $request)
    {
        if(!$request->input('plid'))
            return self::response([],40001,'缺少参数plid');
        $pmMessage = new PmMessageModel();
        $this->data['message'] = $pmMessage->find_message_by_plid($request->input('plid'));
        return self::response($this->data);
    }
    public function user_friends(Request $request)
    {
        $cacheKey = CoreController::USER_TOKEN;
        $cacheKey = $cacheKey['key'] . $request->input('token');
        $uid = Redis::get($cacheKey);
//        $data = FriendModel::where('uid',$uid)->get();
        $data = FriendModel::where('uid',$uid)->paginate(10)->toArray()['data'];
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
}
