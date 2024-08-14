<?php

namespace App\Imports;

use App\Models\Department;
use App\Models\Designation;
use App\Models\Role;
use App\Models\Section;
use App\Models\StaffDirectory;
use App\Models\SubDepartment;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ImportStaffDirectory implements WithMultipleSheets
{
    public function sheets(): array
    {
        return [
            0 => new StaffSheetImport()
        ];
    }

//    public function title(): string
//    {
//        return 'staff_profile_teaching';
//    }
    /**
     * @return int
     */
//    public function startRow(): int
//    {
//        return 3;
//    }

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
//    public function model(array $row)
//    {
//        dd($row);
//        return new StaffDirectory([
//            'password' => Hash::make('password'),
//            'staff_id' => $row[0],
//            'name' => $row[1],
//            'role_id' => Role::where('role', $row[2])->firstOrFail()->id,
//            'department_id' => Department::where('department', $row[3])->firstOrFail()->id,
//            'sub_department_id' => SubDepartment::where('name', $row[4])->firstOrFail()->id,
//            'designation_id' => Designation::where('title', $row[5])->firstOrFail()->id,
//            'gender' => $row[6],
//            'phone' => $row[7],
//            'email' => $row[8],
//            'dob' => date('Y-m-d', strtotime($row[9])),
//            'marital_status' => $row[10],
//            'permanent_address' =>$row[11],
//            'current_address' =>$row[12],
//            'qualification' =>$row[13],
//            'work_experience' => $row[14],
//            'father_name' => $row[15],
//            'mother_name' => $row[16],
//            'emergency_phone' => $row[17],
//            'date_of_joining' => Carbon::now(),
//        ]);
//    }
}
