<?php

namespace App\Http\Controllers\SuperAdmin\Academics;

use App\Http\Controllers\Controller;
use App\Http\Requests\AssignOptionalSubjectRequest;
use App\Http\Requests\StoreSubjectRequest;
use App\Http\Requests\UpdateSubjectRequest;
use App\Models\Program;
use App\Models\Level;
use App\Models\Subject;
use App\Models\Section;
use App\Models\Student;
use App\Models\YearSemester;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SubjectController extends Controller
{
    private $yearNumbers = [
        'First Year' => 1,
        'Second Year' => 2,
        'Third Year' => 3,
        'Fourth Year' => 4,
    ];

    private $semesterNumbers = [
        'First Semester' => 1,
        'Second Semester' => 2,
        'Third Semester' => 3,
        'Fourth Semester' => 4,
        'Fifth Semester' => 5,
        'Sixth Semester' => 6,
        'Seventh Semester' => 7,
        'Eighth Semester' => 8,
    ];

    private function getCourseTypeNumbers($courseType)
    {
        return $courseType === 'year' ? $this->yearNumbers : $this->semesterNumbers;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data['levels'] = Level::all();
        $data['programs'] = Program::where('level_id', $request->level_id)->get();

        $data['yearSemesterNumbers'] = [];
        if ($request->program_id) {
            $program = Program::select('type')->where('id', $request->program_id)->first();
            $data['yearSemesterNumbers'] = $this->getCourseTypeNumbers($program->type);
        }

        $data['subjects'] = Subject::query()
            ->filterBy(
                $request->only(['level_id', 'program_id', 'year_semester_number'])
            )
            ->latest('id')
            ->get();
        $data['filters'] = $request->all(['level_id', 'program_id', 'year_semester_number']);
        return view('pages.academics.subject.main.index', $data);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $data['levels'] = Level::all();

        return view('pages.academics.subject.main.create', $data);
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
        return view('pages.academics.subject.main.index', ['class' => $class, 'section' => $section], compact('subject'));
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Subject  $subject
     * @return \Illuminate\View\View
     */
    public function edit(Subject $subject)
    {
        $data['levels'] = Level::all();

        $data['programs'] = Program::where('level_id', $subject->level_id)->get();

        $data['yearSemesterNumbers'] = $this->getCourseTypeNumbers($subject->program->type);

        $data['subject'] = $subject;

        return view('pages.academics.subject.main.edit', $data);
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

    // public function assignToGroup(Request $request)
    // {
    //     $data = [];

    //     $data['subjects'] = [];

    //     $data['levels'] = Level::all();

    //     $data['programs'] = Program::where('level_id', $request->level_id)->get();
    //     $data['yearSemesters'] = YearSemester::where('program_id', $request->program_id)->get();
    //     $data['sections'] = Section::where('year_semester_id', $request->year_semester_id)->get();

    //     if ($request->level_id && $request->program_id && $request->year_semester_id && $request->section_id) {
    //         $data['subjects'] = Subject::where([
    //             'level_id' => $request->level_id,
    //             'program_id' => $request->program_id,
    //             'year_semester_id' => $request->year_semester_id
    //         ])->get();

    //         $data['section'] = Section::find($request->section_id);
    //     }

    //     $data['filters'] = $request->all(['level_id', 'program_id', 'year_semester_id', 'section_id']);

    //     return view('pages.academics.subject.assign-to-group', $data);
    // }

    // public function saveAssignToGroup(Request $request)
    // {
    //     $section = Section::find($request->section_id);
    //     $section->subjects()->sync($request->subject_id);

    //     return back()->withSuccess('Subject(s) assigned successfully!');
    // }
}
