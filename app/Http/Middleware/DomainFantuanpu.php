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
        if (in_array($request->getHost(),array_merge(Controller::$fantuanpu_domain,Controller::$local_domain)))
            return $next($request);
        else
            return Controller::response([],40000,'fantuanpu不允许当前域名进行访问');
    }
}
