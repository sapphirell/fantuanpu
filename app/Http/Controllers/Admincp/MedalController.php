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
        foreach (['medal_name','action','price'] as $value)
        {
            if (!$request->input($value))
                return self::response([],40001,'缺少参数'.$value);
        }
        $medal->medal_name      = $request->input('medal_name');
        $medal->medal_action    = json_encode($request->input('action'));
        $medal->medal_sell = json_encode($request->input('price'));
        $medal->sell_start = $request->input('sell_start');
        $medal->sell_end = $request->input('sell_end');
        $medal->limit   =  $request->input('limit');

        $medal->save();
    }
}
