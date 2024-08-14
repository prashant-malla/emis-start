<?php

namespace Database\Seeders;

use App\Models\Level;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $levels = [
            [
                'name' => "Bachelor's"
            ],
            [
                'name' => "Master's",
            ],
            [
                'name' => "MPhil",
            ],
            [
                'name' => "Ph.D",
            ],
        ];

        foreach ($levels as $level) {
            Level::create($level);
        }
    }
}
