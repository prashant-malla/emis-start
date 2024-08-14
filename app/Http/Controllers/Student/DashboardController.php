<?php

namespace App\Http\Controllers\Student;

use App\Models\Event;
use App\Models\Notice;
use App\Models\Student;
use App\Models\Homework;
use Illuminate\Http\Request;
use App\Services\EventService;
use App\Services\NoticeService;
use App\Services\HomeworkService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        protected HomeworkService $homework,
        protected EventService $event,
        protected NoticeService $notice,
    ) {
        $this->middleware('student');
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $student = auth()->guard('student')->user();

        $data['totalAssginmentsCount'] = $this->homework->getTotalHomeworks($student);

        $data['totalEventsCount'] = $this->event->getTotalEvents($student);

        $data['totalNoticesCount'] = $this->notice->getTotalNotices($student);

        $data['totalFeesAmount'] = config('app.currency') . '. ' . 0;

        $data['assignments'] = $this->homework->getHomeworks(student: auth()->guard('student')->user());

        return view('student.dashboard', $data);
    }

    public function studentProfile()
    {
        // @dd(Auth::guard('student')->user());

        /*   if(Auth::check()) {
               $student = Student::where('students.id', '=', Auth::id())->get();
               return view('student.profile', ['student' => $student]);
           }*/
        $student= Auth::guard('student')->user();
        return view('student.profile', ['student'=>$student]);
    }
}
