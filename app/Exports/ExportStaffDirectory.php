<?php

namespace App\Exports;

use App\Models\StaffDirectory;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;


class ExportStaffDirectory implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return StaffDirectory::all();
    }

//    public function map($user): array
//    {
//        return [
//            $user->name,
//            $user->email,
//            Date::dateTimeToExcel($user->created_at),
//        ];
//    }

    public function headings(): array
    {
        return [
            'S.N', 'Staff ID',
            'Name', 'Email', 'Phone Number', 'Gender', 'Date Of Birth', 'Marital Status', 'Permanent Address', 'Current Address',
            'Qualification', 'Work Experience', 'Father Name', 'Mother Name', 'Emergency Contact', 'Role', 'Department', 'Sub Department',
            'Designation', 'Date of Joining', 'Note', 'Pan Number', 'Service Type', 'Work Shift', 'Basic Salary', 'Bank Name', 'Account Name',
            'Account Number', 'Branch Name', 'Facebook Link', 'Instagram Link', 'Twitter Link', 'Linkedin Link', 'Status', 'Level', 'Program',
            'Year/Semester', 'Section', 'Contract Type'
        ];
    }
}
