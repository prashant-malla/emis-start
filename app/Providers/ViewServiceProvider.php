<?php

namespace App\Providers;

use App\Models\Event;
use App\Models\SchoolSetting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('*', function ($view) {
            $isAdmin = Auth::check();
            $isStaff = !$isAdmin && Auth::guard('staff')->check();
            $isStudent = !$isAdmin && !$isStaff && Auth::guard('student')->check();
            $isTeacher = $isStaff && Auth::guard('staff')->user()->role->role == 'Teacher';
            $authProfile = null;
            $routenamePrefix = '';

            if ($isAdmin) {
                $authProfile = Auth::user();
            } else if ($isStaff) {
                $authProfile = Auth::guard('staff')->user();

                $authRole = $authProfile->role->role;
                $validRouteRoles = ['Teacher', 'Librarian', 'Accountant', 'Technical', 'Non-Technical', 'Administrative'];
                if(in_array($authRole, $validRouteRoles)){
                    $routenamePrefix = strtolower($authRole).'_';
                }
            } else {
                $authProfile = Auth::guard('student')->user();
                $routenamePrefix = 'student_';
            }

            $view->with('authProfile', $authProfile);
            $view->with('isSuperAdmin', $isAdmin);
            $view->with('isAdmin', $isAdmin);
            $view->with('isStaff', $isStaff);
            $view->with('isStudent', $isStudent);
            $view->with('isTeacher', $isTeacher);
            $view->with('routename_prefix', $isTeacher ? 'teacher_' : '');
            $view->with('routenamePrefix', $routenamePrefix);

            if (Auth::guard('staff')->check()) {
                $loggedInStaff = Auth::guard('staff')->user()->role->role;
                if ($loggedInStaff == 'Teacher') {
                    $events = Event::whereHas('roles', function ($query) {
                        $query->where('role_id', '=', Auth::guard('staff')->user()->role_id);
                    })->orWhere('participants', '=', 'All')->latest()->take(5)->get();
                    $view->with('events', $events);
                } elseif ($loggedInStaff == 'Librarian') {
                    $events = Event::whereHas('roles', function ($query) {
                        $query->where('role_id', '=', Auth::guard('staff')->user()->role_id);
                    })->orWhere('participants', '=', 'All')->latest()->take(5)->get();
                    $view->with('events', $events);
                } elseif ($loggedInStaff == 'Accountant') {
                    $events = Event::whereHas('roles', function ($query) {
                        $query->where('role_id', '=', Auth::guard('staff')->user()->role_id);
                    })->orWhere('participants', '=', 'All')->latest()->take(5)->get();
                    $view->with('events', $events);
                } elseif ($loggedInStaff == 'Technical') {
                    $events = Event::whereHas('roles', function ($query) {
                        $query->where('role_id', '=', Auth::guard('staff')->user()->role_id);
                    })->orWhere('participants', '=', 'All')->latest()->take(5)->get();
                    $view->with('events', $events);
                } elseif ($loggedInStaff == 'Non-Technical') {
                    $events = Event::whereHas('roles', function ($query) {
                        $query->where('role_id', '=', Auth::guard('staff')->user()->role_id);
                    })->orWhere('participants', '=', 'All')->latest()->take(5)->get();
                    $view->with('events', $events);
                } elseif ($loggedInStaff == 'Administrative') {
                    $events = Event::whereHas('roles', function ($query) {
                        $query->where('role_id', '=', Auth::guard('staff')->user()->role_id);
                    })->orWhere('participants', '=', 'All')->latest()->take(5)->get();
                    $view->with('events', $events);
                } elseif ($loggedInStaff == 'Receptionist') {
                    $events = Event::whereHas('roles', function ($query) {
                        $query->where('role_id', '=', Auth::guard('staff')->user()->role_id);
                    })->orWhere('participants', '=', 'All')->latest()->take(5)->get();
                    $view->with('events', $events);
                }
            } elseif (Auth::check()) {
                if (Auth::user()->role == 'superadmin') {
                    $events = Event::latest()->take(5)->get();
                    $view->with('events', $events);
                }
            } elseif (Auth::guard('student')->check()) {
                $events = Event::query()
                    ->where('participants', 'Student')
                    ->latest()
                    ->take(5)
                    ->get();
                $view->with('events', $events);
            }

            $school_setting = SchoolSetting::findOrFail(1);
            $view->with('school_setting', $school_setting);
        });

        //        View::composer('/teacher/*', function ($view) {
        //            $events = Event::whereHas('roles', function ($query){
        //                    $query->where('role_id', '=', Auth::guard('staff')->user()->id);
        //                })->latest()->take(5)->get();
        //            $view->with('events', $events);
        //        });
        //        View::composer(request()->is('super-admin/*'), function ($view) {
        //            $events = Event::latest()->take(5)->get();
        //            $view->with('events', $events);
        //        });
    }
}
