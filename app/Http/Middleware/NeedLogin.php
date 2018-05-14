<?php

namespace App\Http\Middleware;

use App\Http\Controllers\Controller;
use Closure;

class NeedLogin
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
        $user_info = session('user_info');
        if (empty($user_info))
        {
            if ($request->input('source') == 'web')
            {
                return redirect()->route('login');
            }
            else
            {
                return Controller::response([],39999,'需要登录');
            }

        }
//        if (!session('user_info')->uid )
//        {
//            return redirect()->route('login');
//        }

        return $next($request);
    }
}
