<?php

namespace App\Http\Controllers\Teacher\Examination;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\ExamMark;
use App\Models\ExamSubject;
use App\Models\Level;
use App\Models\Program;
use App\Models\Section;
use App\Models\Student;
use App\Models\TeacherAssign;
use App\Models\YearSemester;
use App\Services\AcademicYearService;
use App\Services\BatchService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class ExamController extends Controller
{
    protected $base_route;
    protected $view_path;

    public function __construct(
        protected AcademicYearService $academicYearService,
        protected BatchService $batchService,
    ) {
        $this->base_route = 'teacher.exams';
        $this->view_path = 'pages.examination';

        View::share('base_route', $this->base_route);
    }

    public function index(Request $request)
    {
        $teacherId = Auth::guard('staff')->user()->id;

        $teacherAssigns = TeacherAssign::where('teacher_id', $teacherId)->get();

        $data['academicYears'] = $this->academicYearService->getAll();
        $data['batches'] = $this->batchService->getAll();

        $data['programs'] = Program::query()
            ->whereIn('id', $teacherAssigns->pluck('program_id'))
            ->get();

        $data['yearSemesters'] = collect([]);
        if ($request->program_id) {
            $data['yearSemesters'] = YearSemester::query()
                ->where('program_id', $request->program_id)
                ->whereIn('id', $teacherAssigns->pluck('year_semester_id'))
                ->get();
        }

        // set initial academic year id
        $request->merge(['academic_year_id' => $request->academic_year_id ?? $data['academicYears']->where('is_active', 1)->first()?->id]);

        $data['rows'] = Exam::query()
            ->filterBy(
                $request->only(['academic_year_id', 'batch_id', 'program_id', 'year_semester_id'])
            )
            ->whereIn('year_semester_id', $teacherAssigns->pluck('year_semester_id'))
            ->latest('id')
            ->active()
            ->get();

        return view('pages.examination.exam.index', $data);
    }

    public function schedule(Request $request)
    {
        $data['exams'] = collect([]);

        // filter data
        $data['academicYears'] = $this->academicYearService->getAll();
        $data['batches'] = $this->batchService->getAll();

        // get assigned program and yearsemester ids
        $teacherId = Auth::guard('staff')->user()->id;
        $teacherAssignFaculities = TeacherAssign::where('teacher_id', $teacherId)->pluck('program_id', 'year_semester_id')->toArray();

        // load assigned programs
        $data['programs'] = Program::whereIn('id', $teacherAssignFaculities)->select('id', 'name')->get();

        // load assigned yearsemesters
        $data['yearSemesters'] = collect([]);
        if ($request->program_id) {
            $data['yearSemesters'] = YearSemester::query()
                ->where('program_id', $request->program_id)
                ->whereIn('id', array_keys($teacherAssignFaculities))
                ->get();
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

        return view('pages.examination.exam_schedule.index', $data);
    }

    public function examMarks(Request $request, Exam $exam)
    {
        $section_id = $request->section_id;
        $subject_id = $request->subject_id;

        $students = [];
        $examMarks = collect();
        if ($section_id) {
            $students = Student::with('optionalSubjects')->where(['level_id' => $exam->level_id, 'program_id' => $exam->program_id, 'year_semester_id' => $exam->year_semester_id])
                ->when($section_id !== 'All', function ($query) use ($section_id) {
                    return $query->where('section_id', $section_id);
                })->orderBy('roll')->get();

            $studentIds = $students->pluck('id');
            $examMarks = ExamMark::where('exam_id', $exam->id)->whereIn('student_id', $studentIds)
                ->when($subject_id !== 'All', function ($query) use ($subject_id) {
                    return $query->where('subject_id', $subject_id);
                })->get()->groupBy('student_id');
        }

        // get assigned subjects
        $teacherId = Auth::guard('staff')->user()->id;
        $teacherAssignSubjects = TeacherAssign::where('teacher_id', $teacherId)->pluck('subject_id')->toArray();

        // show exam subjects assigned to teacher only
        $subjects = ExamSubject::where('exam_id', $exam->id)->whereIn('subject_id', $teacherAssignSubjects)->get();
        $subjects->load('subject');
        $examSubjects = $subject_id === 'All' ? $subjects : $subjects->filter(function ($data) use ($subject_id) {
            return $data->subject_id == $subject_id;
        });
        $sections = Section::where(['level_id' => $exam->level_id, 'program_id' => $exam->program_id, 'year_semester_id' => $exam->year_semester_id])->get();

        return view('pages.examination.exam_marks.index')->with([
            'examMarks' => $examMarks,
            'subjects' => $subjects,
            'examSubjects' => $examSubjects,
            'exam' => $exam,
            'sections' => $sections,
            'section_id' => $section_id,
            'subject_id' => $subject_id,
            'students' => $students
        ]);
    }

    public function storeExamMarks(Request $request, Exam $exam)
    {
        // TODO::allow marks entry only in assigned subjects/sections
        $teacherId = Auth::guard('staff')->user()->id;
        foreach ($request->student_id as $i => $studentId) {
            foreach ($request->subject_id as $subjectId) {
                $theoryKey = 'th';
                $pracKey = 'pr';
                $theoryAbsKey = 'th_abs';
                $pracAbsKey = 'pr_abs';
                $theoryMark = isset($request[$theoryKey][$studentId][$subjectId]) ? $request[$theoryKey][$studentId][$subjectId] : null;
                $practicalMark = isset($request[$pracKey][$studentId][$subjectId]) ? $request[$pracKey][$studentId][$subjectId] : null;
                $absentTheory = isset($request[$theoryAbsKey][$studentId][$subjectId]) && (bool)$request[$theoryAbsKey][$studentId][$subjectId];
                $absentPractical = isset($request[$pracAbsKey][$studentId][$subjectId]) && (bool)$request[$pracAbsKey][$studentId][$subjectId];

                $examMark = ExamMark::where(['exam_id' => $exam->id, 'student_id' => $studentId, 'subject_id' => $subjectId])->first();

                // delete exam marks if marks are cleared
                if (($theoryMark === null && !$absentTheory) && ($practicalMark === null && !$absentPractical)) {
                    if ($examMark) {
                        $examMark->delete();
                    }
                    continue;
                }

                if (!$examMark) {
                    $examMark = new ExamMark();
                }
                $examMark->exam_id =  $exam->id;
                $examMark->student_id =  $studentId;
                $examMark->subject_id =  $subjectId;
                $examMark->teacher_id =  $teacherId;
                $examMark->theory_mark =  $theoryMark;
                $examMark->practical_mark =  $practicalMark;
                $examMark->is_th_absent =  $absentTheory;
                $examMark->is_pr_absent =  $absentPractical;
                $examMark->save();
            }
        }
        return redirect()->route($this->base_route)->with('success', 'Marks assigned Successfully.');
    }

    public function result(Request $request)
    {
        $exams = [];
        $filterStudents = [];
        $students = collect();
        $examSubjects = collect();
        $examMarks = null;
        $year_semester_id = $request->year_semester_id;
        $exam_id = $request->exam_id;

        // get assigned program and yearsemester ids
        $teacherId = Auth::guard('staff')->user()->id;
        $teacherAssignFaculities = TeacherAssign::where('teacher_id', $teacherId)->pluck('program_id', 'year_semester_id')->toArray();

        // load assigned programs and yearsemesters
        $programs = Program::whereIn('id', $teacherAssignFaculities)->select('id', 'name')->get();
        $programs->load(['yearSemesters' => function ($query) use ($teacherAssignFaculities) {
            $query->whereIn('id', array_keys($teacherAssignFaculities));
        }]);

        // exams by year semester id
        if ($request->has('year_semester_id')) {
            $exams = Exam::where('year_semester_id', $year_semester_id)->pluck('name', 'id');
        }

        // get exam subjects with student marks
        if ($request->has('exam_id')) {
            $examSubjects = ExamSubject::where('exam_id', $exam_id)->get();
            $examSubjects->load('subject');

            $examMarks = ExamMark::where('exam_id', $exam_id)->get()->groupBy('student_id');
            if ($request->student_id) {
                $students = Student::select('id', 'sname', 'admission')->where('id', $request->student_id)->get();
            } else {
                $students = Student::select('id', 'sname', 'admission')->whereIn('id', $examMarks->keys())->get();
            }
            $filterStudents = Student::select('id', 'sname')->whereIn('id', $examMarks->keys())->get();
        }

        return view($this->view_path . '.exam_result.index')->with([
            'year_semester_id' => $year_semester_id,
            'exam_id' => $exam_id,
            'programs' => $programs,
            'exams' => $exams,
            'examSubjects' => $examSubjects,
            'examMarks' => $examMarks,
            'students' => $students,
            'filterStudents' => $filterStudents,
            'student_id' => $request->student_id,
        ]);
    }
}
