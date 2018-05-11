<?php

namespace App\Http\DbModel;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class UCenter_member_model extends Model
{
    public $primaryKey = 'uid';
    public $table='pre_ucenter_members';
    public $timestamps = false;

    public static function GetUserInfoByEmail($email){

        return UCenter_member_model::where('email',$email)->select()->first();
    }
}
