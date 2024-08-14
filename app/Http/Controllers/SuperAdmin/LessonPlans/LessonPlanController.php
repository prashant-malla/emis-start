<?php

namespace App\Http\Controllers\SuperAdmin\LessonPlans;

use App\Models\LessonPlan;
use Illuminate\Http\Request;
use App\Models\SchoolSetting;
use App\Services\BatchService;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\LessonPlanExport;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Services\AcademicYearService;

class LessonPlanController extends Controller
{
    public function __construct(protected AcademicYearService $academicYearService, protected BatchService $batchService)
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
        $data['academicYears'] = $this->academicYearService->getAll();
        $data['batches'] = $this->batchService->getAll();

        // set initial academic year id
        $request->merge(['academic_year_id' => $request->academic_year_id ?? $data['academicYears']->where('is_active', 1)->first()?->id]);

        $data['lessonPlans'] = LessonPlan::filterBy($request->only('academic_year_id', 'batch_id'))->get();
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
        /*        $level = DB::table('levels')->select('id', 'name')->get();
        $program = DB::table('programs')->select('id', 'name')->get();
        $yearSemester = DB::table('year_semesters')->select('id', 'name')->get();
        $methods = array('Direct Instruction','Flipped Classrooms','Kinaesthetic Learning','Differentiated Instruction',
            'Inquiry-based Learning','Expeditionary Learning', 'Personalized Learning', 'Game-based Learning');
        return view('pages.lesson_plans.create', ['level' => $level, 'program' => $program, 'yearSemester'=> $yearSemester],compact('methods'));*/
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //        $lessonPlan = new LessonPlan();
        //        $lessonPlan->unit = $request->unit;
        //        $lessonPlan->department = $request->department;
        //        $lessonPlan->topic = $request->topic;
        //        $lessonPlan->completion_days = $request->completion_days;
        //        $lessonPlan->learning_objective = $request->learning_objective;
        //        $lessonPlan->learning_tool = $request->learning_tool;
        //        $lessonPlan->learning_method= json_encode($request->methods);
        //        $lessonPlan->learning_outcome = $request->learning_outcome;
        //        $lessonPlan->level_id = $request->level_id;
        //        $lessonPlan->program_id = $request->program_id;
        //        $lessonPlan->year_semester_id = $request->year_semester_id;
        //        if($lessonPlan->save()){
        //            return redirect()->route('lesson-plan.index')->with('success', 'Created successfully');
        //        }else{
        //            return redirect()->route('lesson-plan.create')->with('error', 'Oops!! something went wrong');
        //        }
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
    public function edit(LessonPlan $lessonPlan, $id)
    {
        //        $level = DB::table('levels')->select('id', 'name')->get();
        //        $program = DB::table('programs')->select('id', 'name')->get();
        //        $yearSemester = DB::table('year_semesters')->select('id', 'name')->get();
        //        $methods = array('Direct Instruction','Flipped Classrooms','Kinaesthetic Learning','Differentiated Instruction',
        //            'Inquiry-based Learning','Expeditionary Learning', 'Personalized Learning', 'Game-based Learning');
        //        $lessonPlan= LessonPlan::find($id);
        //        return view('pages.lesson_plans..edit', ['level' => $level, 'program' => $program, 'yearSemester'=> $yearSemester,'lessonPlan' => $lessonPlan], compact('methods'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\LessonPlan  $lessonPlan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, LessonPlan $lessonPlan)
    {
        //        $lessonPlan = LessonPlan::find($request->id);
        //        $lessonPlan->unit = $request->unit;
        //        $lessonPlan->department = $request->department;
        //        $lessonPlan->topic = $request->topic;
        //        $lessonPlan->completion_days = $request->completion_days;
        //        $lessonPlan->learning_objective = $request->learning_objective;
        //        $lessonPlan->learning_tool = $request->learning_tool;
        //        $lessonPlan->learning_method= json_encode($request->methods);
        //        $lessonPlan->learning_outcome = $request->learning_outcome;
        //        $lessonPlan->level_id = $request->level_id;
        //        $lessonPlan->program_id = $request->program_id;
        //        $lessonPlan->year_semester_id = $request->year_semester_id;
        //        if($lessonPlan->save()){
        //            return redirect()->route('lesson-plan.index')->with('success', 'Updated successfully');
        //        }else{
        //            return redirect()->route('lesson-plan.update')->with('error', 'Oops!! something went wrong');
        //        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\LessonPlan  $lessonPlan
     * @return \Illuminate\Http\Response
     */
    public function destroy(LessonPlan $lessonPlan, $id)
    {
        //        $lessonPlan = LessonPlan::findOrFail($id);
        //        $lessonPlan->delete();
        //        return redirect()->route('lesson-plan.index')->with('success', 'Deleted successfully');
    }

    public function exportExcel()
    {
        return Excel::download(new LessonPlanExport(LessonPlan::get()), 'lesson-plan.xlsx');
    }

    public function exportPdf()
    {
        $data['items'] = LessonPlan::get();

        $data['title'] = 'Lesson Plan Report';

        $data['settings'] = (new SchoolSetting())->first();

        $pdf = Pdf::loadView('pdf.lesson_plan', $data);

        return
            $pdf
            ->download('lesson-plan.pdf');
    }
}
