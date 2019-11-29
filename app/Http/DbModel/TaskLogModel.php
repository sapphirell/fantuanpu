<?php

namespace App\Http\DbModel;

use Illuminate\Database\Eloquent\Model;

class TaskLogModel extends Model
{
    public $primaryKey = 'id';
    public $table = 'pre_task_log';
    public $timestamps = false;

    public static $takeTaskError = [
        - 1 => "任务不存在",
        - 2 => "任务不在截取时间范围内",
        - 3 => "已经领取过该任务",
        - 4 => "还有在进行中的任务",
        - 5 => "请等待下个周期截取",
    ];

    public static function take_task(int $task_id, int $uid)
    {
        //任务属性
        $task = TaskModel::find($task_id);
        if (empty($task))
        {
            return - 1; //任务不存在
        }
        if (time() > $task->task_end && time() < $task->task_start)
        {
            return - 2; //时间不在领取范围内
        }
        $userLog = self::select()->where("uid", $uid)->where("task_id", $task_id)->get();
        if ($task->task_take == 0)
        {
            if (!empty($userLog))
            {
                return - 3;//已经领取过该任务
            }
        }
        if ($task->task_take == 1)
        {
            $last_time = 0;//存储最后一个
            foreach ($userLog as $log)
            {
                if ($log->status == 1)
                {
                    return - 4; // 有还在进行中的同名任务
                }
                if ($log->finish_time > $last_time)
                {
                    $last_time = $log->finish_time;
                }
            }
            switch ($task->task_type)
            {
                case 2 :
                    if (date("Ymd", time()) == date("Ymd", $last_time))
                    {
                        return - 5;//必须下个周期才可以接取
                    }
                    break;
                case 3 :
                    if (date("Ymw", time()) == date("Ymw", $last_time))
                    {
                        return - 5;
                    }
                    break;
                case 4 :
                    if (date("Ymw", time()) == date("Ymw", $last_time))
                    {
                        return - 5;
                    }
                    break;
                default :
                    if (date("Ym", time()) == date("Ym", $last_time))
                    {
                        return - 5;
                    }
                    break;
            }

        }

        //开始为用户接任务
        $new_log                   = new self();
        $new_log->uid              = $uid;
        $new_log->task_id          = $task_id;
        $new_log->create_time      = time();
        $new_log->status           = 1;
        $new_log->active_action    = $task->task_action;
        $new_log->task_name        = $task->task_name;
        $new_log->task_gift        = $task->task_gift;
        $new_log->task_description = $task->task_description;
        $new_log->task_type        = $task->task_type;
        $new_log->save();

        return $new_log;
    }

    public static function getActiveTask($uid)
    {
        $data = self::select()
            ->where("uid", $uid)
            ->where("status", 1)
            ->get();
        foreach ($data as $key => & $value)
        {
            $value->task_gift = json_decode($value->task_gift, true);
        }

        return $data;
    }
}
