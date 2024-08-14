<?php

namespace App\Exports;

use Illuminate\View\View;
use App\Models\SchoolSetting;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnWidths;

class LessonPlanExport implements
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
            'J' => 50,            
            'K' => 50,            
            'L' => 50,            
        ];
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function view() : View
    {
        $data['items'] = $this->items;

        $data['title'] = 'Lesson Plan Report';

        $data['settings'] = (new SchoolSetting)->first();
        $data['schoolLogo'] = public_path(str_replace(config('app.url'), '', $data['settings']->logo_url));

        return view('exports.lesson_plan', $data);
    }
}
