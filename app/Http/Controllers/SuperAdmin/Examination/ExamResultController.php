<?php

namespace App\Http\Controllers\SuperAdmin\Examination;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\ExamMark;
use App\Models\ExamSubject;
use App\Models\Program;
use App\Models\SchoolSetting;
use App\Models\Student;
use App\Models\YearSemester;
use App\Services\AcademicYearService;
use App\Services\BatchService;
use App\Services\ProgramService;
use Illuminate\Http\Request;

class ExamResultController extends Controller
{
    protected $base_route;
    protected $view_path;

    public function __construct(
        protected AcademicYearService $academicYearService,
        protected BatchService $batchService,
    ) {
        $this->base_route = 'exam_result';
        $this->view_path = 'pages.examination.exam_result';
    }

    public function index(Request $request)
    {
        $exam = null;
        $exams = [];
        $filterStudents = [];
        $students = collect();
        $examSubjects = collect();
        $examMarks = null;
        $year_semester_id = $request->year_semester_id;
        $exam_id = $request->exam_id;

        if ($request->has('year_semester_id') && $request->has('exam_id')) {
            $request->validate([
                'year_semester_id' => 'required',
                'exam_id' => 'required',
            ]);

            $exam = Exam::where('id', $request->exam_id)->first();

            $examSubjects = ExamSubject::where('exam_id', $exam_id)->get();
            $examSubjects->load('subject');

            $examMarks = ExamMark::where('exam_id', $exam_id)->get()->groupBy('student_id');

            if ($request->student_id) {
                $students = Student::select('id', 'sname', 'admission', 'roll')->where('id', $request->student_id)->get();
            } else {
                $students = Student::select('id', 'sname', 'admission', 'roll')->whereIn('id', $examMarks->keys())->get();
            }

            $filterStudents = Student::select('id', 'sname')->whereIn('id', $examMarks->keys())->get();

            $exams = Exam::where('year_semester_id', $request->year_semester_id)->pluck('name', 'id');
        }

        $academicYears = $this->academicYearService->getAll();
        $batches = $this->batchService->getAll();
        $programs = Program::select('id', 'name')->get();

        $yearSemesters = collect([]);
        if ($request->program_id) {
            $yearSemesters = YearSemester::where('program_id', $request->program_id)->get();
        }

        return view($this->view_path . '.index')->with([
            'year_semester_id' => $year_semester_id,
            'exam_id' => $exam_id,
            'exam' => $exam,
            'academicYears' => $academicYears,
            'batches' => $batches,
            'programs' => $programs,
            'yearSemesters' => $yearSemesters,
            'exams' => $exams,
            'examSubjects' => $examSubjects,
            'examMarks' => $examMarks,
            'students' => $students,
            'filterStudents' => $filterStudents,
            'student_id' => $request->student_id,
        ]);
    }

    protected function loadMarksheet($exam, $student_ids)
    {
        $school = SchoolSetting::find(1);

        $examSubjects = ExamSubject::where('exam_id', $exam->id)->get();
        $examSubjects->load('subject');

        $viewFile = $exam->exam_type_id === 1 ? 'print_grade' : 'print_percentage';
        return view($this->view_path . '.' . $viewFile, compact('school', 'student_ids', 'examSubjects', 'exam'));
    }

    public function marksheet(Exam $exam, Student $student)
    {
        $studentIds = [$student->id];
        return $this->loadMarksheet($exam, $studentIds);
    }

    public function bulkMarksheet(Request $request, Exam $exam)
    {
        if (!$request->studentIds) {
            return redirect()->route($this->base_route . '.index');
        }

        $studentIds = explode(',', $request->studentIds);
        return $this->loadMarksheet($exam, $studentIds);
    }
}
