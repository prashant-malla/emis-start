<?php

namespace App\Exports;

use Illuminate\View\View;
use App\Models\SchoolSetting;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class StakeHolderExport implements
    FromView,
    ShouldAutoSize
{
    public function __construct(
        protected $items
    ) {
        /** */
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function view() : View
    {
        $data['items'] = $this->items;

        $data['title'] = 'Stakeholder Report';

        $data['settings'] = (new SchoolSetting)->first();
        $data['schoolLogo'] = public_path(str_replace(config('app.url'), '', $data['settings']->logo_url));

        return view('exports.stakeholder', $data);
    }
}
