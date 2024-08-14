<?php

namespace App\Http\Controllers\SuperAdmin\Examination;

use App\Http\Controllers\Controller;
use App\Http\Requests\ExamRequest;
use App\Models\Exam;
use App\Models\ExamMark;
use App\Models\ExamSubject;
use App\Models\ExamType;
use App\Models\Program;
use App\Models\Level;
use App\Models\Section;
use App\Models\Student;
use App\Models\Subject;
use App\Models\YearSemester;
use App\Services\AcademicYearService;
use App\Services\BatchService;
use App\Services\ProgramService;
use App\Services\YearSemesterService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class ExamController extends Controller
{
    protected $base_route;
    protected $view_path;

    public function __construct(
        protected AcademicYearService $academicYearService,
        protected BatchService $batchService,
        protected ProgramService $programService,
        protected YearSemesterService $yearSemesterService
    ) {
        $this->base_route = 'exams';
        $this->view_path = 'pages.examination.exam';

        View::share('base_route', $this->base_route);
    }

    public function index(Request $request)
    {
        // filter data
        $data['academicYears'] = $this->academicYearService->getAll();
        $data['batches'] = $this->batchService->getAll();
        $data['programs'] = $this->programService->getAll();

        $data['yearSemesters'] = collect([]);
        if ($request->program_id) {
            $data['yearSemesters'] = YearSemester::where('program_id', $request->program_id)->get();
        }

        // set initial academic year id
        $request->merge(['academic_year_id' => $request->academic_year_id ?? $data['academicYears']->where('is_active', 1)->first()?->id]);

        // list exams
        $data['rows'] = Exam::query()
            ->filterBy(
                $request->only(['academic_year_id', 'batch_id', 'program_id', 'year_semester_id'])
            )
            ->latest('id')
            ->get();

        return view($this->view_path . '.index')->with($data);
    }

    public function create()
    {
        $data['academicYears'] = $this->academicYearService->getAll();
        $data['batches'] = $this->batchService->getAll();
        $data['programs'] = $this->programService->getAll();
        $data['examTypes'] = ExamType::pluck('exam_type', 'id');

        return view($this->view_path . '.form', $data);
    }

    public function store(ExamRequest $request)
    {
        $data = $request->all();

        $data['status'] = !!$request->status;
        Exam::create($data);
        return redirect()->route($this->base_route . '.index')->with('success', 'Created Successfully!');
    }

    public function edit(Exam $exam)
    {
        $data['academicYears'] = $this->academicYearService->getAll();
        $data['batches'] = $this->batchService->getAll();
        $data['programs'] = $this->programService->getAll();
        $data['examTypes'] = ExamType::pluck('exam_type', 'id');

        $data['yearSemesters'] = $this->yearSemesterService->getByProgramId($exam->program_id, [
            'academic_year_id' => $exam->yearSemester->academic_year_id,
            'batch_id' => $exam->yearSemester->batch_id
        ]);

        $data['data'] = $exam;

        return view($this->view_path . '.form', $data);
    }

    public function update(ExamRequest $request, Exam $exam)
    {
        $data = $request->all();
        $data['status'] = !!$request->status;
        $exam->fill($data);
        $exam->update();
        return redirect()->route($this->base_route . '.index')->with('success', 'Updated Successfully!');
    }

    public function destroy(Exam $exam)
    {
        $exam->delete();
        return redirect()->route($this->base_route . '.index')->with('success', 'Deleted Successfully!');
    }

    public function examSubjects(Exam $exam)
    {
        // $assigned = ExamMark::where('exam_id', $exam->id)->exists();
        // if($assigned){
        //     return redirect()->route($this->base_route.'.index')->with('error', 'Cannot edit subjects as marks has already been assigned to subjects!');
        // }

        $examSubjects = ExamSubject::where('exam_id', $exam->id)->with('subject')->get()->groupBy('subject_id')->map(function ($items) {
            return $items[0];
        });

        $subjects = YearSemester::find($exam->year_semester_id)?->subjects;
        return view($this->view_path . '.exam_subjects')->with([
            'examSubjects' => $examSubjects,
            'exam' => $exam,
            'subjects' => $subjects
        ]);
    }

    public function storeExamSubjects(Request $request, Exam $exam)
    {
        foreach ($request->subject_id as $key => $subject_id) {
            $examSubject = ExamSubject::where(['exam_id' => $exam->id, 'subject_id' => $subject_id])->first();
            if ($request->date[$key] && $request->time[$key] && $request->duration[$key]) {
                if (!$examSubject) {
                    $examSubject = new ExamSubject();
                }
                $examSubject->exam_id = $exam->id;
                $examSubject->subject_id = $subject_id;
                $examSubject->date = $request->date[$key];
                $examSubject->time = new Carbon($request->time[$key]);
                $examSubject->duration = $request->duration[$key];
                $examSubject->room_number = $request->room_number[$key];

                $examSubject->theory_full_marks = $request->theory_full_marks[$key] ?? null;
                $examSubject->theory_pass_marks = $request->theory_pass_marks[$key] ?? null;
                $examSubject->practical_full_marks = $request->practical_full_marks[$key] ?? null;
                $examSubject->practical_pass_marks = $request->practical_pass_marks[$key] ?? null;

                // if ($request->subject_type[$key] === 'has_theory_practical') {
                //     $includeTheory = $request->include_theory[$subject_id] ?? 0;
                //     $includePractical = $request->include_practical[$subject_id] ?? 0;
                //     if (!$includeTheory && !$includePractical) {
                //         $includeTheory = 1;
                //     }
                //     $examSubject->include_theory = $includeTheory;
                //     $examSubject->include_practical = $includePractical;
                // }

                $examSubject->save();
            } else {
                // if old value is cleared
                if ($examSubject) {
                    $examSubject->delete();
                }
            }
        }
        return redirect()->route($this->base_route . '.index')->with('success', 'Assigned Successfully.');
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

        $subjects = ExamSubject::where('exam_id', $exam->id)->get();
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
                $examMark->theory_mark =  $theoryMark;
                $examMark->practical_mark =  $practicalMark;
                $examMark->is_th_absent =  $absentTheory;
                $examMark->is_pr_absent =  $absentPractical;
                $examMark->save();
            }
        }
        return redirect()->route($this->base_route . '.index')->with('success', 'Marks assigned Successfully.');
    }

    public function assignMarks(Request $request)
    {
        $data['academicYears'] = $this->academicYearService->getAll();
        $data['batches'] = $this->batchService->getAll();
        $data['programs'] = $this->programService->getAll();

        return view('pages.examination.exam_marks.assign', $data);
    }
}
