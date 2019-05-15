<?php

namespace App\Http\DbModel;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class GroupBuyingExpressModel extends Model
{
    public $table = "pre_group_buying_express";
    public $timestamps = false;
    public $primaryKey = 'id';


}
