<?php

namespace App\Http\Controllers;

use App\Models\YearSemester;
use Illuminate\Http\Request;
use App\Models\SchoolSetting;
use App\Exports\Report2Export;
use App\Services\BatchService;
use App\Services\LevelService;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Services\ProgramService;
use Maatwebsite\Excel\Facades\Excel;
use App\Services\AcademicYearService;

class Report2Controller extends Controller
{
    public function __construct(
        protected AcademicYearService $academicYearService,
        protected BatchService $batchService,
        protected LevelService $levelService,
        protected ProgramService $programService
    ) {
        /** */
    }

    public function list(Request $request)
    {
        $data['academicYears'] = $this->academicYearService->getAll();
        $data['batches'] = $this->batchService->getAll();
        $data['levels'] = $this->levelService->getLevels();
        $data['programs'] = $this->programService->getAll();

        // set initial academic year id
        $request->merge(['academic_year_id' => $request->academic_year_id ?? $data['academicYears']->where('is_active', 1)->first()->id]);

        if ($request->academic_year_id && $request->batch_id && $request->program_id) {
            $data['yearSemesters'] = YearSemester::filterBy($request->only(['academic_year_id', 'batch_id', 'program_id']))->get();
        }
        
        $data['title'] = 'Academic Program Wise Student Enrollment ';

        return view('pages.reports.report2', $data);
    }

    public function exportExcel()
    {
        return Excel::download(new Report2Export($this->levelService->getLevels()), 'Report-2.xlsx');
    }

    public function exportPdf()
    {
        $data['items'] = $data['items'] = $this->levelService->getLevels();

        $data['title'] = 'Academic Program Wise Student Enrollment ';

        $data['settings'] = (new SchoolSetting())->first();

        $pdf = Pdf::loadView('pdf.reports.report2', $data);

        return
            $pdf
            ->download('report-2.pdf');
    }
}
