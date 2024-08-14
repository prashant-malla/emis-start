<?php

namespace App\Console\Commands;

use App\Models\MasterSection;
use App\Models\Section;
use Illuminate\Console\Command;

class InitiMasterGroupsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'init:master-groups';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates Master Groups based upon available section names';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $masterSectionInitialized = MasterSection::exists();
        if ($masterSectionInitialized) {
            $this->warn('Master Sections already initialized');
            return Command::FAILURE;
        }

        $sectionNames = Section::pluck('group_name')->unique()->toArray();
        foreach ($sectionNames as $sectionName) {
            $masterSection = MasterSection::create(['title' => $sectionName]);
            Section::where('group_name', $sectionName)->update(['master_section_id' => $masterSection->id]);
        }

        $this->info('Master Sections initialized');
        return Command::SUCCESS;
    }
}
