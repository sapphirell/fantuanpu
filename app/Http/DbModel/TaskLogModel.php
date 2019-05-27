<?php

namespace App\Http\DbModel;

use Illuminate\Database\Eloquent\Model;

class TaskLogModel extends Model
{
    public $primaryKey = 'id';
    public $table='pre_task_log';
    public $timestamps = false;
}
