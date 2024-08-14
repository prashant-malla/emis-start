<?php

namespace App\Http\Controllers;

use App\Classes\SSR1Report;
use App\Exports\SSR1ReportExport;
use App\Models\SchoolSetting;
use App\Services\StaffDirectoryService;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class SSR1ReportController extends Controller
{
    public function __construct(
        protected StaffDirectoryService $staff,
        protected SSR1Report $ssr1Report,
        protected SchoolSetting $schoolSetting
    ) {
    }

    public function facultyMemberList()
    {
        $data['title'] = 'Faculty Member';

        $data['ssrs'] = $this->staff->getSSR1ReportsByDepartment('Faculty Member');

        $data['headings'] = $this->ssr1Report->headings();

        return
            view('pages.reports.report1', $data);
    }

    public function nonTeachingList()
    {
        $data['title'] = 'Non-Teaching';

        $data['ssrs'] = $this->staff->getSSR1ReportsByDepartment('Non-Teaching');

        $data['headings'] = $this->ssr1Report->headings();

        return
            view('pages.reports.report1', $data);
    }

    public function exportExcel($filterBy)
    {
        return
            Excel::download(
                new SSR1ReportExport(
                    $this
                        ->staff
                        ->getSSR1ReportsByDepartment($filterBy),
                    $filterBy
                ),
                'Report_1_' . $filterBy . '.xlsx'
            )
        ;
    }

    public function exportPdf($filterBy)
    {
        $data['title'] = 'Report 1' . ' / ' . $filterBy;

        $data['headings'] = $this->ssr1Report->headings();

        $data['settings'] = $this->schoolSetting->first();

        $data['ssrs'] = $this
            ->staff
            ->getSSR1ReportsByDepartment($filterBy);

        $pdf = Pdf::loadView('pdf.reports.ssr1', $data);

        return
            $pdf
                ->download($data['title'] . '.pdf');
    }
}
