<?php

namespace App\Http\DbModel;

use Illuminate\Database\Eloquent\Model;

class ForumThreadModel extends Model
{
    public $table='pre_forum_thread';
    public $timestamps = false;
    public $primaryKey = 'tid';
    public static function get_new_thread()
    {
        $data =ForumThreadModel::orderBy('lastpost','desc')->where('fid','!=','63')->paginate(15)->toArray()['data'];
        foreach ($data as &$value)
        {
            $value['avatar'] = config('app.online_url')
                .\App\Http\Controllers\User\UserHelperController::GetAvatarUrl($value['authorid']);
            $value['last_post_date'] = date("m-d H:i",$value['lastpost']);
        }

        return $data;

    }
}
