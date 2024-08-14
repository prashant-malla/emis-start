<?php

namespace App\Http\Controllers\Teacher\Homework;

use Carbon\Carbon;
use App\Models\Homework;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\AssignmentRequest;
use App\Models\AcademicYear;
use App\Models\Batch;
use App\Models\YearSemester;
use App\Services\AcademicYearService;
use App\Services\BatchService;
use App\Services\ProgramService;
use App\Services\YearSemesterService;
use Illuminate\Support\Facades\View;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class HomeworkController extends Controller
{

    protected $base_route;
    protected $view_path;

    public function __construct(
        protected AcademicYearService $academicYearService,
        protected BatchService $batchService,
        protected ProgramService $programService,
        protected YearSemesterService $yearSemesterService
    ) {
        $this->base_route = 'homework';
        $this->view_path = 'pages.homework';

        View::share('base_route', $this->base_route);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data['academicYears'] = $this->academicYearService->getAll();
        $data['batches'] = $this->batchService->getAll();
        $data['programs'] = $this->programService->getAll();

        $request->merge(['academic_year_id' => $request->academic_year_id ?? $data['academicYears']->where('is_active', 1)->first()->id]);
        $data['yearSemesters'] = collect([]);
        if ($request->program_id) {
            $data['yearSemesters'] = YearSemester::where('program_id', $request->program_id)->get();
        }

        if (request()->session()->exists('redirectToTeacherDashboard')) {
            request()->session()->forget('redirectToTeacherDashboard');
        }

        $data['level'] = DB::table('levels')->select('id', 'name')->get();
        $data['program'] = DB::table('programs')->select('id', 'name')->get();
        $data['yearSemester'] = DB::table('year_semesters')->select('id', 'name')->get();
        $data['section'] = DB::table('sections')->select('id', 'group_name')->get();
        $data['subject'] = DB::table('subjects')->select('id', 'name')->get();
        $data['homework'] = Homework::where('teacher_id', Auth::guard('staff')->user()->id)
        ->filterBy($request->only(['academic_year_id', 'batch_id', 'program_id', 'year_semester_id']))
        ->latest('assign')
        ->withCount('homeworksubmission')
        ->get();
        return view('pages.homework.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['academicYears'] = AcademicYear::latest('start_date')->get();
        $data['batches'] = Batch::all();
        $data['level'] = DB::table('levels')->select('id', 'name')->get();
        $data['program'] = DB::table('programs')->select('id', 'name')->get();
        $data['yearSemester'] = DB::table('year_semesters')->select('id', 'name')->get();
        $data['section'] = DB::table('sections')->select('id', 'group_name')->get();
        $data['subject'] = DB::table('subjects')->select('id', 'name')->get();
        return view('pages.homework.create', $data);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreHomeworkRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AssignmentRequest $request)
    {
        $homework = new Homework();
        $homework->level_id = $request->level_id;
        $homework->program_id = $request->program_id;
        $homework->year_semester_id = $request->year_semester_id;
        $homework->section_id =  $request->section_id;
        $homework->subject_id = $request->subject_id;
        $homework->teacher_id = Auth::guard('staff')->user()->id;
        $homework->assign = $request->assign;
        $homework->submission = $request->submission;
        $homework->submission_time = new Carbon($request->submission_time);
        $homework->description = $request->description;
        $homework->save();

        if ($request->hasFile('report')) {
            foreach ($request->file('report') as $file) {
                $homework->addMedia($file)->toMediaCollection();
            }
        }

        return redirect()->route('teacher_homework.index')->with('success', 'Created successfully');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Homework  $homework
     * @return \Illuminate\Http\Response
     */
    public function edit(Homework $homework)
    {
        $data['homework'] = $homework;
        $data['academicYears'] = $this->academicYearService->getAll();
        $data['batches'] = $this->batchService->getAll();
        if (app('router')->getRoutes()->match(app('request')->create(url()->previous()))->getName() === 'teacher.dashboard') {
            request()->session()->put('redirectToTeacherDashboard', 'teacher.dashboard');
        };

        $data['level'] = DB::table('levels')->select('id', 'name')->get();
        $data['program'] = DB::table('programs')->where('level_id', $homework->level_id)->select('id', 'name')->get();
        $data['yearSemester'] = DB::table('year_semesters')->where('program_id', $homework->program_id)->select('id', 'name')->get();
        $data['section'] = DB::table('sections')->where('year_semester_id', $homework->year_semester_id)->select('id', 'group_name')->get();
        $data['subject'] = DB::table('subjects')->select('id', 'name')->get();

        $data['yearSemesters'] = $this->yearSemesterService->getByProgramId($data['homework']->program_id, [
            'academic_year_id' => $data['homework']->yearSemester->academic_year_id,
            'batch_id' => $data['homework']->yearSemester->batch_id
        ]);

        return view('pages/homework/edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateHomeworkRequest  $request
     * @param  \App\Models\Homework  $homework
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Homework $homework)
    {
        $homework->level_id = $request->level_id;
        $homework->program_id = $request->program_id;
        $homework->section_id = $request->section_id;
        $homework->subject_id = $request->subject_id;
        $homework->teacher_id = Auth::guard('staff')->user()->id;
        $homework->assign = $request->assign;
        $homework->submission = $request->submission;
        $homework->submission_time = new Carbon($request->submission_time);
        $homework->description = $request->description;
        $homework->update();

        if ($request->hasFile('report')) {
            $homework->clearMediaCollection();

            foreach ($request->file('report') as $file) {
                $homework->addMedia($file)->toMediaCollection();
            }
        }

        if (request()->session()->has('redirectToTeacherDashboard')) {
            request()->session()->forget('redirectToTeacherDashboard');

            return
                to_route('teacher.dashboard')
                ->with('success', 'Updated successfully');
        };

        return redirect()->route('teacher_homework.index')->with('success', 'Updated successfully');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Homework  $homework
     * @return \Illuminate\Http\Response
     */
    public function destroy(Homework $homework)
    {
        $homework->delete();

        if (app('router')->getRoutes()->match(app('request')->create(url()->previous()))->getName() === 'teacher.dashboard') {
            return back();
        };

        return redirect()->route('teacher_homework.index')->with('success', 'Deleted successfully');
    }


    public function homeworkSubmissionView(Homework $homework, $id)
    {
        $homework = Homework::findOrFail($id);

        return view('pages.homework.view')->with('homework', $homework);
    }

    public function removeFile(Request $request, Homework $homework)
    {
        $file = Media::where('file_name', $request->file)->first();

        $file->delete();
    }
}
