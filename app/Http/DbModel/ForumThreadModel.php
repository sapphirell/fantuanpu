<?php

namespace App\Http\DbModel;

use Illuminate\Database\Eloquent\Model;

class ForumThreadModel extends Model
{
    public $table='pre_forum_thread';
    public $timestamps = false;
    public $primaryKey = 'tid';
}
