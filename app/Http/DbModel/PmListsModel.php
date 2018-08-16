<?php

namespace App\Http\DbModel;

use Illuminate\Database\Eloquent\Model;

class PmListsModel extends Model
{
    public $table='pre_ucenter_pm_lists';
    public $timestamps = false;
    public $primaryKey = 'plid';
}
