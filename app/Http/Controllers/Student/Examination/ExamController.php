<?php

namespace App\Http\Controllers\Student\Examination;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\ExamMark;
use App\Models\ExamSubject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class ExamController extends Controller
{
    protected $base_route;
    protected $view_path;

    public function __construct()
    {
        $this->base_route = 'student.exams';
        $this->view_path = 'pages.examination';

        View::share('base_route', $this->base_route);
    }

    public function index()
    {
        $student = Auth::guard('student')->user();
        $exams = Exam::where('year_semester_id', $student->year_semester_id)->active()->get();
        return view($this->view_path . '.exam.index')->with('rows', $exams);
    }

    public function schedule(Request $request)
    {
        $schedules = null;
        $exams = [];
        $exam_id = $request->exam_id;

        $student = Auth::guard('student')->user();
        $exams = Exam::where('year_semester_id', $student->year_semester_id)->pluck('name', 'id');

        // get schedules
        if ($request->has('exam_id')) {
            $schedules = ExamSubject::where('exam_id', $exam_id)->oldest('date')->get();
            $schedules->load('subject');
        }

        return view($this->view_path . '.exam_schedule.index')->with([
            'exam_id' => $exam_id,
            'schedules' => $schedules,
            'exams' => $exams
        ]);
    }

    public function result(Request $request)
    {
        $exams = [];
        $examSubjects = collect();
        $examMarks = null;
        $exam_id = $request->exam_id;

        $student = Auth::guard('student')->user();
        $exams = Exam::where('year_semester_id', $student->year_semester_id)->pluck('name', 'id');

        // get exam subjects with marks
        if ($request->has('exam_id')) {
            $examSubjects = ExamSubject::where('exam_id', $exam_id)->get();
            $examSubjects->load('subject');

            $examMarks = ExamMark::where('exam_id', $exam_id)->where('student_id', $student->id)->get();
        }

        return view($this->view_path . '.exam_result.index')->with([
            'exam_id' => $exam_id,
            'exams' => $exams,
            'examSubjects' => $examSubjects,
            'examMarks' => $examMarks,
            'student' => $student
        ]);
    }
}
