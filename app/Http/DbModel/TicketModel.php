<?php

namespace App\Http\DbModel;

use Illuminate\Database\Eloquent\Model;

class TicketModel extends Model
{
    public $primaryKey = 'id';
    public $table = 'pre_group_buying_ticket';
    public $timestamps = false;
}
