<?php

namespace App\Http\Middleware;

use Closure;

class Admin
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

        if (session('user_info')->uid && session('user_info')->gid >0 )
        {
            return $next($request);
        }
        if (!session('user_info')->uid )
        {
            return redirect()->route('login');
        }
        if (session('user_info')->groupid !== 1)
        {
            return redirect()->route('/');
        }
        return $next($request);
    }
}
