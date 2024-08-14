<?php

namespace App\Http\Controllers\SuperAdmin\Academics;

use App\Http\Controllers\Controller;
use App\Http\Requests\AssignOptionalSubjectRequest;
use App\Http\Requests\StoreSubjectRequest;
use App\Http\Requests\UpdateSubjectRequest;
use App\Models\Batch;
use App\Models\Program;
use App\Models\Level;
use App\Models\Subject;
use App\Models\Section;
use App\Models\Student;
use App\Models\YearSemester;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SubjectControllerV2 extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data['batches'] = Batch::latest('id')->get();
        $data['levels'] = Level::all();
        $data['programs'] = Program::where('level_id', $request->level_id)->get();
        $data['yearSemesters'] = YearSemester::where([
            'batch_id' => $request->batch_id,
            'program_id' => $request->program_id,
        ])->get();
        $data['sections'] = Section::where('year_semester_id', $request->year_semester_id)->get();
        $data['subjects'] = Subject::filterBy(
            $request->only(['level_id', 'program_id', 'year_semester_id', 'batch_id'])
        )->get();

        $data['filters'] = $request->all(['level_id', 'program_id', 'year_semester_id', 'batch_id']);
        return view('pages.academics.subject.index', $data);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $levels = Level::all();
        return view('pages.academics.subject.form-v2', compact('levels'));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreSubjectRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSubjectRequest $request)
    {
        $data = $request->all();

        if ($request->type === "is_theory") {
            $data['practical_full_marks'] = 0;
            $data['practical_pass_marks'] = 0;
        }

        if ($request->type === "is_practical") {
            $data['theory_full_marks'] = 0;
            $data['theory_pass_marks'] = 0;
        }

        $subject = new Subject();
        $subject->fill($data);
        $subject->save();
        return redirect()->route('subject.index')->with('success', 'Subject created successfully');
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function classDropDownShow(Subject $subject)
    {
        $class = DB::table('eclasses')->select('id', 'class_name')->get();
        $section = DB::table('sections')->select('id', 'section_name')->get();
        $subject = Subject::all();
        return view('pages.academics.subject.index', ['class' => $class, 'section' => $section], compact('subject'));
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function edit(Subject $subject)
    {
        $levels = Level::all();
        $programs = Program::where('level_id', $subject->level_id)->get();
        $yearSemesters = YearSemester::where('program_id', $subject->program_id)->get();
        $sections = Section::where('year_semester_id', $subject->year_semester_id)->get();
        return view('pages.academics.subject.edit', compact('yearSemesters', 'levels', 'programs', 'sections', 'subject'));
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateSubjectRequest  $request
     * @param  \App\Models\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSubjectRequest $request, Subject $subject)
    {
        $data = $request->all();

        if ($request->type === "is_theory") {
            $data['practical_full_marks'] = 0;
            $data['practical_pass_marks'] = 0;
        }

        if ($request->type === "is_practical") {
            $data['theory_full_marks'] = 0;
            $data['theory_pass_marks'] = 0;
        }

        $subject->fill($data);
        $subject->update();
        return redirect()->route('subject.index')->with('success', 'Subject Updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function destroy(Subject $subject)
    {
        try {
            $subject->delete();
        } catch (\Exception $e) {
            return back()->with('error', 'Cannot delete a parent subject. This subject is being used in other modules.');
        }
        return redirect()->route('subject.index')->with('success', 'Deleted successfully');
    }

    public function getSection($id)
    {
        $sections = Section::where('program_id', $id)->get();
        return response(json_encode($sections));
    }

    public function assignToGroup(Request $request)
    {
        $data = [];

        $data['subjects'] = [];

        $data['levels'] = Level::all();

        $data['programs'] = Program::where('level_id', $request->level_id)->get();
        $data['yearSemesters'] = YearSemester::where('program_id', $request->program_id)->get();
        $data['sections'] = Section::where('year_semester_id', $request->year_semester_id)->get();

        if ($request->level_id && $request->program_id && $request->year_semester_id && $request->section_id) {
            $data['subjects'] = Subject::where([
                'level_id' => $request->level_id,
                'program_id' => $request->program_id,
                'year_semester_id' => $request->year_semester_id
            ])->get();

            $data['section'] = Section::find($request->section_id);
        }

        $data['filters'] = $request->all(['level_id', 'program_id', 'year_semester_id', 'section_id']);

        return view('pages.academics.subject.assign-to-group', $data);
    }

    public function saveAssignToGroup(Request $request)
    {
        $section = Section::find($request->section_id);
        $section->subjects()->sync($request->subject_id);

        return back()->withSuccess('Subject(s) assigned successfully!');
    }

    public function assignOptional(Request $request)
    {
        $data['subjects'] = collect([]);
        $data['students'] = collect([]);

        $data['levels'] = Level::all();
        $data['programs'] = Program::where('level_id', $request->level_id)->get();
        $data['yearSemesters'] = YearSemester::where('program_id', $request->program_id)->get();
        $data['sections'] = Section::where('year_semester_id', $request->year_semester_id)->get();

        if ($request->level_id && $request->program_id && $request->year_semester_id) {
            $data['subjects'] = Subject::optional()->where([
                'level_id' => $request->level_id,
                'program_id' => $request->program_id,
                'year_semester_id' => $request->year_semester_id
            ])->get();
            $data['students'] = Student::where([
                'level_id' => $request->level_id,
                'program_id' => $request->program_id,
                'year_semester_id' => $request->year_semester_id
            ])->when($request->section_id, function ($query, $sectionId) {
                return $query->where('section_id', $sectionId);
            })->with(['section', 'optionalSubjects'])->get();
        }

        $data['filters'] = $request->all(['level_id', 'program_id', 'year_semester_id', 'section_id']);
        return view('pages.academics.subject.assign-optional', $data);
    }

    public function saveAssignOptional(AssignOptionalSubjectRequest $request)
    {
        $students = Student::whereIn('id', $request->student_ids)->get();
        $studentSubjectIds = $request->student_subject_ids;

        foreach ($students as $student) {
            $subjectIds = isset($studentSubjectIds[$student->id]) ? $studentSubjectIds[$student->id] : [];
            $student->optionalSubjects()->sync($subjectIds);
        }

        $request->session()->flash('success', 'Subject(s) assigned successfully!');
        return response()->json(['success' => true], 200);
    }

    public function assignToBatch()
    {
        $data = [];
        return view('pages.academics.subject.assign-to-batch', $data);
    }
}
