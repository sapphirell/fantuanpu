<?php

namespace App\Http\DbModel;

use Illuminate\Database\Eloquent\Model;

class SukiFriendRequestModel extends Model
{
    public $table='pre_suki_friend_request';
    public $timestamps = false;
    public $primaryKey = 'id';
}
