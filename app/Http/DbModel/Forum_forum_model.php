<?php

namespace App\Http\DbModel;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Forum_forum_model extends Model
{
    public $table='pre_forum';
    public $timestamps = false;


    public function GetForumGroup(){
//        return DB::table($this->table.'_group')->select()->get();
    }


}
