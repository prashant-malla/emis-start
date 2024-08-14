<?php

namespace Database\Seeders;

use App\Models\StudentCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StudentCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $studentCategories = [
            [
                'category_name' => 'Normal',
            ],
            [
                'category_name' => 'Orphan',
            ],
        ];

        foreach ($studentCategories as $studentCategory) {
            StudentCategory::create($studentCategory);
        }
    }
}
