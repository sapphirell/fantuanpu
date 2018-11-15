<?php

namespace App\Http\Middleware;

use App\Http\Controllers\Controller;
use Closure;

class DomainFantuanpu
{
    public function __construct()
    {
        error_reporting(E_ERROR);
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (in_array($request->getHost(),["localhost","fantuanpu.com","www.fantuanpu.com"]))
            return $next($request);
        else
            return Controller::response([],40000,'不允许当前域名进行访问');
    }
}
