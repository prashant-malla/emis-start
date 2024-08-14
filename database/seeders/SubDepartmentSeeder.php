<?php

namespace Database\Seeders;

use App\Models\SubDepartment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubDepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sub_departments = [
            [
                'department_id' => '2',
                'name' => 'Administrative',
            ],
            [
                'department_id' => '2',
                'name' => 'Technical',
            ],
            [
                'department_id' => '2',
                'name' => 'Non Technical',
            ],
        ];

        foreach ($sub_departments as $sub_department) {
            SubDepartment::create($sub_department);
        }
    }
}
