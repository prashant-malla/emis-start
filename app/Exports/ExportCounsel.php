<?php

namespace App\Exports;

use Illuminate\View\View;
use App\Models\SchoolSetting;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnWidths;

class ExportCounsel implements
    FromView,
    ShouldAutoSize,
    WithColumnWidths
{
    public function __construct(
        protected $items
    ) {
        /** */
    }


    public function columnWidths(): array
    {
        return [
            'A' => 50,
            'B' => 50,
            'C' => 50,
            'D' => 50,
            'E' => 50,
            'F' => 50,
            'G' => 50,
            'H' => 50,
        ];
    }
    /**
     * @return \Illuminate\Support\Collection
     */
    public function view() : View
    {
        $data['items'] = $this->items;

        $data['title'] = 'Counsel Report';

        $data['settings'] = (new SchoolSetting)->first();

        $data['schoolLogo'] = public_path(str_replace(config('app.url'), '', $data['settings']->logo_url));

        return view('exports.counsel', $data);
    }
}
