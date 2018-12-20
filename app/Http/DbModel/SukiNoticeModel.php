<?php

namespace App\Http\DbModel;

use Illuminate\Database\Eloquent\Model;

class SukiNoticeModel extends Model
{
    public $table = 'pre_suki_notice';
    public $primaryKey = 'uid';
    public $timestamps = false;
}
