<?php

namespace App\Http\Controllers\SuperAdmin\Examination;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\ExamMark;
use App\Models\Program;
use App\Models\Section;
use App\Models\Student;
use App\Models\YearSemester;
use App\Services\AcademicYearService;
use App\Services\BatchService;
use Illuminate\Http\Request;

class MarkLedgerController extends Controller
{
    protected $base_route;
    protected $view_path;

    public function __construct(
        protected AcademicYearService $academicYearService,
        protected BatchService $batchService,
    ) {
        $this->base_route = 'mark_ledger';
        $this->view_path = 'pages.examination.mark_ledger';
    }

    protected function getStudentRanks($studentMarks)
    {
        $rankedStudents = collect([]);
        $rank = 0;
        $studentMarks
            ->sortDesc()
            ->each(function ($item, $studentId) use (&$rankedStudents, &$rank) {
                $rank++;
                $rankedStudents->put($studentId, $rank);
            });
        return $rankedStudents;
    }

    protected function hasStudentMarksAssignedForAllSubjects($examMarks, $examSubjects)
    {
        $totalExamSubjects = $examSubjects->count();
        return $examMarks
            ->groupBy('student_id')
            ->contains(function ($marks) use ($totalExamSubjects) {
                return $marks->count('subject_id') === $totalExamSubjects;
            });
    }

    protected function getPassedStudentMarks($examMarks, $examSubjects)
    {
        return $examMarks
            ->groupBy('student_id')
            ->filter(function ($marks) use ($examSubjects) {
                return $marks->doesntContain(function ($mark) use ($examSubjects) {
                    $examSubject = $examSubjects->where('subject_id', $mark->subject_id)->first();
                    return $mark->is_th_absent || $mark->is_pr_absent || !isPassInSubject($examSubject, $mark);
                });
            })
            ->map(function ($marks) {
                return $marks->sum(function ($mark) {
                    return getMark($mark->theory_mark) + getMark($mark->practical_mark);
                });
            });
    }

    public function index(Request $request)
    {
        $exams = [];
        $sections = [];

        $year_semester_id = $request->year_semester_id;
        $exam_id = $request->exam_id;
        $section_id = $request->section_id;

        $academicYears = $this->academicYearService->getAll();
        $batches = $this->batchService->getAll();
        $programs = Program::select('id', 'name')->get();

        // set initial academic year id
        $request->merge(['academic_year_id' => $request->academic_year_id ?? $academicYears->where('is_active', 1)->first()?->id]);

        $yearSemesters = collect([]);
        if ($request->program_id) {
            $yearSemesters = YearSemester::where('program_id', $request->program_id)->get();
        }

        // load data for dropdown
        if ($year_semester_id) {
            $sections = Section::select('id', 'group_name')->where('year_semester_id', $year_semester_id)->get();
            $exams = Exam::where('year_semester_id', $year_semester_id)->pluck('name', 'id');
        }

        // Fetch Exam Marks and other details
        if ($exam_id) {
            $exam = Exam::findOrFail($exam_id);
            $examSubjects = $exam->examSubjects()->with('subject')->get();
            $examMarks = ExamMark::query()
                ->where('exam_id', $exam_id)
                ->when($section_id, function ($query, $sectionId) {
                    $sectionStudentIds = Student::where('section_id', $sectionId)->pluck('id');
                    $query->whereIn('student_id', $sectionStudentIds);
                })->get();

            // check if all subject marks are assigned for students
            // if (!$this->hasStudentMarksAssignedForAllSubjects($examMarks, $examSubjects)) {
            //     return redirect()->back()->with('error', 'Some student marks has not been assigned for all subjects.');
            // }

            $studentRanks = $this->getStudentRanks(
                $this->getPassedStudentMarks($examMarks, $examSubjects)
            );

            $studentList = Student::select('id', 'sname', 'admission', 'roll')
                ->whereIn('id', $examMarks->pluck('student_id'))
                ->with('optionalSubjects')
                ->orderByRaw('CAST(roll AS UNSIGNED)')
                ->get();
            // ->sortBy(function ($item) use ($studentRanks) {
            //     // Sort Students with ranks first
            //     return $studentRanks->get($item->id) ?? PHP_INT_MAX;
            // });

            return view($this->view_path . '.index')->with([
                'programs' => $programs,
                'sections' => $sections,
                'exams' => $exams,
                'year_semester_id' => $year_semester_id,
                'section_id' => $section_id,
                'exam_id' => $exam_id,
                'exam' => $exam,
                'examMarks' => $examMarks,
                'studentRanks' => $studentRanks,
                'studentList' => $studentList,
                'examSubjects' => $examSubjects,
                'academicYears' => $academicYears,
                'batches' => $batches,
                'yearSemesters' => $yearSemesters,
            ]);
        }

        return view($this->view_path . '.index')->with([
            'programs' => $programs,
            'sections' => $sections,
            'exams' => $exams,
            'year_semester_id' => $year_semester_id,
            'section_id' => $section_id,
            'exam_id' => $exam_id,
            'academicYears' => $academicYears,
            'batches' => $batches,
            'yearSemesters' => $yearSemesters,
        ]);
    }
}
