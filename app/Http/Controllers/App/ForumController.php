<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\System\CoreController;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redis;

class ForumController extends Controller
{
    //
    public function forum_list(Request $request)
    {
        $cacheKey = CoreController::NODES;
        $data = Redis::remember($cacheKey['key'],$cacheKey['time'],function ()
        {
            return $this->forumModel->get_nodes();
        });
        return self::response($data);
    }
}
