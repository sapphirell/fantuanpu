<?php

namespace App\Http\Middleware;

use App\Http\Controllers\Controller;
use Closure;
use Illuminate\Support\Facades\Auth;

class DomainLolita
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (in_array($request->getHost(),array_merge(Controller::$lolita_domain,Controller::$local_domain)))
            return $next($request);
        else
            return Controller::response([],40000,'Suki不允许当前域名进行访问');
        return $next($request);
    }
}
