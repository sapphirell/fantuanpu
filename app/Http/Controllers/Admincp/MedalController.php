<?php

namespace App\Http\Controllers\Admincp;

use App\Http\DbModel\ActionModel;
use App\Http\DbModel\CommonMemberCount;
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
}
