<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @param  string|null  ...$guards
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        //店舗ユーザーと一般ユーザーで同時ログイン不可
        foreach ($guards as $guard) {
            if ($guard == "store_user" && Auth::guard($guard)->check()) {
                //return redirect(route('store-home'));
                return redirect()->route('store.home');
            }
            if (Auth::guard($guard)->check()) {
                return redirect('/home');
            }
        }

        return $next($request);
    }
}
