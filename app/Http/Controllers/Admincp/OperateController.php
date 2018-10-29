<?php

namespace App\Http\Controllers\Admincp;

use App\Http\DbModel\ActionModel;
use App\Http\DbModel\CommonMemberCount;
use App\Http\DbModel\MedalModel;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class OperateController extends Controller
{
    public function __construct()
    {
        $this->data['left_nav'] = [
            'medal_list' => '勋章管理',
            'add_medal' => '勋章增加'
        ];

    }
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
        $medal->limit   =  $request->input('limit');

        $medal->save();
        return self::response();
    }
    public function medal_list(Request $request)
    {
        $this->data['medal_list'] = MedalModel::all();
        return view('PC/Admincp/MedalList')->with('data',$this->data);
    }
}
