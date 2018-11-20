<?php

namespace App\Http\DbModel;

use App\Http\Controllers\System\CoreController;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class Forum_forum_model extends Model
{
    public $primaryKey = 'fid';
    public $table='pre_forum_forum';
    public $timestamps = false;

    /**
     * 新版的获取板块,这将指定的获取一些板块,并且忽视上下级关系-_-(上下级并无卵用啊)
     */
    public function get_nodes_new()
    {}
    public function get_nodes()
    {
        //默认10条

        /*discuz 内板块主表是pre_forum_forum
        *   @ 一级板块分类的上级fid都是0，且类型是group
        *
        */
//        $topMod = $this->get_bottom_nodes(0,'group',1);
        $topMod = Forum_forum_model::whereIn('fid',[1,36,41,49,52,56,64])->orderBy('displayorder')->get()->toArray();
        foreach ($topMod as $key => &$value) {
            # 找出每一个归属上级版块的板块来
            $value['bottomforum'] = $this->get_bottom_nodes($value['fid'],'forum',1);
        }
        return $topMod;
    }

    /**
     * 获取156所有的下级板块
     */
    public function get_suki_nodes()
    {
        $data = $this->get_bottom_nodes(156,'forum',1);

        return $data;
    }
    public function get_bottom_nodes($fid,$type = 'forum')
    {
        //板块分区是group、板块是forum、小组是sub
        $f = Forum_forum_model::where([
            'type' => $type,
            'fup' => $fid
        ])->select()->orderBy('displayorder')->get()->toArray();

        return $f;

    }
    public static function get_nodes_by_fid($fid,$page=1)
    {

        $configCacheKey = CoreController::NODES_INFO;
        $cacheKey       = $configCacheKey['key'] . $fid;

        return Cache::remember($cacheKey,$configCacheKey['time'],function () use ($fid)
        {
            return self::where('fid',$fid)->select()->first();
        });
    }
}
