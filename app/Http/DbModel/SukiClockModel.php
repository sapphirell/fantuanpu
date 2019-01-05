<?php

namespace App\Http\DbModel;

use Illuminate\Database\Eloquent\Model;

class SukiClockModel extends Model
{
    public $table = "pre_suki_clock";
    public $timestamps = false;
    public $primaryKey = 'cid';
}
