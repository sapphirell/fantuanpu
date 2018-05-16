<?php

namespace App\Http\DbModel;

use Illuminate\Database\Eloquent\Model;

class CommonUsergroupModel extends Model
{
    //
    public $table = 'pre_common_usergroup';
    public $primaryKey = 'groupid';
    public $timestamps = false;
}
