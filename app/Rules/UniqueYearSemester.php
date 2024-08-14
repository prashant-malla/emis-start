<?php

namespace App\Rules;

use App\Models\YearSemester;
use Illuminate\Contracts\Validation\Rule;

class UniqueYearSemester implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(
        protected $batch_id,
        protected $program_id,
        protected $year_semester_id = null,
    ) {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        // Batch not assigned or Has same name on a batch for give program
        return YearSemester::query()
            ->where('program_id', $this->program_id)
            ->where(function ($query) {
                $query
                    ->whereNull('batch_id')
                    ->orWhere('batch_id', $this->batch_id);
            })
            ->where('name', $value)
            ->when($this->year_semester_id ?? null, function ($query) {
                $query->where('id', '!=', $this->year_semester_id);
            })->count() === 0;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Year/Semester name already exists for this Batch/Academic Year or Batch/Academic Year has not been assigned for some Year/Semester within this program.';
    }
}
