<?php

namespace Database\Seeders;

use App\Models\AccountCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AccountCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AccountCategory::create([
            'name' => 'Assets',
            'slug' => 'assets',
            'type' => 'Assets',
        ]);

        AccountCategory::create([
            'name' => 'Liabilities',
            'slug' => 'liabilities',
            'type' => 'Liabilities'
        ]);

        AccountCategory::create([
            'name' => 'Income',
            'slug' => 'income',
            'type' => 'Income',
        ]);

        AccountCategory::create([
            'name' => 'Expenses',
            'slug' => 'expenses',
            'type' => 'Expenses',
        ]);
    }
}
