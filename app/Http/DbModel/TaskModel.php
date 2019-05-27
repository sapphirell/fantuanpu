<?php

namespace App\Http\DbModel;

use Illuminate\Database\Eloquent\Model;

class TaskModel extends Model
{
    public $primaryKey = 'id';
    public $table='pre_task';
    public $timestamps = false;
}
