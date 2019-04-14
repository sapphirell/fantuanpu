<?php

namespace App\Http\Controllers\Admincp;

use App\Http\DbModel\GroupBuyingItemModel;
use App\Http\DbModel\GroupBuyingModel;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class GroupBuyingController extends Controller
{
    public function __construct()
    {
        $this->data['left_nav'] = [
            'add_group_buying_item' => '添加商品',
            'show_group_buying_list' => '团购管理'
        ];
    }

    public function add_group_buying_item()
    {

        return view('PC/Admincp/AddGroupBuyingItem')->with('data',$this->data);
    }
    public function show_group_buying_list()
    {
        $this->data["list"] = GroupBuyingModel::get();
//        dd( $this->data["list"]);
        return view('PC/Admincp/ShowGroupBuyingList')->with('data',$this->data);
    }
    public function review_orders(Request $request)
    {
        $this->data["group_buying"] = GroupBuyingModel::find($request->input("id"));

//        $this->data["items"] =
        return view('PC/Admincp/ReviewOrders')->with('data',$this->data);
    }
    public function add_action(Request $request)
    {
        $chk = $this->checkRequest($request,["item_name","item_image","item_size","item_color","item_price","premium","min_members","item_freight"]);
        if ($chk !== true)
            return self::response([],40001,"缺少参数");

        $groupInfo = GroupBuyingModel::getLastGroup();


        $item = new GroupBuyingItemModel();
        $item->item_name = $request->input("item_name");
        $item->item_image = $request->input("item_image");
        $item->item_price = $request->input("item_price");
        $item->item_freight = $request->input("item_freight");
        $item->group_id = $groupInfo->id;
        $item->premium = $request->input("premium");
        $item->item_color = $request->input("item_color");
        $item->item_size = $request->input("item_size");
        $item->min_members = $request->input("min_members");
        $item->save();
        return self::response();
    }
}
