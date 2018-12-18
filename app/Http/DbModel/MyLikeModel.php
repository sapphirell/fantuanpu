<?php

namespace App\Http\DbModel;

use App\Http\Controllers\System\CoreController;
use Illuminate\Database\Eloquent\Model;

class MyLikeModel extends Model
{
    public $table='pre_my_like';
    public $timestamps = false;
    public static function has_follow($uid,$to_uid)
    {
        $like_all = MyLikeModel::get_user_like($uid,4);
        $uid_arr =[];
        foreach ($like_all as $value)
        {
            $uid_arr[] = $value->like_id;
        }
        return in_array($to_uid,$uid_arr) ? true : false;
    }
    //1=饭团扑帖子 2=饭团扑用户 3=suki帖子 4=suki用户
    public static function add_user_like($uid,$like_id,$like_type)
    {
        $my_like = new self();
        $my_like->like_id = $like_id;
        $my_like->like_type = $like_type;
        $my_like->uid = $uid;
        $my_like->create_at = time();
        $my_like->save();

    }
    public static function rm_user_like($uid,$like_id,$like_type)
    {
        $where = ['uid'=>$uid,'like_id'=>$like_id,'like_type'=>$like_type];
//        dd($where);
        self::where($where)->delete();

    }
    //1=饭团扑帖子 2=饭团扑用户 3=suki帖子 4=suki用户
    public static function get_user_like($uid,$type=1)
    {
//        $thread_cache_key   = CoreController::USER_INFO;

//        $res['thread_subject']  =   Cache::remember($thread_cache_key['key'].$uid."_type_",$thread_cache_key['time'],
//            function () use ($tid) {
//                return DB::table($this->table_thread)->select()->where(['tid'=>$tid])->first();
//            });

        $data = self::where(["uid"=>$uid,"like_type"=>$type])->get();

        return $data;
    }
}
