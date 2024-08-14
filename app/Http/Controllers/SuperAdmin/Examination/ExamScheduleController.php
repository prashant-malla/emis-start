<?php

namespace App\Http\Controllers\SuperAdmin\Examination;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\ExamSubject;
use App\Models\YearSemester;
use App\Services\AcademicYearService;
use App\Services\BatchService;
use App\Services\ProgramService;
use Illuminate\Http\Request;

class ExamScheduleController extends Controller
{
    protected $base_route;
    protected $view_path;

    public function __construct(
        protected AcademicYearService $academicYearService,
        protected BatchService $batchService,
        protected ProgramService $programService
    ) {
        $this->base_route = 'exam-schedule';
        $this->view_path = 'pages.examination.exam_schedule';
    }

    public function index(Request $request)
    {
        $data['exams'] = collect([]);

        // filter data
        $data['academicYears'] = $this->academicYearService->getAll();
        $data['batches'] = $this->batchService->getAll();
        $data['programs'] = $this->programService->getAll();

        $data['yearSemesters'] = collect([]);
        if ($request->program_id) {
            $data['yearSemesters'] = YearSemester::where('program_id', $request->program_id)->get();
        }

        // exams by year semester id
        if ($request->has('year_semester_id')) {
            $data['exams'] = Exam::where('year_semester_id', $request->year_semester_id)->pluck('name', 'id');
        }

        // get schedules
        if ($request->has('exam_id')) {
            $data['schedules'] = ExamSubject::where('exam_id', $request->exam_id)->oldest('date')->get();
            $data['schedules']->load('subject');
        }

        return view($this->view_path . '.index', $data);
    }
}
