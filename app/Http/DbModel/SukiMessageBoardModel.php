<?php

namespace App\Http\DbModel;

use App\Http\Requests\Request;
use Illuminate\Database\Eloquent\Model;

class SukiMessageBoardModel extends Model
{
    //suki用户中心留言板
    public $table = 'pre_suki_message_board';
    public $primaryKey = 'uid';
    public $timestamps = false;

    public static function get_user_message($uid,$page,$order="desc")
    {
        $data = self::where("uid",$uid)->limit(10)->offset(($page-1)*10)->orderBy("id",$order)->get();
        foreach ($data as &$value)
        {
            $value->user_info = User_model::find($value->authorid);
        }
        return $data;
    }
}
