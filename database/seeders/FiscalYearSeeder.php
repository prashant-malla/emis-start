<?php

namespace Database\Seeders;

use App\Models\FiscalYear;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FiscalYearSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            'title' => '2080/2081',
            'start_date' => '2080-04-01',
            'end_date' => '2081-03-31',
            'is_active' => 1
        ];

        FiscalYear::create($data);
    }
}
