<?php

namespace App\Console\Commands;

use App\Models\Student;
use Illuminate\Console\Command;

class UpdateStudentGenderToNullCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:student-gender-to-null';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update student gender to null';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): void
    {
        $students = Student::query()
            ->where('gender', '0')
            ->get();

        $progressBar = $this->output->createProgressBar($students->count());
        $progressBar->setBarCharacter('<fg=green>•</>');
        $progressBar->setEmptyBarCharacter('<fg=red>•</>');
        $progressBar->setProgressCharacter('<fg=green>></>');
        $progressBar->start();

        foreach ($students as $student) {
            $student->update([
                'gender' => NULL
            ]);

            $progressBar->advance();
        }

        $progressBar->finish();
    }
}
