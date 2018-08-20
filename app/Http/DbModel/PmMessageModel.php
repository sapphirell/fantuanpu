<?php

namespace App\Http\DbModel;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PmMessageModel extends Model
{
    public $table='';
    public $timestamps = false;
    public $primaryKey = 'pmid';
    public function find_message_by_plid($lid)
    {
        $this->table = "pre_ucenter_".getposttablename($lid);

        return self::leftJoin('pre_common_member','pre_common_member.uid','=',$this->table . ".authorid")
            ->select(DB::raw($this->table.'.*,pre_common_member.username'))
            ->where('plid',$lid)->get();
    }
    public function get_table($lid)
    {
        return "pre_ucenter_".getposttablename($lid);
    }
}
