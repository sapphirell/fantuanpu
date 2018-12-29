<?php
namespace App;
use Illuminate\Database\Eloquent\Model;

class ForumThread extends Model
{
    public $table = 'pre_forum_thread';
    public $timestamps = false;
    /**
     * @public int    $dateline 发帖时间
     * @public int    $lastpost 最后回复时间
     * @public string $author   发帖用户
     * @public string $subject  帖子标题
     * @public string $lastposter 最后回复者
     *
     * **/
    public function findForumThreadByTId($tid,$page)
    {
        return self::where('tid',$tid)->first();
    }
}