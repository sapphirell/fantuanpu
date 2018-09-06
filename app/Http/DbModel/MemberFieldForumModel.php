<?php

namespace App\Http\DbModel;

use Illuminate\Database\Eloquent\Model;

class MemberFieldForumModel extends Model
{
    public $table = 'pre_common_member_field_forum';
    public $primaryKey = 'uid';
    public $timestamps = false;
}
