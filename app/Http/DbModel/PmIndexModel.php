<?php

namespace App\Http\DbModel;

use Illuminate\Database\Eloquent\Model;

class PmIndexModel extends Model
{
    public $table='pre_ucenter_pm_indexes';
    public $timestamps = false;
    public $primaryKey = 'pmid';
}
