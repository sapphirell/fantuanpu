<?php

namespace App\Http\Controllers\Forum;

use App\Http\DbModel\MedalModel;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class MedalController extends Controller
{
    public function medal_shop(Request $request)
    {
        //查询出所有在售的勋章
        $this->data['medal'] = MedalModel::query();

        $this->data['medal'] = $this->data['medal']->get();
//        dd($this->data);
        return view('PC/Forum/MedalShop')->with('data',$this->data);
    }
}
