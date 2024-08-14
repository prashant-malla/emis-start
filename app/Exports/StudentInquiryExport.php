<?php

namespace App\Exports;

use App\Models\StudentInquiry;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class StudentInquiryExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    public function headings(): array
    {
        return [
            '#',
            'Full Name',
            'Email',
            'Admission',
            'Ethnicity',
            'Level',
            'Program',
            'Blood Group',
            'Bender',
            'DOB',
            'Phone',
            'Current address',
            'Permanent address',
            'Caste',
            'Religion',
        ];
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return StudentInquiry::select(
            'id',
            'name',
            'email',
            'admission',
            'ethnicity',
            'level_id',
            'program_id',
            'bloodgroup',
            'gender',
            'dob',
            'phone',
            'caddress',
            'paddress',
            'caste',
            'religion',
        )->get();
    }
}
