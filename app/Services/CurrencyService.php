<?php

namespace App\Services;

use MilanTarami\NumberToWordsConverter\Facades\NumberToWordsFacade as NumberToWords;

class CurrencyService
{
    public function toMoney($amount)
    {
        return number_format($amount, 2);
    }

    public function toWords($amount, $lang = 'en')
    {
        $allowedLanguages = ['en', 'np'];

        if (!in_array($lang, $allowedLanguages)) {
            $lang = 'en';
        }

        return NumberToWords::get($amount, ['lang' => $lang]);
    }
}
