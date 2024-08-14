<?php

namespace App\Rules;

use App\Services\SchoolSettingService;
use DateTime;
use Illuminate\Contracts\Validation\Rule;
use MilanTarami\NepaliCalendar\NepaliCalendar;

class ValidDate implements Rule
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
        if (empty($value) || is_null($value)) {
            return true;
        }

        $schoolSettingService = app(SchoolSettingService::class);
        $schoolSetting = $schoolSettingService->getSetting();
        $calendarFormat = 'Y-m-d';

        $date = DateTime::createFromFormat($calendarFormat, $value);
        if (!$date) {
            return false;
        }

        try {
            $nepaliCalendar = new NepaliCalendar();
            return $schoolSetting->calendar_type === 'np'
                ? $nepaliCalendar->bsDateExists($value)
                : $nepaliCalendar->adDateExists($value);
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute is invalid';
    }
}
