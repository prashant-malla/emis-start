<?php

namespace App\Services;

use App\Models\NonCredit;
use Illuminate\Support\Collection;
use App\Contracts\NonCreditInterface;
use App\Http\Requests\StoreNonCreditRequest;

class NonCreditService
{
    public function __construct(
        protected NonCreditInterface $nonCredit
    ) {
    }

    public function getLatest() : Collection
    {
        return
            $this->nonCredit->getLatest();
    }

    public function create(StoreNonCreditRequest $request) : NonCredit
    {
        return
            $this->nonCredit->create($request);
    }
}
