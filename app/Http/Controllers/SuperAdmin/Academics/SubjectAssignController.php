<?php

namespace App\Http\Controllers\SuperAdmin\Academics;

use App\Http\Controllers\Controller;
use App\Http\Requests\AssignOptionalSubjectRequest;
use App\Http\Requests\StoreAssignBatchSubjectRequest;
use App\Models\AcademicYear;
use App\Models\Batch;
use App\Models\Level;
use App\Models\Program;
use App\Models\Section;
use App\Models\Student;
use App\Models\Subject;
use App\Models\YearSemester;
use App\Services\YearSemesterService;
use Illuminate\Http\Request;

class SubjectAssignController extends Controller
{
    public function assignBatch(Request $request, YearSemesterService $yearSemesterService)
    {
        $data['academicYears'] = AcademicYear::all();

        $data['batches'] = Batch::all();

        $data['programs'] = Program::all();

        if ($request->academic_year_id && $request->program_id) {
            $data['yearSemesters'] = $yearSemesterService
                ->list($request->only(['academic_year_id', 'batch_id', 'program_id']));
        }

        // get subject list
        if ($request->year_semester_id) {
            $data['yearSemester'] = YearSemester::find($request->year_semester_id);
            $data['subjects'] = Subject::filterBy([
                'program_id' => $request->program_id,
                // TODO::implement number in year_semesters table
                // 'year_semester_number' => $data['yearSemester']->number
            ])->get();
            $data['subjects']->load('sections');
        }

        return view('pages.academics.subject.batch.assign', $data);
    }

    public function saveAssignBatch(StoreAssignBatchSubjectRequest $request)
    {
        $data = $request->validated();

        $yearSemester = YearSemester::find($data['year_semester_id']);
        $yearSemester->load(['subjects', 'sections']);

        // update year/batch subject (i.e. semester subjects)
        $yearSemester->subjects()->sync($data['subject_ids']);

        // detach section subjects (fix for old data)
        foreach ($yearSemester->sections as $section) {
            $section->subjects()->detach();
        }

        // update section subjects
        $yearSemester->load('subjects');
        foreach ($yearSemester->subjects as $subject) {
            $sectionIds = $data['section_ids'][$subject->id] ?? [];
            $subject->sections()->sync($sectionIds);
        }

        return redirect()->back()->with('success', 'Subjects assigned successfully');
    }

    public function assignOptional(Request $request, YearSemesterService $yearSemesterService)
    {
        $data['academicYears'] = AcademicYear::all();
        $data['batches'] = Batch::all();
        $data['programs'] = Program::all();

        if ($request->academic_year_id && $request->program_id) {
            $data['yearSemesters'] = $yearSemesterService
                ->list($request->only(['academic_year_id', 'batch_id', 'program_id']));
        }

        $data['sections'] = Section::where('year_semester_id', $request->year_semester_id)->get();

        // prepare data
        $data['subjects'] = collect([]);
        $data['students'] = collect([]);

        if ($request->year_semester_id) {
            $yearSemester = YearSemester::find($request->year_semester_id);

            // optional subject list
            // TODO::list only subjects specific to section if section wise optional subject assign
            $data['subjects'] = $yearSemester->subjects()->optional()->get();

            // filter students by year semester or section(if specified)
            $data['students'] = Student::where([
                'year_semester_id' => $request->year_semester_id
            ])->when(
                $request->section_id,
                function ($query, $sectionId) {
                    return $query->where('section_id', $sectionId);
                }
            )->with(['section', 'optionalSubjects'])->get();
        }

        return view('pages.academics.subject.student.assign-optional', $data);
    }

    public function saveAssignOptional(AssignOptionalSubjectRequest $request)
    {
        $students = Student::whereIn('id', $request->student_ids)->get();

        foreach ($students as $student) {
            $subjectIds = $request->student_subject_ids[$student->id] ?? [];
            $student->optionalSubjects()->sync($subjectIds);
        }

        $request->session()->flash('success', 'Subject(s) assigned successfully!'); // for flash message on reload
        return response()->json(['success' => true], 200);
    }
}
