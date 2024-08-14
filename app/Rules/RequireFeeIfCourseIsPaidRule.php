<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class RequireFeeIfCourseIsPaidRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
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
        if (str_contains(request()->get('course_cost'), 'Paid')) {
            return request()->filled('tuition_fee');
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The tution fee is required when course cost is payable.';
    }
}
