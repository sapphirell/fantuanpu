<?php

namespace App\Http\DbModel;

use Illuminate\Database\Eloquent\Model;

class ForumPostTableidModel extends Model
{
    public $table='pre_forum_post_tableid';
    public $timestamps = false;
    public $primaryKey = 'pid';
}
