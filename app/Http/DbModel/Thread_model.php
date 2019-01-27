<?php

namespace App\Http\DbModel;

use App\Http\Controllers\System\CoreController;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class Thread_model extends Model
{
    public $table_thread = 'pre_forum_thread';
    public $table_post   = 'pre_forum_post';
    public $timestamps = false;

    public function getThread($tid,$page=1)
    {
        $thread_cache_key   = CoreController::THREAD_VIEW;

        $res['thread_subject']  =   Cache::remember($thread_cache_key['key'].$tid,$thread_cache_key['time'],
                                    function () use ($tid) {
                                        $data = DB::table($this->table_thread)->select()->where(['tid'=>$tid])->first();
                                        $data->sightml = MemberFieldForumModel::find($data->authorid)->sightml;
                                        return $data;
                                    });

        $res['thread_post']     =   $this->getPostOfThread($tid,$page);
//        dd($res['thread_post']);
        return $res;
    }
    public function getPostOfThread($tid,$page=1)
    {
        $posts_cache_key    = CoreController::POSTS_VIEW;
        $cache =  Cache::remember(
            $posts_cache_key['key']."{$tid}_{$page}",
            $posts_cache_key['time'],
            function () use ($tid,$page) {
                return DB::table($this->table_post)
                    ->select()
                    ->where(['tid'=>$tid])
                    ->orderBy('pid')
                    ->offset(CoreController::THREAD_REPLY_PAGE *  ($page-1))
                    ->limit(CoreController::THREAD_REPLY_PAGE)
                    ->get();
            }
        );
        //寻获当前用户佩戴的勋章
        foreach ($cache as &$value)
            $value->medal = UserMedalModel::get_user_medal($value->authorid);

//        dd($value);
        return $cache;
    }
    public static function position2Page(int $position)
    {
        return ceil($position/CoreController::THREAD_REPLY_PAGE);
    }
    /**
    * @path
    **/
    public function getThreadList($fid,$page,$remove_tid=[])
    {
        return DB::table($this->table_thread)
            ->where('fid',$fid)
            ->orderBy('lastpost','desc')
            ->select()->offset(($page-1)*20)->limit(20)->get();
    }
    //修改post的信息
    public static function updatePost(int $tid,int $position,$data)
    {
        $post = DB::table(self::$table_post)
            ->select()
            ->where(['tid' => $tid, "position" => $position])->first();
        $post->message = $data;
        $position->save();
        //清除缓存
        $posts_cache_key    = CoreController::POSTS_VIEW;
        Cache::forget($posts_cache_key['key']."{$tid}_".self::position2Page($position));
    }
}

