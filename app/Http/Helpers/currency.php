<?php

use App\Services\CurrencyService;

if (!function_exists('convertToMoney')) {
    /**
     * converts given decimal value to money format.
     *
     * @return string
     */
    function convertToMoney(string $amount): string
    {
        $currencyService = app(CurrencyService::class);
        return $currencyService->toMoney($amount);
    }
}

if (!function_exists('convertToWords')) {
    /**
     * converts given decimal value to words format.
     *
     * @return string
     */
    function convertToWords(string $amount, string $lang = 'en'): string
    {
        $currencyService = app(CurrencyService::class);
        return $currencyService->toWords($amount, $lang);
    }
}
