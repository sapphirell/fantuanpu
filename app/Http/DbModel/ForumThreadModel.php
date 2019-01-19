<?php

namespace App\Http\DbModel;

use App\Http\Controllers\System\CoreController;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class ForumThreadModel extends Model
{
    public $table='pre_forum_thread';
    public $timestamps = false;
    public $primaryKey = 'tid';
    public static function get_new_thread($fid_arr = [],$page=1)
    {
        $cacheKey   = CoreController::THREAD_LIST;
        $thread_mod = new Thread_model() ; //$cacheKey["time"]
        //参数检查
        if (!is_array($fid_arr))
            $exception = true;
        foreach ($fid_arr as $value)
            if (!is_numeric($value))
                $exception = true;
        if ($exception)
            $fid_arr = [];


        $data = Cache::remember($cacheKey['key'].json_encode($fid_arr)."_page_".$page,$cacheKey["time"],
                function () use ($fid_arr,$thread_mod ,$page) {

                        $data = ForumThreadModel::orderBy('lastpost','desc');
                        if (empty($fid_arr))
                            $data = $data->where('fid','!=','63')->orderBy('lastpost','desc')->offset(15*($page-1))->limit(15)->get();
                        else
                            $data = $data->whereIn('fid',$fid_arr)->orderBy('lastpost','desc')->offset(15*($page-1))->limit(15)->get();
                        $data = $data->isEmpty() ? [] : $data->toArray();
                        foreach ($data as &$value)
                        {
                            $value['avatar'] = config('app.online_url') .\App\Http\Controllers\User\UserHelperController::GetAvatarUrl($value['authorid']);
                            $value['last_post_date'] = date("m-d H:i",$value['lastpost']);
                            $post_image = $thread_mod->getPostOfThread($value["tid"]);

                            $subject_images = [];
                            foreach ($post_image as $flor)
                            {
                                preg_match_all("/\[img\].*?\[\/img\]/",$flor->message,$tmp);// 取前几楼的图片
                                $subject_images = array_merge($subject_images,$tmp[0]);
                            }
                            //帖子预览
                            $value['preview'] = preg_replace("/\[img\].*?\[\/img\]/",'[图片]',$post_image[0]->message);
                            //取图片地址
                            foreach ($subject_images as &$str)
                                $str = mb_substr($str,5,mb_strlen($str)-11,'utf-8');
                            $value['subject_images'] = $subject_images;
                            //获取板块名称
                            $value["suki_fname"] = Forum_forum_model::$suki_forum[$value["fid"]];
                        }

                        return $data;
                });
        return $data;
    }

    /**
     * 获取一个人发的帖子
     */
    public static function get_user_thread($uid,$page)
    {
        return self::where('authorid',$uid)->orderBy('tid','desc')->limit(15)->offset($page*15)->get();
    }
    /**
     * 根据名字模糊搜索帖子
     */
    public static function find_by_namelike($name)
    {
        
    }
}
