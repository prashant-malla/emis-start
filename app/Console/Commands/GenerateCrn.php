<?php

namespace App\Console\Commands;

use Exception;
use Illuminate\Console\Command;

class GenerateCrn extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:crn {start_from}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate CRN (college reg. number)';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $startFrom = $this->argument('start_from');

        if ($this->confirm('Are you sure?')) {
            try {
                $students = \App\Models\Student::select('id', 'crn')->get();

                $bar = $this->output->createProgressBar(count($students));

                $bar->start();

                foreach ($students as $student) {
                    $student->update(['crn' => $startFrom]);
                    $startFrom++;

                    $bar->advance();
                }

                $bar->finish();

                $this->newLine(2);
                $this->info('CRN generated successfully!');
                return Command::SUCCESS;
            } catch (\Throwable $th) {
                $this->error($th->getMessage());
                return Command::FAILURE;
            }
        }

        $this->info('CRN generation aborted!');
        return Command::FAILURE;
    }
}
