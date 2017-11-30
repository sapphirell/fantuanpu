<?php

namespace App\Http\DbModel;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Thread_model extends Model
{
    public $table_thread = 'forum_thread';
    public $table_post   = 'forum_post';
    public $timestamps = false;

    public function getThread($tid)
    {
        //thread指帖子标题以及一楼的发帖
        return DB::table($this->table_thread)->where(['tid'=>$tid])->select()->get();
    }
}

