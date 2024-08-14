<?php

namespace App\Console\Commands;

use App\Models\AccountCategory;
use Illuminate\Console\Command;

class UpdateAccountCategoryTypeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:account-category-type';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Updates Type field in Account Category';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $oldNames = collect(['Assets', 'Liabilities', 'Income', 'Expenditure']);

        $accountGroups = AccountCategory::query()
            ->whereNull('type')
            ->get();

        foreach($accountGroups as $accountGroup)
        {
            if($oldNames->contains($accountGroup->name)){
                $accountGroup->update([
                    'type' => $accountGroup->name === 'Expenditure' ? 'Expenses': $accountGroup->name
                ]);
            }
        }

        $this->newLine();
        $this->info('Account Category type updated successfully!');

        return Command::SUCCESS;
    }
}
