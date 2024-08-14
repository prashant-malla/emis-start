<?php

namespace App\Casts;

use App\Services\CalendarService;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class SystemDate implements CastsAttributes
{
    /**
     * Cast the given value.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @param  string  $key
     * @param  mixed  $value
     * @param  array  $attributes
     * @return mixed
     */
    public function get($model, string $key, $value, array $attributes)
    {
        $calendarService = app(CalendarService::class);
        return $calendarService->toSystemDate($value);
    }

    /**
     * Prepare the given value for storage.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @param  string  $key
     * @param  mixed  $value
     * @param  array  $attributes
     * @return mixed
     */
    public function set($model, string $key, $value, array $attributes)
    {
        if ($key !== 'created_at') {
            $calendarService = app(CalendarService::class);
            return $calendarService->toEngDate($value);
        }
        return $value;
    }
}
