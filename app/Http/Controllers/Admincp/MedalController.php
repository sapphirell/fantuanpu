<?php

namespace App\Http\Controllers\Admincp;

use App\Http\DbModel\ActionModel;
use App\Http\DbModel\CommonMemberCount;
use App\Http\DbModel\MedalModel;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class MedalController extends Controller
{
    public function add_medal(Request $request)
    {
        $this->data['action_list'] = ActionModel::all();
        //奖励列表
        $this->data['reward_list'] = CommonMemberCount::$extcredits;

        return view('PC/Admincp/AddMedal')->with('data',$this->data);
    }

    public function store_medal(Request $request)
    {
        $medal = new MedalModel();
        foreach (['medal_name','medal_action','medal_sell','is_online','medal_image'] as $value)
        {
            if ($request->input($value))
                $medal->{$value} = $request->input($value);
            else
                return self::response([],40001,'缺少参数'.$value);
        }
        $medal->save();
    }
}
