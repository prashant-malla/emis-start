<?php

namespace App\Http\Controllers\Teacher\Counselling;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCounselRequest;
use App\Http\Requests\UpdateCounselRequest;
use App\Models\Counsel;
use App\Models\Level;
use App\Models\Section;
use App\Models\Student;
use App\Models\YearSemester;
use App\Services\AcademicYearService;
use App\Services\BatchService;
use App\Services\ProgramService;
use App\Services\YearSemesterService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;

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

        $data['counsellings'] = Counsel::where('staff_id', Auth::guard('staff')
        ->user()->id)
        ->filterBy($request->only(['academic_year_id', 'batch_id', 'program_id', 'year_semester_id']))
        ->latest()
        ->get();
        return view('pages.counsel.index',$data);
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
        $request['staff_id'] = Auth::guard('staff')->user()->id;
        Counsel::create($request->all());
        return redirect()->route('teacher_counsel.index')->with('success', 'Created Successfully');
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
        $data['counsel'] = Counsel::findOrFail($id);
        $data['academicYears'] = $this->academicYearService->getAll();
        $data['batches'] = $this->batchService->getAll();
        $data['level'] = DB::table('levels')->select('id', 'name')->get();
        $data['program'] = DB::table('programs')->select('id', 'name')->where('level_id', $data['counsel']->level_id)->get();
        $data['yearSemester'] = DB::table('year_semesters')->select('id', 'name')->where('program_id', $data['counsel']->program_id)->get();
        $data['section'] = DB::table('sections')->select('id', 'group_name')->where('year_semester_id', $data['counsel']->year_semester_id)->get();
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
        $counsel = Counsel::find($id);
        $request['staff_id'] = Auth::guard('staff')->user()->id;

        $counsel->update($request->all());

        return redirect()->route('teacher_counsel.index')->with('success', 'Updated Successfully');
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
        return redirect()->route('teacher_counsel.index')->with('success', 'Deleted successfully');
    }
}
