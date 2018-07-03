<?php

namespace App\Http\DbModel;

use App\Traits\HasCompositePrimaryKey;
use Illuminate\Database\Eloquent\Model;

class FriendModel extends Model
{
    use HasCompositePrimaryKey;
    public $table='pre_home_friend';
    public $timestamps = false;
    public $primaryKey = ['uid','fuid'];
}
