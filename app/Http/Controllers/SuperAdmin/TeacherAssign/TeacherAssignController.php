<?php

namespace App\Http\Controllers\SuperAdmin\TeacherAssign;

use App\Models\Program;
use App\Models\Section;
use App\Models\Subject;
use App\Models\YearSemester;
use Illuminate\Http\Request;
use App\Models\TeacherAssign;
use App\Models\StaffDirectory;
use App\Services\BatchService;
use App\Services\ProgramService;
use App\Http\Controllers\Controller;
use App\Services\AcademicYearService;
use App\Http\Requests\AssignTeacherRequest;

class TeacherAssignController extends Controller
{
    public function __construct(protected AcademicYearService $academicYearService, protected BatchService $batchService, protected ProgramService $programService) 
    {
        //    
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // filter data
        $data['academicYears'] = $this->academicYearService->getAll();
        $data['batches'] = $this->batchService->getAll();

        // set initial academic year id
        $request->merge(['academic_year_id' => $request->academic_year_id ?? $data['academicYears']->where('is_active', 1)->first()->id]);

        $yearSemesters = YearSemester::filterBy($request->only('academic_year_id', 'batch_id'))->get();
        
        $data['groups'] = Section::whereIn('year_semester_id', $yearSemesters->pluck('id'))->get();
        $data['groups']->load(['level', 'program', 'yearsemester']);

        return view('pages.teacher_assign.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     *  @param
     * @return \Illuminate\Http\Response
     */
    public function create(Section $section, $id)
    {
        $yearSemester = YearSemester::findOrFail($id);
        $staffs = new StaffDirectory();
        $teachers = $staffs->whereHas('role', function ($query) {
            $query->where('role', 'Teacher');
        })->get();
        $assignedSubjectIds = TeacherAssign::where('year_semester_id', $yearSemester->id)
            ->where('section_id', $section->id)
            ->pluck('subject_id');
        // $subjects = Subject::where('year_semester_id', $yearSemester->id)
        //     ->where('section_id', $section->id)
        //     ->whereNotIn('id', $assignedSubjectIds)->get();
        $subjects = $section->subjects()->whereNotIn('id', $assignedSubjectIds)->get();
        return view('pages.teacher_assign.form', compact('yearSemester', 'teachers', 'subjects', 'section'));
    }

    /**
     * Show the form for creating a new resource.
     *
     *  @param  $exam_id
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $programs = Program::all();
        $yearSemesters = YearSemester::all();
        $sections = Section::all();
        $staffs = new StaffDirectory();
        $teachers = $staffs->whereHas('role', function ($query) {
            $query->where('role', 'Teacher');
        })->get();
        $searchedSubjects = Subject::where([
            ['program_id', $request->program_id],
            ['year_semester_id', $request->year_semester_id],
            ['section_id', $request->section_id],
        ])->get();
        return view('pages.teacher_assign.create', compact('programs', 'yearSemesters', 'sections', 'teachers', 'searchedSubjects'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  AssignTeacherRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AssignTeacherRequest $request)
    {
        $section = Section::findOrFail($request->section_id);

        foreach ($request->subject_ids as $i => $subjectId) {

            $assignedSubjectTeachers = $request->subject_teacher_id[$subjectId] ?? [];

            foreach ($assignedSubjectTeachers as $teacherId) {
                $teacherAssign = new TeacherAssign();
                $teacherAssign->level_id = $section->level_id;
                $teacherAssign->program_id = $section->program_id;
                $teacherAssign->year_semester_id = $section->year_semester_id;
                $teacherAssign->section_id = $section->id;
                $teacherAssign->teacher_id = $teacherId;
                $teacherAssign->subject_id = $subjectId;
                $teacherAssign->time = $request->times[$i] ?? null;
                $teacherAssign->save();
            }
        }
        return redirect()->route('teacher-assign.list')->with('success', 'Added Successfully.');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list(Request $request)
    {
        $data['academicYears'] = $this->academicYearService->getAll();
        $data['batches'] = $this->batchService->getAll();

        // set initial academic year id
        $request->merge(['academic_year_id' => $request->academic_year_id ?? $data['academicYears']->where('is_active', 1)->first()->id]);
        
        $data['teacherAssign'] = TeacherAssign::filterBy($request->only('academic_year_id', 'batch_id'))->latest('id')->get();
        $data['teacherAssign']->load(['level', 'program', 'yearsemester', 'section', 'teacher', 'subject']);
        return view('pages.teacher_assign.list', $data);
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Section $section
     * @param  Subject $subject
     * @return \Illuminate\Http\Response
     */
    public function edit(Section $section, Subject $subject)
    {
        $data = [];

        $data['yearSemester'] = $section->yearsemester;
        $data['section'] = $section;

        $teacherAssigns = TeacherAssign::where([
            'section_id' => $section->id,
            'subject_id' => $subject->id,
        ])->get();
        $data['teacherAssigns'] = $teacherAssigns;

        $data['teachers'] = StaffDirectory::whereHas('role', function ($query) {
            $query->where('role', 'Teacher');
        })->get();

        $data['subjects'] = collect([$subject]);

        return view('pages.teacher_assign.form', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Section $section
     * @param  Subject $subject
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Section $section, Subject $subject)
    {
        $assignedSubjectTeachers = $request->subject_teacher_id[$subject->id] ?? [];
        if (count($assignedSubjectTeachers) === 0) {
            return back()->withError('You must choose at least one teacher.');
        }

        $teacherAssigns = TeacherAssign::where([
            'section_id' => $section->id,
            'subject_id' => $subject->id,
        ])->get();

        $teacherAssigns->whereNotIn('teacher_id', $assignedSubjectTeachers)->each->delete();

        foreach ($assignedSubjectTeachers as $i => $teacherId) {
            $existingTeacher = $teacherAssigns->where('teacher_id', $teacherId)->first();
            $teacherAssign = $existingTeacher ?? new TeacherAssign();

            $teacherAssign->level_id = $section->level_id;
            $teacherAssign->program_id = $section->program_id;
            $teacherAssign->year_semester_id = $section->year_semester_id;
            $teacherAssign->section_id = $section->id;
            $teacherAssign->teacher_id = $teacherId;
            $teacherAssign->subject_id = $subject->id;
            $teacherAssign->time = $request->times[$i] ?? null;

            $existingTeacher ? $teacherAssign->update() : $teacherAssign->save();
        }

        return redirect()->route('teacher-assign.list')->with('success', 'Updated Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Section $section
     * @param  Subject $subject
     * @return \Illuminate\Http\Response
     */
    public function destroy(Section $section, Subject $subject)
    {
        TeacherAssign::where([
            'section_id' => $section->id,
            'subject_id' => $subject->id,
        ])->delete();
        return redirect()->route('teacher-assign.list')->with('success', 'Assigned Teacher Deleted Successfully.');
    }
}
