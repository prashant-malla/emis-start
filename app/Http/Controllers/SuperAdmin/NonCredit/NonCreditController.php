<?php

namespace App\Http\Controllers\SuperAdmin\NonCredit;

use App\Models\Level;
use App\Models\Program;
use App\Models\NonCredit;
use App\Models\YearSemester;
use Illuminate\Http\Request;
use App\Services\BatchService;
use App\Services\NonCreditService;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Services\AcademicYearService;
use App\Http\Requests\StoreNonCreditRequest;
use App\Http\Requests\UpdateNonCreditRequest;
use App\Services\ProgramService;
use App\Services\YearSemesterService;
use Illuminate\Support\Facades\View;

class NonCreditController extends Controller
{
    protected $base_route;
    protected $view_path;

    public function __construct(
        private NonCreditService $nonCredit,
        protected AcademicYearService $academicYearService,
        protected BatchService $batchService,
        protected ProgramService $programService,
        protected YearSemesterService $yearSemesterService
    ) {
        $this->base_route = 'noncredit';
        $this->view_path = 'pages.noncredit';

        View::share('base_route', $this->base_route);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        $data['academicYears'] = $this->academicYearService->getAll();
        $data['batches'] = $this->batchService->getAll();
        $data['programs'] = $this->programService->getAll();

        $data['yearSemesters'] = collect([]);
        if ($request->program_id) {
            $data['yearSemesters'] = YearSemester::where('program_id', $request->program_id)->get();
        }

        $request->merge(['academic_year_id' => $request->academic_year_id ?? $data['academicYears']->first()->id]);

        $data['nonCredits'] = NonCredit::query()
            ->filterBy($request->only('academic_year_id', 'batch_id','level_id','program_id', 'year_semester_id'))
            ->latest('id')
            ->get();

        return view('pages.noncredit.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        $data['academicYears'] = $this->academicYearService->getAll();
        $data['batches'] = $this->batchService->getAll();
        $data['level'] = Level::all();
        $data['program'] = Program::all();
        $data['yearSemester'] = YearSemester::all();
        return view('pages.noncredit.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreNonCreditRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(
        StoreNonCreditRequest $request
    ) {
        $this
            ->nonCredit
            ->create($request);

        return
            to_route('noncredit.index')
            ->withSuccess('Non-Credit Course Created successfully');
    }

    /**
     * show non-credit
     *
     * @param  mixed $nonCredit
     * @return View
     */
    public function show(NonCredit $nonCredit)
    {
        $data['nonCredit'] = $nonCredit;

        $nonCredit
            ->load('yearSemester', 'program', 'group', 'level');

        return
            view('pages.noncredit.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(NonCredit $nonCredit)
    {
        $data['academicYears'] = $this->academicYearService->getAll();
        $data['batches'] = $this->batchService->getAll();
        $data['program'] = $this->programService->getAll();
        $data['nonCredit'] = $nonCredit;
        $data['level'] = DB::table('levels')->select('id', 'name')->get();
        $data['section'] = DB::table('sections')->where('year_semester_id', $nonCredit->year_semester_id)->select('id', 'group_name')->get();

        $data['yearSemester'] = $this->yearSemesterService->getByProgramId($data['nonCredit']->program_id, [
            'academic_year_id' => $data['nonCredit']->yearSemester->academic_year_id,
            'batch_id' => $data['nonCredit']->yearSemester->batch_id
        ]);

        return view('pages.noncredit.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\UpdateNonCreditReques  $request
     * @param  \App\Models\NonCredit  $student
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateNonCreditRequest $request, NonCredit $nonCredit)
    {
        $nonCredit->fill($request->all());
        $nonCredit->update();

        if ($request->file('qr')) {
            $nonCredit->clearMediaCollection();
            $nonCredit->addMedia($request->file('qr'))->toMediaCollection();
        }

        return to_route('noncredit.index')->with('success', 'Updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\NonCredit  $student
     * @return \Illuminate\Http\Response
     */
    public function destroy(NonCredit $noncredit, $id)
    {
        $noncredit = NonCredit::findOrFail($id);
        $noncredit->delete();
        return redirect()->back()->with('success', 'Deleted successfully');
    }
}
