<?php

use App\Services\CalendarService;

if (!function_exists('getTodaySystemDate')) {
  /**
   * returns current system date.
   *
   * @return string
   */
  function getTodaySystemDate(): string
  {
    $calendarService = app(CalendarService::class);
    return $calendarService->today();
  }
}

if (!function_exists('convertToEngDate')) {
  /**
   * converts given date to english date.
   *
   * @return string
   */
  function convertToEngDate(string $date): string
  {
    $calendarService = app(CalendarService::class);
    return $calendarService->toEngDate($date);
  }
}
