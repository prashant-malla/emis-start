<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NonTechnical
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::guard('staff')->check() && auth()->guard('staff')->user()->role->role == 'Non-Technical'){
            return $next($request);
        }else{
            auth()->guard('staff')->logout();
            return redirect()->route('nontechnical.login')->with('error', "You don't have access.");
        }
    }
}
