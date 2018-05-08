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
        $res['thread_subject'] = DB::table($this->table_thread)->select()->where(['tid'=>$tid])->first();
        $res['thread_post'] =  DB::table($this->table_post)->select()->where(['tid'=>$tid])->orderBy('pid')->get();
        return $res;
    }

    /**
    * @path
    **/
    public function getThreadList($fid,$page)
    {
        return DB::table($this->table_thread)
            ->where('fid',$fid)
            ->orderBy('lastpost','desc')
            ->select()->offset($page-1)->limit(20)->get();
    }
}

