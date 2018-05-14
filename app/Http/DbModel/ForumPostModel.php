<?php

namespace App\Http\DbModel;

use App\Traits\HasCompositePrimaryKey;
use Illuminate\Database\Eloquent\Model;

class ForumPostModel extends Model
{
    use HasCompositePrimaryKey;
    public $table='pre_forum_post';
    public $timestamps = false;
    public $primaryKey = ['tid','position'];
}
