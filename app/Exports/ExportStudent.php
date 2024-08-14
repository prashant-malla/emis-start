<?php

namespace App\Exports;

use App\Models\SchoolSetting;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ExportStudent implements FromView, ShouldAutoSize
{
    public function __construct(
        protected $students
    ) {
    }

    public function view(): View
    {
        $data['students'] = $this->students;

        $data['title'] = 'Student List';
        $data['headings'] = $this->headings();
        $data['settings'] = (new SchoolSetting())->first();
        $data['schoolLogo'] = public_path(str_replace(config('app.url'), '', $data['settings']->logo_url));

        return view('exports.students.list', $data);
    }

    public function headings()
    {
        return [
            'sname' => 'Name',
            'level.name' => 'Level',
            'program.name' => 'Program',
            'year_semester.name' => 'Year/Semester',
            'section.name' => 'Group',
            'roll' => 'Roll No.',
            'gender' => 'Gender',
            'phone' => 'Phone Number',
            'email' => 'Email',
        ];
    }
}
