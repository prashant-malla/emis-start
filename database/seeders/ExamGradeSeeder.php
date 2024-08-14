<?php

namespace Database\Seeders;

use App\Models\ExamGrade;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ExamGradeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $grades = [
            [
                'exam_type_id' => '1',
                'grade_name'=>'A+',
                'percentage_from'=>'90',
                'percentage_to'=>'100',
                'grade_point'=>'4.0',
                'remarks' => 'Outstanding'
            ],
            [
                'exam_type_id' => '1',
                'grade_name'=>'A',
                'percentage_from'=>'80',
                'percentage_to'=>'90',
                'grade_point'=>'3.6',
                'remarks' => 'Excellent'
            ],
            [
                'exam_type_id' => '1',
                'grade_name'=>'B+',
                'percentage_from'=>'70',
                'percentage_to'=>'80',
                'grade_point'=>'3.2',
                'remarks' => 'Very Good'
            ],
            [
                'exam_type_id' => '1',
                'grade_name'=>'B',
                'percentage_from'=>'60',
                'percentage_to'=>'70',
                'grade_point'=>'2.8',
                'remarks' => 'Good'
            ],
            [
                'exam_type_id' => '1',
                'grade_name'=>'C+',
                'percentage_from'=>'50',
                'percentage_to'=>'60',
                'grade_point'=>'2.4',
                'remarks' => 'Satisfactory'
            ],
            [
                'exam_type_id' => '1',
                'grade_name'=>'C',
                'percentage_from'=>'40',
                'percentage_to'=>'50',
                'grade_point'=>'2',
                'remarks' => 'Acceptable'
            ],
            [
                'exam_type_id' => '1',
                'grade_name'=>'D+',
                'percentage_from'=>'30',
                'percentage_to'=>'40',
                'grade_point'=>'1.6',
                'remarks' => 'Partially Acceptable'
            ],
            [
                'exam_type_id' => '1',
                'grade_name'=>'D',
                'percentage_from'=>'20',
                'percentage_to'=>'30',
                'grade_point'=>'1.2',
                'remarks' => 'Insufficient'
            ],
            [
                'exam_type_id' => '1',
                'grade_name'=>'E',
                'percentage_from'=>'0',
                'percentage_to'=>'20',
                'grade_point'=>'0.8',
                'remarks' => 'Very Insufficient'
            ],
            
            [
                'exam_type_id' => '2',
                'grade_name'=>'Distinction',
                'percentage_from'=>'75',
                'percentage_to'=>'100',
            ],
            [
                'exam_type_id' => '2',
                'grade_name'=>'First Division',
                'percentage_from'=>'60',
                'percentage_to'=>'74',
            ],
            [
                'exam_type_id' => '2',
                'grade_name'=>'Second Division',
                'percentage_from'=>'45',
                'percentage_to'=>'59',
            ],
            [
                'exam_type_id' => '2',
                'grade_name'=>'Third Division',
                'percentage_from'=>'35',
                'percentage_to'=>'44',
            ],
            [
                'exam_type_id' => '2',
                'grade_name'=>'Failed',
                'percentage_from'=>'0',
                'percentage_to'=>'34',
            ],
        ];


        foreach ($grades as $grade) {
            ExamGrade::create($grade);
        }
    }
}
