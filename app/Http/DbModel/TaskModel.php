<?php

namespace App\Http\DbModel;

use Illuminate\Database\Eloquent\Model;

class TaskModel extends Model
{
    public $primaryKey = 'id';
    public $table = 'pre_task';
    public $timestamps = false;

    public static function getTaskList()
    {
        $list = TaskModel::select()->get();
        foreach ($list as $value)
        {
            $gifts            = json_decode($value->task_gift, true);
            $value->task_gift = [];
            $tmp_gift = [];
            foreach ($gifts as $key => $gift)
            {
                $tmp_gift[ CommonMemberCount::$extcredits[ $key ] ] = $gift;
            }
            $value->task_gift = $tmp_gift;
            $value->task_action = json_decode($value->task_action, true);
        }

        return $list;
    }
}
