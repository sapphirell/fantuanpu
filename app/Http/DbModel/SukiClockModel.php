<?php

namespace App\Http\DbModel;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class SukiClockModel extends Model
{
    public $table = "pre_suki_clock";
    public $timestamps = false;
    public $primaryKey = 'cid';

    public static function get_user_clock($uid,$group=false)
    {
        $data = self::select(DB::raw("cid,sum(clock_money) as sum,count(cid) as count,alert_type,clock_name,clock_date,clock_end,date_format(clock_date,'%Y·%m') as ym"))->where(['uid'=>$uid]);
        switch ($group)
        {
            case false :
                $data = $data->groupBy("cid")->orderBy("clock_date","asc")->get();
                break;
            case "day" :
                $data = $data->groupBy("clock_date")->orderBy("clock_date","asc")->get();
                break;
            case "ym" :
                $data = $data->groupBy("ym")->orderBy("clock_date","asc")->get();
                break;
            default:
                $data = $data->get();
                break;
        }
        return $data;
    }
}
