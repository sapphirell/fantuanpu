<?php

namespace App\Http\DbModel;

use Illuminate\Database\Eloquent\Model;

class PmMessageModel extends Model
{
    public $table='';
    public $timestamps = false;
    public $primaryKey = 'pmid';
    public function find_message_by_plid($lid)
    {
        $this->table = "pre_ucenter_".getposttablename($lid);
        return self::where('plid',$lid)->get();
    }
}
