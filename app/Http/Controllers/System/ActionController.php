<?php

namespace App\Http\Controllers\System;

use App\Http\DbModel\CommonMemberCount;
use App\Http\DbModel\MedalModel;
use App\Http\DbModel\User_model;
use App\Http\DbModel\UserMedalModel;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class ActionController extends Controller
{
    public static function complete_action(string $action_name,int $uid)
    {
        $to_do = [];
        //触发勋章
        {
            //检测用户佩戴了什么勋章
            $user_medal = UserMedalModel::get_user_medal($uid)['in_adorn'];
            //查用户勋章可能的触发条件
            foreach ($user_medal as $value)
            {
                $medal_info = MedalModel::find($value->mid);
                foreach ($medal_action = json_decode($medal_info->medal_action,false) as $value)
                {
                    if ($value->action_name == $action_name)
                    {
                        //被触发
                        if ( rand(1,10000) < $value->rate * 10000) // 中奖,给用户加币
                        {
                            $to_do[$value->score_type] += $value->score_value;
                        }
                    }
                }

            }

        }
        //TODO:触发任务

        //把todo里的积分加给用户
        CommonMemberCount::BatchAddUserCount($uid,$to_do);
    }
}
