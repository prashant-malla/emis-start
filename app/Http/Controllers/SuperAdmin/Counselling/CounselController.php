<?php

namespace App\Http\Controllers\SuperAdmin\Counselling;

use App\Exports\ExportCounsel;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCounselRequest;
use App\Http\Requests\UpdateCounselRequest;
use App\Models\AcademicYear;
use App\Models\Batch;
use App\Models\Counsel;
use App\Models\Level;
use App\Models\Program;
use App\Models\SchoolSetting;
use App\Models\Section;
use App\Models\Student;
use App\Models\YearSemester;
use App\Services\AcademicYearService;
use App\Services\BatchService;
use App\Services\ProgramService;
use App\Services\YearSemesterService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Maatwebsite\Excel\Facades\Excel;


class CounselController extends Controller
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
    //    public function export()
    //    {
    //        return Excel::download(new ExportCounsel(), 'counsels.xlsx');
    //    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data['academicYears'] = $this->academicYearService->getAll();
        $data['batches'] = $this->batchService->getAll();
        $data['programs'] = $this->programService->getAll();

        $defaultAcademicYearId = $data['academicYears']->where('is_active', 1)->first()->id ?? null;
        $request->merge(['academic_year_id' => $request->academic_year_id ?? $defaultAcademicYearId]);

        $data['yearSemesters'] = $request->filled('program_id') ? YearSemester::where('program_id', $request->program_id)->get() : collect([]);

        $data['counsellings'] = Counsel::query()
        ->filterBy($request->only(['academic_year_id', 'batch_id', 'level_id', 'program_id', 'year_semester_id']))
        ->latest()
        ->get();

        return view('pages.counsel.index', $data);
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
        $data['program'] = $this->programService->getAll();
        $data['yearSemester'] = DB::table('year_semesters')->select('id', 'name')->get();
        $data['section'] = Section::select('id', 'group_name')->get();
        $data['student'] = Student::select('id', 'sname')->get();

        $data['level'] = Level::select('id', 'name')->get();

        return view('pages.counsel.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCounselRequest $request)
    {
        $request['user_id'] = Auth::user()->id;
        Counsel::create($request->all());
        return redirect()->route('counsel.index')->with('success', 'Created Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Counsel  $counsel
     * @return \Illuminate\Http\Response
     */
    public function show(Counsel $counsel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Counsel  $counsel
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['counsel'] = Counsel::find($id);
        $data['academicYears'] = $this->academicYearService->getAll();
        $data['batches'] = $this->batchService->getAll();
        $data['level'] = DB::table('levels')->select('id', 'name')->get();
        $data['program'] = DB::table('programs')->where('level_id', $data['counsel']->level_id)->select('id', 'name')->get();
        $data['yearSemester'] = DB::table('year_semesters')->where('program_id', $data['counsel']->program_id)->select('id', 'name')->get();
        $data['section'] = DB::table('sections')->where('year_semester_id', $data['counsel']->year_semester_id)->select('id', 'group_name')->get();
        $data['student'] = DB::table('students')->where('section_id', $data['counsel']->section_id)->select('id', 'sname')->get();
        $data['yearSemesters'] = $this->yearSemesterService->getByProgramId($data['counsel']->program_id, [
            'academic_year_id' => $data['counsel']->yearSemester->academic_year_id,
            'batch_id' => $data['counsel']->yearSemester->batch_id
        ]);
        return view('pages.counsel.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Counsel  $counsel
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateCounselRequest $request, $id)
    {
        $request['user_id'] = Auth::user()->id;
        $counsel = Counsel::find($id);
        $counsel->update($request->all());
        return redirect()->route('counsel.index')->with('success', 'Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Counsel  $counsel
     * @return \Illuminate\Http\Response
     */
    public function destroy(Counsel $counsel, $id)
    {
        $counsel = Counsel::findOrFail($id);
        $counsel->delete();
        return redirect()->route('counsel.index')->with('success', 'Deleted successfully');
    }

    public function exportExcel()
    {
        return Excel::download(new ExportCounsel(Counsel::with('student')->get()), 'counsel-report.xlsx');
    }

    public function exportPdf()
    {
        $data['items'] = Counsel::with('student')->get();

        $data['title'] = 'Counsel Report';

        $data['settings'] = (new SchoolSetting())->first();

        $pdf = Pdf::loadView('pdf.counsel', $data);

        return
            $pdf
            ->download('counsel-report.pdf');
    }
}
