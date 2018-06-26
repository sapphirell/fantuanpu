<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\System\CoreController;
use App\Http\Controllers\User\UserBaseController;
use App\Http\DbModel\CommonMemberCount;
use App\Http\DbModel\User_model;
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
        return self::response($this->data);
    }
}
