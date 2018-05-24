<?php

namespace App\Http\DbModel;

use Illuminate\Database\Eloquent\Model;

class CommonMemberCount extends Model
{
    //
    public $table = 'pre_common_member';
    public $primaryKey = 'uid';
    public $timestamps = false;
    public $extcredits = [
        'extcredits1' => '酸奶',
        'extcredits2' => '扑币',
        'extcredits3' => '项链',
        'extcredits4' => '草莓棉花糖',
        'extcredits5' => '灵魂宝石',
        'extcredits6' => '文点',
        'extcredits7' => '分享积分',
        'extcredits8' => '图点',
    ];
}
