<?php

namespace App\Http\DbModel;

use App\Http\Controllers\System\CoreController;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class Forum_forum_model extends Model
{
    public $table='pre_forum_forum';
    public $timestamps = false;


    public function get_nodes()
    {
        //默认10条

        /*discuz 内板块主表是pre_forum_forum
        *   @ 一级板块分类的上级fid都是0，且类型是group
        *
        */
        $topMod = $this->get_bottom_nodes(0,'group',1);
        foreach ($topMod as $key => &$value) {
            # 找出每一个归属上级版块的板块来
            $value['bottomforum'] = $this->get_bottom_nodes($value['fid'],'forum',1);
        }
        return $topMod;
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
    public static function get_nodes_by_fid($fid)
    {
        $configCacheKey = CoreController::NODES_INFO;
        $cacheKey       = $configCacheKey['keys'] . $fid;
        return Cache::remember($cacheKey,$configCacheKey['time'],function () use ($fid)
        {
            return self::where('fid',$fid)->select()->first();
        });
    }
}
