<?php

namespace App\Http\Controllers\SuperAdmin\Certificate;

use Illuminate\View\View;
use App\Models\Certificate;
use App\Models\YearSemester;
use Illuminate\Http\Request;
use App\Services\BatchService;
use App\Services\ProgramService;
use App\Services\StudentService;
use App\Http\Controllers\Controller;
use App\Services\CertificateService;
use App\Services\AcademicYearService;
use App\Http\Requests\StoreCertificateRequest;

class CertificateController extends Controller
{
    private $variables = ['admission', 'roll', 'sname', 'email', 'level', 'program', 'yearSemester', 'phone', 'dob', 'fatherName', 'motherName'];

    public function __construct(
        protected CertificateService $certificate,
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
        $data['title'] = 'Certificate';
        $data['certificates'] = $this->certificate->getLatest();
        return view('pages.certificate.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create()
    {
        $data['title'] = 'Create Certificate';
        $data['variables'] = $this->variables;
        return view('pages.certificate.form', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreCertificateRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCertificateRequest $request)
    {
        $this->certificate->create($request);
        return to_route('certificate.index')->withSuccess('Certificate Created Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  mixed  $certificate
     * @return View
     */
    public function show(Certificate $certificate)
    {
        $data['certificate'] = $certificate->toArray();
        return view('pages.certificate.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  mixed  $certificate
     * @return View
     */
    public function edit(Certificate $certificate)
    {
        $data['title'] = 'Edit Certificate';
        $data['variables'] = $this->variables;
        $data['certificate'] = $certificate;
        return view('pages.certificate.form', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  StoreCertificateRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreCertificateRequest $request, $id)
    {
        $this->certificate->updateById($id, $request);
        return to_route('certificate.index')->withSuccess('Certificate Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->certificate->deleteById($id);
        return redirect()->back()->withSuccess('Certificate Deleted Successfully');
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

        $data['title'] = 'Generate Certificate';

        $data['certificates'] = $this->certificate->getLatest();

        $data['students'] = $this->certificate->getCertificateStudents($request);

        // $data['filter'] = $this->certificate->getFilterData($request);

        return view('pages.certificate.generate', $data);
    }

    public function generateFile(Request $request)
    {
        $data['certificates'] = $this->certificate->getStudentCertificates($request->certificate_id, $request->student_ids, $this->variables);

        return view('pages.certificate.file', $data);
    }
}
