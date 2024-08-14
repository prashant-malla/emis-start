<?php

namespace Database\Seeders;

use App\Models\ExamType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ExamTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $examTypes = [
            [
                'exam_type' => "GPA",
            ],
            [
                'exam_type' => "Percentage"
            ]
        ];

        foreach ($examTypes as $examType) {
            ExamType::create($examType);
        }
    }
}
