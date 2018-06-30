<?php

namespace App\Http\DbModel;

use App\Traits\HasCompositePrimaryKey;
use Illuminate\Database\Eloquent\Model;

class MemberLikeModel extends Model
{
//    use HasCompositePrimaryKey;
    public $table='pre_member_like';
    public $timestamps = false;
    public $primaryKey = 'id';
}
