<?php

namespace App\Console\Commands;

use App\Models\ExamSubject;
use Illuminate\Console\Command;

class UpdateSubjectMarksToExamSubjectsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:subject-marks-to-exam-subjects';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Updates subject marks to exam subjects';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $examSubjects = ExamSubject::whereNull('theory_full_marks')->whereNull('practical_full_marks')->get();
        if($examSubjects->count() > 0) {
            $examSubjects->load('subject');
            
            foreach($examSubjects as $examSubject) {
                $examSubject->update([
                    'theory_full_marks' => $examSubject->subject->theory_full_marks,
                    'theory_pass_marks' => $examSubject->subject->theory_pass_marks,
                    'practical_full_marks' => $examSubject->subject->practical_full_marks,
                    'practical_pass_marks' => $examSubject->subject->practical_pass_marks
                ]);
            }
            
            $this->newLine();
            $this->info('Exam subject marks updated successfully!');
        }else{
            $this->newLine();
            $this->warn('No exam subject marks to update!');
        }

        return Command::SUCCESS;
    }
}
