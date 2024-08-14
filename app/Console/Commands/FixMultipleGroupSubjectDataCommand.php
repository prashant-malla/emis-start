<?php

namespace App\Console\Commands;

use App\Models\LessonPlan;
use App\Models\Section;
use App\Models\Subject;
use App\Models\TeacherAssign;
use Illuminate\Console\Command;

class FixMultipleGroupSubjectDataCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fix:multiple-group-subject-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fix duplicate data on different models due to duplicate subjects created for each group';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->newLine();
        $this->info('Generating Replacable Subject Ids key value pair');
        // Subject Ids key value pair to replace invalid subject_id with valid one (invalid -> which will be deleted)
        // Current assumption: only two section are there(which generates two duplicate subjects at max)
        $transformSubjectIds = Subject::query()
            ->selectRaw('MIN(id) as min_id, MAX(id) as max_id')
            ->groupBy('year_semester_id', 'name')
            ->havingRaw('COUNT(*) > 1')
            ->pluck('min_id', 'max_id');
    
        $this->newLine();
        $this->info('Fixing duplicates in lessonplan');
        // 1. Fix duplicate in lessonplan
        // Make all subject_id valid
        foreach($transformSubjectIds as $findId => $toId){
            LessonPlan::where('subject_id', $findId)->update(['subject_id' => $toId]);
        }
        // Delete duplicates
        $duplicateLessonPlanIds = LessonPlan::query()
            ->selectRaw('MAX(id) as id')
            ->groupBy('teacher_id', 'year_semester_id', 'subject_id')
            ->havingRaw('COUNT(*) > 1')
            ->pluck('id');
        LessonPlan::whereIn('id', $duplicateLessonPlanIds)->delete();


        $this->newLine();
        $this->info('Fixing invalid subject_id in teacher asssign');
        // 2. Fix invalid subject_id in teacher asssign
        // Make all subject_id valid
        foreach($transformSubjectIds as $findId => $toId){
            TeacherAssign::where('subject_id', $findId)->update(['subject_id' => $toId]);
        }


        $this->newLine();
        $this->info('Fixing subjects: sync to groups, delete duplicates');
        // 3. Fix Subjects
        // Assign existing subjects to groups
        $subjects = Subject::query()
            ->selectRaw('section_id, GROUP_CONCAT(id) as subject_ids')
            ->whereNotNull('section_id')
            ->groupBy('section_id')
            ->get();
        foreach($subjects as $subject){
            $subjectIds = explode(',', $subject->subject_ids);
            Section::find($subject->section_id)->subjects()->sync($subjectIds);
        }
        // Delete duplicate subjects
        Subject::whereIn('id', $transformSubjectIds->keys())->delete();

        $this->newLine();
        $this->info('All commands run successfully!!');

        // TODO::write a migration to remove section_id from subjects table later (its set nullable only for now)

        return Command::SUCCESS;
    }
}
