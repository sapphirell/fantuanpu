<?php

namespace App\Http\DbModel;

use Illuminate\Database\Eloquent\Model;

class CreditLogModel extends Model
{
    public static $operation = [
        'RCT' => '回帖奖励',
        'PNT' => '回帖奖励',
        'BNM' => '购买勋章@新版',
        'SIG' => '签到',
        'RPR' => '后台积分奖惩',
        'TRC' => '任务奖励积分',
        'RTC' => '发表悬赏主题扣除积分',
        'RAC' => '最佳答案获取悬赏积分',
        'MRC' => '道具随即获取积分',
        'TFR' => '积分转账转出',
        'RCV' => '积分转账接收',
        'CEC' => '积分兑换',
        'ECU' => '通过 UCenter 兑换积分支出',
        'SAC' => '出售附件获得积分',
        'BAC' => '购买附件支出积分',
        'PRC' => '帖子被评分所得积分',
        'RSC' => '评分帖子扣除自己的积分',
        'STC' => '出售主题获得积分',
        'BTC' => '购买主题支出积分',
        'AFD' => '购买积分即积分充值',
        'UGP' => '购买扩展用户组',
        'RPC' => '举报功能中的奖惩',
        'ACC' => '参与活动扣除积分',
        'RCA' => '回帖中奖',
        'RCB' => '返还回帖奖励积分',
        'CDC' => '卡密充值',
        'BMC' => '购买道具',
        'AGC' => '获得红包',
        'BGC' => '埋下红包',
        'RGC' => '回收红包',
        'RKC' => '竞价排名',
        'BME' => '购买勋章@旧版',

        'RPZ' => '后台积分奖惩清零',

    ];
    public $table = 'pre_credit_log';
    public $primaryKey = 'logid';
    public $timestamps = false;
}
