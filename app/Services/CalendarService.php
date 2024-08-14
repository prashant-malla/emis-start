<?php

namespace App\Services;

use MilanTarami\NepaliCalendar\NepaliCalendar;

class CalendarService
{
  protected $calendarType;

  public function __construct(protected NepaliCalendar $nepaliCalendar, SchoolSettingService $schoolSettingService)
  {
    $schoolSetting = $schoolSettingService->getSetting();
    $this->calendarType = $schoolSetting->calendar_type;
  }

  public function today(): string
  {
    $calendarType = $this->calendarType === 'en' ? 'AD' : 'BS';
    return $this->nepaliCalendar->today($calendarType);
  }

  public function toEngDate($value)
  {
    if ($value && $this->calendarType === 'np') {
      return $this->nepaliCalendar->BS2AD($value);
    }

    return $value;
  }

  public function toSystemDate($value)
  {
    if ($value && $this->calendarType === 'np') {

      // english date is not in range
      if (!$this->nepaliCalendar->adDateExists($value)) {
        return null;
      }

      return  $this->nepaliCalendar->AD2BS($value);
    }

    return $value;
  }
}
