<?php

namespace App\Imports;

use App\Models\Level;
use App\Models\Program;
use App\Models\StudentInquiry;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class StudentInquiryImport implements ToModel, WithStartRow, SkipsEmptyRows
{
    public function startRow(): int
    {
        return 2;
    }

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new StudentInquiry([
            'name' => $row[1],
            'email' => $row[2],
            'admission' => $row[3],  // Assuming admission is at index 3
            'ethnicity' => $row[4],
            'level_id' => $row[5],
            'program_id' => $row[6],
            'bloodgroup' => $row[7],
            'gender' => $row[8],
            'dob' => $row[9],
            'phone' => $row[10],
            'caddress' => $row[11],
            'paddress' => $row[12],
            'caste' => $row[13],
            'religion' => $row[14],
        ]);
    }
}
