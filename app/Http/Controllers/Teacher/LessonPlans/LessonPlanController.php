<?php

namespace App\Http\Controllers\Teacher\LessonPlans;

use App\Http\Controllers\Controller;
use App\Http\Requests\LessonPlanRequest;
use App\Models\Program;
use App\Models\LessonPlan;
use App\Models\Level;
use App\Models\TeacherAssign;
use App\Services\AcademicYearService;
use App\Services\BatchService;
use App\Services\YearSemesterService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class LessonPlanController extends Controller
{
    public function __construct(protected AcademicYearService $academicYearService, protected BatchService $batchService, protected YearSemesterService $yearSemesterService)
    {
        //    
    }
    
    protected $learningMethods = [
        'Direct Instruction',
        'Flipped Classrooms',
        'Kinaesthetic Learning',
        'Differentiated Instruction',
        'Inquiry-based Learning',
        'Expeditionary Learning',
        'Personalized Learning',
        'Game-based Learning'
    ];

    public function assignedPrograms($levelId)
    {
        $assignedProgramIds = TeacherAssign::where([
            'teacher_id' => Auth::guard('staff')->user()->id,
            'level_id' => $levelId,
        ])->pluck('program_id')->unique();

        return response()->json(Program::whereIn('id', $assignedProgramIds)->get());
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data['academicYears'] = $this->academicYearService->getAll();
        $data['batches'] = $this->batchService->getAll();

        // set initial academic year id
        $request->merge(['academic_year_id' => $request->academic_year_id ?? $data['academicYears']->where('is_active', 1)->first()->id]);

        $data['lessonPlans'] = LessonPlan::where('teacher_id', Auth::guard('staff')->user()->id)
        ->filterBy($request->only('academic_year_id', 'batch_id'))
        ->latest()->get();
        $data['lessonPlans']->load(['level', 'program', 'yearsemester', 'teacher', 'subject']);
        return view('pages.lesson_plans.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        $data['academicYears'] = $this->academicYearService->getAll();
        $data['batches'] = $this->batchService->getAll();
        $assignedLevelIds = TeacherAssign::where('teacher_id', Auth::guard('staff')->user()->id)->pluck('level_id')->unique();
        $data['levels'] = Level::whereIn('id', $assignedLevelIds)->get();
        $data['methods'] = $this->learningMethods;
        return view('pages.lesson_plans.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LessonPlanRequest $request)
    {
        $lessonPlan = new LessonPlan();
        $lessonPlan->unit = $request->unit;
        $lessonPlan->department = $request->department;
        $lessonPlan->topic = $request->topic;
        $lessonPlan->completion_days = $request->completion_days;
        $lessonPlan->learning_objective = $request->learning_objective;
        $lessonPlan->learning_tool = $request->learning_tool;
        $lessonPlan->evaluation_method = $request->evaluation_method;
        //Learning Methods array and input field.
        $selectedMethods = $request->input('methods', []);
        $otherMethod = $request->input('other_method');
        $data = ['methods' => $selectedMethods];
        // Include the "other_method" value if it's not empty

        if (!empty($otherMethod)) {
            $data['other_method'] = $otherMethod;
        }
        $lessonPlan->learning_method = json_encode($data);
        $lessonPlan->learning_outcome = $request->learning_outcome;
        $lessonPlan->level_id = $request->level_id;
        $lessonPlan->program_id = $request->program_id;
        $lessonPlan->year_semester_id = $request->year_semester_id;
        // $lessonPlan->section_id = $secId;
        $lessonPlan->subject_id = $request->subject_id;
        $lessonPlan->teacher_id = Auth::guard('staff')->user()->id;
        $lesson = $lessonPlan->save();

        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $lessonPlan->addMedia($file)->toMediaCollection();
            }
        }

        if ($lesson) {
            return redirect()->route('teacher_lesson-plan.index')->with('success', 'Created successfully');
        } else {
            return redirect()->route('teacher_lesson-plan.create')->with('error', 'Oops!! something went wrong');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\LessonPlan  $lessonPlan
     * @return \Illuminate\Http\Response
     */
    public function show(LessonPlan $lessonPlan, $id)
    {
        $lessonPlan = LessonPlan::findOrFail($id);
        return view('pages.lesson_plans.show', compact('lessonPlan'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\LessonPlan  $lessonPlan
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['lessonPlan'] = LessonPlan::findOrFail($id);

        $assignedLevelIds = TeacherAssign::where('teacher_id', Auth::guard('staff')->user()->id)->pluck('level_id')->unique();
        $data['academicYears'] = $this->academicYearService->getAll();
        $data['batches'] = $this->batchService->getAll();
        $data['levels'] = Level::whereIn('id', $assignedLevelIds)->get();
        $data['methods'] = $this->learningMethods;
        $data['yearSemesters'] = $this->yearSemesterService->getByProgramId($data['lessonPlan']->program_id, [
            'academic_year_id' => $data['lessonPlan']->yearSemester->academic_year_id,
            'batch_id' => $data['lessonPlan']->yearSemester->batch_id
        ]);
        return view('pages.lesson_plans.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\LessonPlan  $lessonPlan
     * @return \Illuminate\Http\Response
     */
    public function update(LessonPlanRequest $request)
    {
        $lessonPlan = LessonPlan::find($request->id);
        $lessonPlan->unit = $request->unit;
        $lessonPlan->department = $request->department;
        $lessonPlan->topic = $request->topic;
        $lessonPlan->completion_days = $request->completion_days;
        $lessonPlan->learning_objective = $request->learning_objective;
        $lessonPlan->learning_tool = $request->learning_tool;
        //Learning Methods array and input field.
        $selectedMethods = $request->input('methods', []);
        $otherMethod = $request->input('other_method');
        $data = ['methods' => $selectedMethods];
        // Include the "other_method" value if it's not empty

        if (!empty($otherMethod)) {
            $data['other_method'] = $otherMethod;
        }
        $lessonPlan->learning_method = json_encode($data);
        $lessonPlan->learning_outcome = $request->learning_outcome;
        $lessonPlan->level_id = $request->level_id;
        $lessonPlan->program_id = $request->program_id;
        $lessonPlan->year_semester_id = $request->year_semester_id;
        // $lessonPlan->section_id = $request->section_id;
        $lessonPlan->subject_id = $request->subject_id;
        $lessonPlan->teacher_id = Auth::guard('staff')->user()->id;
        $success = $lessonPlan->update();

        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $lessonPlan->addMedia($file)->toMediaCollection();
            }
        }

        if ($success) {
            return redirect()->route('teacher_lesson-plan.index')->with('success', 'Updated successfully');
        } else {
            return redirect()->route('teacher_lesson-plan.edit')->with('error', 'Oops!! something went wrong');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\LessonPlan  $lessonPlan
     * @return \Illuminate\Http\Response
     */
    public function destroy(LessonPlan $lessonPlan, $id)
    {
        $lessonPlan = LessonPlan::findOrFail($id);
        $lessonPlan->delete();
        return redirect()->route('teacher_lesson-plan.index')->with('success', 'Deleted successfully');
    }

    public function removeFile(Request $request, LessonPlan $lessonPlan)
    {
        $file = Media::where('file_name', $request->file)->first();

        $file->delete();
    }
}
