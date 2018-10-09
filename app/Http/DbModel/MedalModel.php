<?php

namespace App\Http\DbModel;

use Illuminate\Database\Eloquent\Model;

class MedalModel extends Model
{
    public $table = 'pre_medal';
    public $primaryKey = 'id';
    public $timestamps = false;

    public static function addMedal()
    {

    }
}
