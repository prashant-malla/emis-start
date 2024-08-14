<?php

namespace App\Http\Controllers\SuperAdmin\IdCard;

use App\Models\IdCard;
use Illuminate\View\View;
use App\Models\YearSemester;
use Illuminate\Http\Request;
use App\Services\BatchService;
use App\Services\IdCardService;
use App\Services\ProgramService;
use App\Services\StudentService;
use App\Http\Controllers\Controller;
use App\Services\AcademicYearService;
use App\Http\Requests\StoreIdCardRequest;

class IdCardController extends Controller
{
    public function __construct(
        protected IdCardService $idcard,
        protected StudentService $student,
        protected AcademicYearService $academicYearService,
        protected BatchService $batchService,
        protected ProgramService $programService,
    ) {
    }

    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index()
    {
        $data['title'] = 'ID Card';

        $data['idcards'] = $this->idcard->getLatest();

        return
            view('pages.id_card.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create()
    {
        $data['title'] = 'Create Id Card';

        $data['fields'] = $this->idcard->fields;

        $data['themes'] = $this->idcard->themes;

        return
            view('pages.id_card.form', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreIdCardRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreIdCardRequest $request)
    {
        $this->idcard->create($request);

        return
            to_route('idcard.index')->withSuccess('Id Card Created Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  mixed  $idcard
     * @return View
     */
    public function show(IdCard $idcard)
    {
        $data['fields'] = $this->idcard->fields;

        $data['idcard'] = $this->idcard->replaceVars($idcard);

        $data['students'] = $this->idcard->updateStudentFields($this->student->getLatest(1));

        if (count($data['students']) === 0) {
            return
                redirect()->back()->withError('You do not have any student to preview ID Card');
        }

        return
            view('pages.id_card.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  mixed  $idcard
     * @return View
     */
    public function edit(IdCard $idcard)
    {
        $data['title'] = 'Edit Id Card';

        $data['fields'] = $this->idcard->fields;

        $data['themes'] = $this->idcard->themes;

        $data['idcard'] = $idcard;

        return
            view('pages.id_card.form', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  StoreIdCardRequest  $request
     * @param  mixed  $idcard
     * @return \Illuminate\Http\Response
     */
    public function update(StoreIdCardRequest $request, IdCard $idcard)
    {
        $this->idcard->updateById($idcard->id, $request);

        return
            to_route('idcard.index')->withSuccess('Id Card Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  mixed  $idcard
     * @return \Illuminate\Http\Response
     */
    public function destroy(IdCard $idcard)
    {
        $this->idcard->deleteById($idcard->id);

        return
            redirect()->back()->withSuccess('Id Card Deleted Successfully');
    }

    public function generate(Request $request)
    {
        $data['academicYears'] = $this->academicYearService->getAll();
        $data['batches'] = $this->batchService->getAll();
        $data['programs'] = $this->programService->getAll();

        // set initial academic year id
        $request->merge(['academic_year_id' => $request->academic_year_id ?? $data['academicYears']->where('is_active', 1)->first()->id]);

        if ($request->academic_year_id && $request->batch_id && $request->program_id) {
            $data['yearSemesters'] = YearSemester::filterBy($request->only(['academic_year_id', 'batch_id', 'program_id']))->get();
        }
        
        $data['title'] = 'Generate Id Card';

        $data['idcards'] = $this->idcard->getLatest();

        // $data['filter'] = $this->idcard->getFilterData($request);

        $data['students'] = $this->idcard->getIdCardStudents($request);

        return
            view('pages.id_card.generate', $data);
    }

    public function generateFile(Request $request)
    {
        $data['fields'] = $this->idcard->fields;

        $data['paperSize'] = $request->paper_size;

        $data['idcard'] = $this->idcard->replaceVars(
            $this->idcard->getById($request->idcard_id)
        );;

        $data['students'] = $this->idcard->updateStudentFields(
            $this->student->getByIds(explode(',', $request->student_ids))
        );

        return
            view('pages.id_card.file', $data);
    }
}
