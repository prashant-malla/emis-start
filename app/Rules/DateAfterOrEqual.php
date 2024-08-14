<?php

namespace App\Rules;

use App\Services\SchoolSettingService;
use Illuminate\Contracts\Validation\Rule;
use MilanTarami\NepaliCalendar\NepaliCalendar;

class DateAfterOrEqual implements Rule
{
    protected $startDate;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($startDate)
    {
        $this->startDate = $startDate;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $endDate)
    {
        $schoolSettingService = app(SchoolSettingService::class);
        $schoolSetting = $schoolSettingService->getSetting();

        $startDate = $this->startDate;

        // convert dates to AD for correct comparision
        if ($schoolSetting->calendar_type === 'np') {
            $nepaliCalendar = new NepaliCalendar();
            $startDate = $nepaliCalendar->BS2AD($startDate);
            $endDate = $nepaliCalendar->BS2AD($endDate);
        }

        return strtotime($endDate) >= strtotime($startDate);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The end date must be a date after or equal to start date.';
    }
}
