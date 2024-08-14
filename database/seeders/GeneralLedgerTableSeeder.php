<?php

namespace Database\Seeders;

use App\Models\GeneralLedger;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GeneralLedgerTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'account_name' => 'Admission Fee',
                'account_category_id' => 4,
            ],
            [
                'account_name' => 'Monthly Fee',
                'account_category_id' => 4,
            ],
            [
                'account_name' => 'Rent',
                'account_category_id' => 3,
            ],
            [
                'account_name' => 'Salaries',
                'account_category_id' => 3,
            ],
            [
                'account_name' => 'Bank Transfer',
                'account_category_id' => 2,
            ],
            [
                'account_name' => 'Fees Receivable',
                'account_category_id' => 2,
            ]
        ];

        foreach ($data as $d) {
            GeneralLedger::create($d);
        }
    }
}
