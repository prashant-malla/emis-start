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
    /*    public function handle(Request $request, Closure $next, ...$guards)
        {
            $guards = empty($guards) ? [null] : $guards;

            foreach ($guards as $guard) {
                if (Auth::guard($guard)->check()) {
                    return redirect(RouteServiceProvider::HOME);
                }
            }

            return $next($request);
        }*/
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;
        foreach ($guards as $guard) {
            if (auth()->guard($guard)->check()) {
                if($guard == 'student') {
                    return redirect(RouteServiceProvider::STUDENT_HOME);
                } elseif($guard == 'parent') {
                    return redirect(RouteServiceProvider::PARENT_HOME);
                } elseif ($guard == 'staff') {
                    if (auth()->guard('staff')->user()->role->role == 'Teacher') {
                        return redirect(RouteServiceProvider::TEACHER_HOME);
                    } elseif (auth()->guard('staff')->user()->role->role == 'Principle') {
                        return redirect(RouteServiceProvider::PRINCIPLE_HOME);
                    } elseif (auth()->guard('staff')->user()->role->role == 'Accountant') {
                        return redirect(RouteServiceProvider::ACCOUNTANT_HOME);
                    } elseif(auth()->guard('staff')->user()->role->role == 'Librarian') {
                        return redirect(RouteServiceProvider::LIBRARIAN_HOME);
                    } elseif (auth()->guard('staff')->user()->role->role == 'Receptionist') {
                        return redirect(RouteServiceProvider::RECEPTIONIST_HOME);
                    } elseif (auth()->guard('staff')->user()->role->role == 'Technical') {
                        return redirect(RouteServiceProvider::TECHNICAL_HOME);
                    } elseif (auth()->guard('staff')->user()->role->role == 'Non-Technical') {
                        return redirect(RouteServiceProvider::NONTECHNICAL_HOME);
                    } elseif (auth()->guard('staff')->user()->role->role == 'Administrative') {
                        return redirect(RouteServiceProvider::ADMINISTRATIVE_HOME);
                    }
                } elseif (Auth::user()->role == 'superadmin') {
                    return redirect(RouteServiceProvider::SUPER_ADMIN_HOME);
                } elseif (Auth::user()->role == 'admin') {
                    return redirect(RouteServiceProvider::ADMIN_HOME);
                }
                return view('auth.login');
            }
        }
        return $next($request);
    }
}
