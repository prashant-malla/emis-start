<?php

namespace App\Exports;

use App\Classes\SSR1Report;
use App\Models\SchoolSetting;
use Illuminate\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class SSR1ReportExport implements FromView, ShouldAutoSize
{
    protected $staffDirectories;
    protected $filterBy;

    public function __construct(
        $staffDirectories,
        $filterBy
    ) {
        $this->staffDirectories = $staffDirectories;
        $this->filterBy = $filterBy;
    }

    public function view(): View
    {
        $data['ssrs'] = $this->staffDirectories;
        $data['title'] = 'Report 1 - ' . $this->filterBy;
        $data['headings'] = (new SSR1Report)->headings();
        $data['settings'] = (new SchoolSetting)->first();
        $data['schoolLogo'] = public_path(str_replace(config('app.url'), '', $data['settings']->logo_url));

        return view('exports.reports.ssr1', $data);
    }
}
