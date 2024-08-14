<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Homework;
use App\Models\LessonPlan;
use App\Models\Notice;
use App\Models\StaffDirectory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('teacher');
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $data['totalAssignmentsCount'] = Homework::query()
            ->where('teacher_id', auth()->guard('staff')->user()->id)
            ->count();

        $data['totalEventsCount'] = Event::query()
            ->count();

        $data['totalNoticesCount'] = Notice::query()
            ->count();

        $data['totalLessonPlansCount'] = LessonPlan::query()
            ->where('teacher_id', auth()->guard('staff')->user()->id)
            ->count();

        $data['assignments'] = Homework::query()
            ->with('level', 'program', 'section', 'subject')
            ->where('teacher_id', auth()->guard('staff')->user()->id)
            ->latest()
            ->take(10)
            ->get();

        return
            view('teacher.dashboard', $data);
    }

    public function teacherProfile()
    {
        $teacher = StaffDirectory::where('id', Auth::guard('staff')->user()->id)->first();
        return view('teacher.profile', compact('teacher'));
    }
}
