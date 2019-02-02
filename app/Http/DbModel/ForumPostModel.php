<?php

namespace App\Http\DbModel;

use App\Http\Controllers\System\CoreController;
use App\Traits\HasCompositePrimaryKey;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class ForumPostModel extends Model
{
    use HasCompositePrimaryKey;
    public $table='pre_forum_post';
    public $timestamps = false;
    public $primaryKey = ['tid','position'];

    public static function delPosts($pid)
    {
        $posts = self::where('pid',$pid)->first();
        self::where('pid',$pid)->update(["isdel"=>2]);
        //先获取到所在page,再删除缓存
        $page = Thread_model::position2Page($posts->position);
        $posts_cache_key    = CoreController::POSTS_VIEW;
        Cache::forget($posts_cache_key['key']."{$posts->tid}_".$page);
    }

}
