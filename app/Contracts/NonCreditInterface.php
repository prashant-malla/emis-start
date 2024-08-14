<?php

namespace App\Contracts;

use App\Models\NonCredit;
use Illuminate\Support\Collection;
use App\Http\Requests\StoreNonCreditRequest;

interface NonCreditInterface
{
    public function getLatest() : Collection;
    public function create(StoreNonCreditRequest $request) : NonCredit;
}
