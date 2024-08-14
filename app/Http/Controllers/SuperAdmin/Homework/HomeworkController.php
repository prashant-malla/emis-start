<?php

namespace App\Http\Controllers\SuperAdmin\Homework;

use App\Exports\ExportHomework;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreHomeworkRequest;
use App\Models\AcademicYear;
use App\Models\Batch;
use App\Models\Counsel;
use App\Models\Homework;
use App\Models\HomeworkSubmission;
use App\Models\SchoolSetting;
use App\Models\Section;
use App\Models\StaffDirectory;
use App\Models\YearSemester;
use App\Services\AcademicYearService;
use App\Services\BatchService;
use App\Services\ProgramService;
use App\Services\YearSemesterService;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Maatwebsite\Excel\Facades\Excel;
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
            
        $data['homework'] = Homework::query()
        ->filterBy($request->only(['academic_year_id', 'batch_id', 'program_id', 'year_semester_id']))
        ->latest('assign')
        ->withCount('homeworksubmission')
        ->get();

        return view($this->view_path . '.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   $data['academicYears'] = AcademicYear::latest('start_date')->get();
        $data['batches'] = Batch::all();
        $data['level'] = DB::table('levels')->select('id', 'name')->get();
        $data['program'] = DB::table('programs')->select('id', 'name')->get();
        $data['yearSemester'] = DB::table('year_semesters')->select('id', 'name')->get();
        $data['section'] = Section::select('id', 'group_name')->get();
        $data['subject'] = DB::table('subjects')->select('id', 'name')->get();
        $data['staffs'] = new StaffDirectory();
        $data['teacher'] = $data['staffs']->whereHas('role', function ($query) {
            $query->where('role', 'Teacher');
        })->get();
        return view('pages.homework.create', $data);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreHomeworkRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreHomeworkRequest $request)
    {
        $validated = $request->validated();
        $homework = Homework::create($validated);

        if ($request->hasFile('report')) {
            foreach ($request->file('report') as $file) {
                $homework->addMedia($file)->toMediaCollection();
            }
        }
        return redirect()->route('homework.index')->with('success', 'Created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Homework  $homework
     * @return \Illuminate\Http\Response
     */
    /*   public function homeworkDropDownShow(Homework $homework)
    {
        $section = DB::table('sections')->select('id', 'section_name')->get();
        $class = DB::table('eclasses')->select('id', 'class_name')->get();
        $subject = DB::table('subjects')->select('id')->get();
        $teachers = new StaffDirectory();
        $teacher = $staffs->whereHas('role', function ($query){
            $query->where('name', 'Teacher');
        });
        $homework = Homework::all();
        return view ('pages.homework.index', ['class'=> $class, 'section'=>$section, 'subject'=>$subject, 'teacher'=>$teacher->get()],compact('homework'));
    }*/

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Homework  $homework
     * @return \Illuminate\Http\Response
     */
    public function submittedHomeworkView($id)
    {
        $user = DB::table('users')->select('id', 'name')->get();
        $homework = Homework::findorFail($id);
        return view('pages/homework/view', ['user' => $user], compact('homework'));
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Homework  $homework
     * @return \Illuminate\Http\Response
     */
    public function submissionDetailView($id)
    {
        $user = DB::table('users')->select('id', 'name')->get();
        $homeworkSub = HomeworkSubmission::findorFail($id);
        return view('pages/homework/submissionDetails', ['user' => $user], compact('homeworkSub'));
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Homework  $homework
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['homework'] = Homework::find($id);
        $data['academicYears'] = $this->academicYearService->getAll();
        $data['batches'] = $this->batchService->getAll();
        $data['level'] = DB::table('levels')->select('id', 'name')->get();
        $data['program'] = DB::table('programs')->where('level_id', $data['homework']->level_id)->select('id', 'name')->get();
        $data['yearSemester'] = DB::table('year_semesters')->where('program_id', $data['homework']->program_id)->select('id', 'name')->get();
        $data['section'] = DB::table('sections')->where('year_semester_id', $data['homework']->year_semester_id)->select('id', 'group_name')->get();
        $data['subject'] = DB::table('subjects')->select('id', 'name')->get();
        $data['staffs'] = new StaffDirectory();
        $data['teacher'] = $data['staffs']->whereHas('role', function ($query) {
            $query->where('role', 'Teacher');
        })->get();

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
    public function update(StoreHomeworkRequest $request, $id)
    {
        $homework = Homework::findorFail($id);
        $homework->update($request->all());

        if ($request->hasFile('report')) {
            $homework->clearMediaCollection();

            foreach ($request->file('report') as $file) {
                $homework->addMedia($file)->toMediaCollection();
            }
        }

        return redirect()->route('homework.index')->with('success', 'Updated successfully');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Homework  $homework
     * @return \Illuminate\Http\Response
     */
    public function destroy(Homework $homework, $id)
    {
        $homework = Homework::findOrFail($id);
        $homework->delete();
        return redirect()->route('homework.index')->with('success', 'Deleted successfully');
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
    public function exportExcel()
    {
        return Excel::download(new ExportHomework(Homework::get()), 'assignment-report.xlsx');
    }

    public function exportPdf()
    {
        $data['items'] = Homework::get();

        $data['title'] = 'Assignment Report';

        $data['settings'] = (new SchoolSetting())->first();

        $pdf = Pdf::loadView('pdf.homework', $data);

        return
            $pdf
            ->download('assignment-report.pdf');
    }
}
