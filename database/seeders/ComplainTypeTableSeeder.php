<?php

namespace Database\Seeders;

use App\Models\ComplainType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ComplainTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $complainTypes = [
            [
                'complain_type' => "Management Feedback"
            ],
        ];

        foreach ($complainTypes as $complainType) {
            ComplainType::create($complainType);
        }
    }
}
