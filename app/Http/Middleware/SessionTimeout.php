<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class SessionTimeout
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
        if (Auth::check()) {
            $lastActivity = Session::get('lastActivityTime');
            $timeout = 60 * 60; // 60 minutes in seconds

            if ($lastActivity && (time() - $lastActivity > $timeout)) {
                Auth::logout();
                Session::flush();
                return redirect()->route('login')->with('error', 'Session expired due to inactivity.');
            }

            Session::put('lastActivityTime', time());
        }

        return $next($request);
    }
}
