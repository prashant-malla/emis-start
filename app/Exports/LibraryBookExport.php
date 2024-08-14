<?php

namespace App\Exports;

use Illuminate\View\View;
use App\Models\SchoolSetting;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
// use Maatwebsite\Excel\Concerns\WithColumnWidths;
// use Maatwebsite\Excel\Concerns\WithDrawings;
// use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

class LibraryBookExport implements
    FromView,
    ShouldAutoSize
{
    public function __construct(
        protected $items
    ) {
        /** */
    }


    // public function columnWidths(): array
    // {
    //     return [
    //         'A' => 20,             
    //     ];
    // }

    // public function drawings()
    // {
    //     $drawings = [];

    //     foreach ($this->items as $i => $row) {
    //         if($row->image){
    //             $drawing = new Drawing();

    //             $imagePath = public_path(str_replace(config('app.url'), '', $row->image));
    //             $drawing->setPath($imagePath);
    //             $drawing->setHeight(100);
    //             $drawing->setCoordinates('A'.($i + 6));
    //             $drawing->setOffsetX(10);
    //             $drawing->setOffsetY(10);
    //         }

    //         $drawings[] = $drawing;
    //     }

    //     return $drawing;
    // }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function view() : View
    {
        $data['items'] = $this->items;

        $data['title'] = 'Library Book List';

        $data['settings'] = (new SchoolSetting)->first();
        $data['schoolLogo'] = public_path(str_replace(config('app.url'), '', $data['settings']->logo_url));

        return view('exports.library_book', $data);
    }
}
