<?php

namespace Database\Seeders;

use App\Models\Designation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DesignationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $designations = [
            [
                'department_id' => '1',
                'title' => 'Professor'
            ],
            [
                'department_id' => '1',
                'title' => 'C E O'
            ],
            [
                'department_id' => '1',
                'title' => 'Campus Chief'
            ],
            [
                'department_id' => '1',
                'title' => 'Educational Coordinator'
            ],
            [
                'department_id' => '1',
                'title' => 'Reader'
            ],
            [
                'department_id' => '1',
                'title' => 'Lecturer'
            ],
            [
                'department_id' => '1',
                'title' => 'Asst. Lecturer'
            ],
            [
                'department_id' => '1',
                'title' => 'Instructor'
            ],
            [
                'department_id' => '1',
                'title' => 'Others'
            ],
            [
                'department_id' => '2',
                'sub_department_id' => '1',
                'title' => 'First Class'
            ],
            [
                'department_id' => '2',
                'sub_department_id' => '1',
                'title' => 'Second Class'
            ],
            [
                'department_id' => '2',
                'sub_department_id' => '1',
                'title' => 'Third Class'
            ],
            [
                'department_id' => '2',
                'sub_department_id' => '1',
                'title' => 'Assistant'
            ],
            [
                'department_id' => '2',
                'sub_department_id' => '2',
                'title' => 'First Class'
            ],
            [
                'department_id' => '2',
                'sub_department_id' => '2',
                'title' => 'Second Class'
            ],
            [
                'department_id' => '2',
                'sub_department_id' => '2',
                'title' => 'Third Class'
            ],
            [
                'department_id' => '2',
                'sub_department_id' => '2',
                'title' => 'Assistant'
            ],
            [
                'department_id' => '2',
                'sub_department_id' => '3',
                'title' => 'Driver'
            ],
            [
                'department_id' => '2',
                'sub_department_id' => '3',
                'title' => 'Peon'
            ],
            [
                'department_id' => '2',
                'sub_department_id' => '3',
                'title' => 'Others'
            ],
            [
                'department_id' => '2',
                'sub_department_id' => '3',
                'title' => 'Account Officer'
            ],
            [
                'department_id' => '2',
                'sub_department_id' => '3',
                'title' => 'Admin Assistance'
            ],
            [
                'department_id' => '2',
                'sub_department_id' => '3',
                'title' => 'Librarian'
            ],
            [
                'department_id' => '2',
                'sub_department_id' => '3',
                'title' => 'Office Assistant'
            ],
            [
                'department_id' => '2',
                'sub_department_id' => '3',
                'title' => 'Security Guard'
            ],
        ];

        foreach ($designations as $designation) {
            Designation::create($designation);
        }
    }
}
