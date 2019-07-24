<?php

namespace App\Http\DbModel;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class UserTicketModel extends Model
{
    public $primaryKey = 'id';
    public $table = 'pre_group_buying_user_ticket';
    public $timestamps = false;

    public static function getActiveTicket(int $uid)
    {
        $data = self::leftJoin(
            "pre_group_buying_ticket",
            function ($join)
            {
                $join->on("pre_group_buying_ticket.id", "=", "pre_group_buying_user_ticket.ticket_id");
            }
        )
            ->select(
                DB::raw(
                    "pre_group_buying_ticket.*,pre_group_buying_user_ticket.*,pre_group_buying_user_ticket.id as user_ticket_id"
                )
            )
            ->where("uid", $uid)->where("pre_group_buying_user_ticket.status", "!=", 3)
            ->get();

        return $data;
    }

    public static function getWantToUseTicket(int $uid)
    {
        $data = self::leftJoin(
            "pre_group_buying_ticket",
            function ($join)
            {
                $join->on("pre_group_buying_ticket.id", "=", "pre_group_buying_user_ticket.ticket_id");
            }
        )->select(
            DB::raw(
                "pre_group_buying_ticket.*,pre_group_buying_user_ticket.*,pre_group_buying_user_ticket.id as user_ticket_id"
            )
        )
            ->where("uid", $uid)->where("pre_group_buying_user_ticket.status", "=", 4)
            ->first();

        return $data;
    }
}
