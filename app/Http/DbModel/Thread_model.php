<?php

namespace App\Http\DbModel;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Thread_model extends Model
{
    public $table_thread = 'pre_forum_thread';
    public $table_post   = 'pre_forum_post';
    public $timestamps = false;

    public function getThread($tid)
    {
        //thread指帖子标题以及一楼的发帖
        $res = DB::table($this->table_thread . 'as t')
            ->leftJoin($this->table_post .' as p','t.tid','=','p.tid')
            ->where(['tid'=>$tid])->select()->get();

        return $res;
    }

    /**
    * @path
    **/
    public function getThreadList($fid)
    {
        return DB::table($this->table_thread)->where('fid',$fid)->orderBy('lastpost','desc')->select()->paginate(20) ;
    }
}

