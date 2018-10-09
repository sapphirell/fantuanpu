<?php

namespace App\Http\DbModel;

use Illuminate\Database\Eloquent\Model;

class ActionModel extends Model
{
    public $table = 'pre_action';
    public $primaryKey = 'id';
    public $timestamps = false;
}
