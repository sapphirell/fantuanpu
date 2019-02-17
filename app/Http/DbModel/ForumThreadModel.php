<?php

namespace App\Http\DbModel;

use App\Http\Controllers\System\CoreController;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class ForumThreadModel extends Model
{
    public $table='pre_forum_thread';
    public $timestamps = false;
    public $primaryKey = 'tid';
    /**
     * 软删除帖子
     * @param $tid
     */
    public static function delThread($tid,$todo)
    {
        $thread =  self::where(['tid' => $tid])->first();
        self::where(['tid' => $tid])->update(['isdel'=>$todo]);
        //并且清除对应板块的缓存,一般来说要删除的帖子都在前三页,那么只清除该板块前三页的缓存即可
        $cacheKey = CoreController::THREAD_LIST;
        Cache::forget($cacheKey['key'].json_encode([$thread->fid])."_page_1");
        Cache::forget($cacheKey['key'].json_encode([$thread->fid])."_page_2");
        Cache::forget($cacheKey['key'].json_encode([$thread->fid])."_page_3");
        //清除thread本身的缓存
        $thread_cache_key   = CoreController::THREAD_VIEW;

        $res['thread_subject']  =   Cache::forget($thread_cache_key['key'].$tid);
    }
    /**
     * 获取一部分板块内帖子,除了被删除和置顶的
     * @param array $fid_arr
     * @param int   $page
     * @返回 mixed
     */
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
//        $start = time() + microtime();

        $data = Cache::remember($cacheKey['key'].json_encode($fid_arr)."_page_".$page,
//                0,
                $cacheKey["time"],
                function () use ($fid_arr,$thread_mod ,$page) {
                        $normal_thread = ForumThreadModel::orderBy('lastpost','desc');
                        if (empty($fid_arr))
                            $normal_thread = $normal_thread->where('fid','!=','63')->where("isdel",1)->where("istop",1)->orderBy('lastpost','desc')->offset(15*($page-1))->limit(15)->get();
                        else
                            $normal_thread = $normal_thread->whereIn('fid',$fid_arr)->where("isdel",1)->where("istop",1)->orderBy('lastpost','desc')->offset(15*($page-1))->limit(15)->get();
                        $normal_thread = $normal_thread->isEmpty() ? [] : $normal_thread->toArray();
                        //如果获取的是第一页的帖子,应当再获取该板块的置顶帖,并合并在一起
                        if ($page == 1)
                            $top_thread = self::_get_top_of_forum($fid_arr);
                        else
                            $top_thread = [];


                        $data = array_merge($top_thread,$normal_thread);
                        foreach ($data as &$value)
                        {
                            $value['avatar'] = config(
                                    'app.online_url'
                                ) . \App\Http\Controllers\User\UserHelperController::GetAvatarUrl($value['authorid']);
                            $value['last_post_date'] = date("m-d H:i", $value['lastpost']);
                            $post_image = $thread_mod->getPostOfThread($value["tid"]);

                            $subject_images = [];
                            foreach ($post_image as $flor)
                            {
                                preg_match_all("/\[img\].*?\[\/img\]/", $flor->message, $tmp);// 取前几楼的图片
                                $subject_images = array_merge($subject_images, $tmp[0]);
                            }

                            //帖子预览(图文)
                            //                            $value['preview'] = preg_replace("/\[img\].*?\[\/img\]/",'[图片]',$post_image[0]->message);
                            $value['preview'] = preg_replace("/\[img\].*?\[\/img\]/", '', $post_image[0]->message);
                            $value['preview'] = preg_replace("/\n/", '', $value['preview']);
                            $value['preview'] = preg_replace("/\r/", '', $value['preview']);
                            //非置顶帖子要显示略缩图,取图片地址,并且去掉过小的图片
                            if ($value['istop'] == 1)
                            {
                                $cacheKey = CoreController::THREAD_PREVIEW_IMAGE;

                                $value['subject_images'] = Cache::remember($cacheKey['key'].$value["tid"], $cacheKey["time"],
                                    function () use ($value){
                                        $data = self::where("tid",$value["tid"])->first();
                                        return empty($data) ? [] : json_decode($data->previewimg,true);
                                });
                            }
                            //获取板块名称
                            $value["suki_fname"] = Forum_forum_model::$suki_forum[$value["fid"]];
                            //帖子人性化时间
                            $value["sim_time"] = format_time($value["lastpost"]);
                        }
                        return $data;
                });

        return $data;
    }

    /**
     * 传入一个url更新一个帖子的图片预览缓存,或者获取一个帖子的图片预览缓存
     * @param      $tid
     * @param bool $url
     * @返回 mixed
     */
    public static function remember_preview_image($tid,$url=false)
    {
        $cacheKey = CoreController::THREAD_PREVIEW_IMAGE;
        if ($url)
        {
            $data = self::where("tid",$tid)->first();
            if (empty($data))
                $previewimg = [$url];
            else
            {
                $previewimg = json_decode($data->previewimg,true);
                $previewimg[] = $url;

            }
            $data->previewimg = json_encode($previewimg);
            $data->save();
            Cache::forget($cacheKey['key'] .$tid);
        }
        return Cache::remember($cacheKey['key'].$tid, $cacheKey["time"],
            function () use ($tid){
                $data = self::where("tid",$tid)->first();
                return empty($data) ? [] : json_decode($data->previewimg,true);
            });

    }
    //更新帖子的图片预览缓存
    public static function flush_thread_preview_image($tid,$flag="flush",$content="")
    {
        $cacheKey = CoreController::THREAD_PREVIEW_IMAGE;
        $data = self::where("tid",$tid)->first();
        //编辑帖子的话要刷新,而回复(20楼层以内),则只需要插入
        if ($flag == "flush")
        {
            $thread_mod = new Thread_model();
            $post_image = $thread_mod->getPostOfThread($tid);
            $subject_images = [];
            foreach ($post_image as $flor)
            {
                preg_match_all("/\[img\].*?\[\/img\]/", $flor->message, $tmp);// 取前几楼的图片
                $subject_images = array_merge($subject_images, $tmp[0]);
            }

            foreach ($subject_images as $key => &$str)
            {
                $link = mb_substr($str, 5, mb_strlen($str) - 11, 'utf-8');
                $size = getimagesize($link); // 这一步骤如果是网络图片,则会很慢很慢,后期上线后应该考虑实现为生成本地略缩图的方式
                if ($size[0] > 120 && $size > 120)
                {
                    $str = $link;
                }
                else
                {
                    unset($subject_images[$key]);
                }
            }
        }
        else
        {
            //对传入的$content (回帖内容)进行筛选,得出尺寸符合的图片,插入previewimg字段
            preg_match_all("/\[img\].*?\[\/img\]/", $content, $subject_images);// 筛选出img标签
//            ddd($subject_images);
            $subject_images = $subject_images[0];
            foreach ($subject_images as $key => &$str)
            {
                $link = mb_substr($str, 5, mb_strlen($str) - 11, 'utf-8');
                $size = getimagesize($link);
                if ($size[0] > 120 && $size > 120)
                    $str = $link;
                else
                    unset($subject_images[$key]);
            }

        }
        //对数组数据进行最后一步整理
        $subject_images = array_values($subject_images);


        $data->previewimg = json_encode($subject_images);
        $data->save();
        Cache::forget($cacheKey['key'] .$tid);

    }

    /**
     * 获取一个板块的置顶帖子
     * @param $fid
     */
    public static function _get_top_of_forum(array $fid_arr)
    {
        $data = self::whereIn('fid',$fid_arr)->where("isdel",1)->where("istop",2)->orderBy('lastpost','desc')->get();
        return $data->isEmpty() ? [] : $data->toArray();
    }
    /**
     * 获取一个人发的帖子
     */
    public static function get_user_thread($uid,$page,$ascription =1,$fid=[])
    {
        return self::whereIn("fid",$fid)->where('authorid',$uid)->where('ascription',$ascription)->orderBy('tid','desc')->limit(15)->offset(($page-1)*15)->get();
    }
    /**
     * 根据名字模糊搜索帖子
     */
    public static function find_by_namelike($name)
    {
        
    }
    //1 == 正常 2= 置顶
    public static function set_top_thread($tid,$todo = "top")
    {
        $thread = self::find($tid);
        $thread->istop = $todo;
        $thread->save();
        //然后清除缓存
        $thread_cache_key   = CoreController::THREAD_VIEW;
        Cache::forget($thread_cache_key['key'].$tid);
        return true;
    }
}
