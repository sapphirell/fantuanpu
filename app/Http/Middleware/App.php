<?php

namespace App\Http\Middleware;

use App\Http\Controllers\Controller;
use App\Http\Controllers\System\CoreController;
use Closure;
use Illuminate\Support\Facades\Redis;

class App extends Controller
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!$request->input('token'))
            return Controller::response([],39999,'未传入token');

        $cacheKey = CoreController::USER_TOKEN;
        $cacheKey = $cacheKey['key'] . $request->input('token');

        $this->data['uid'] = Redis::get($cacheKey);
        if (!$this->data['uid'])
            return  Controller::response([],39998,'登录状态过期,请重新登录~ ❤');

        return $next($request);
    }
}
