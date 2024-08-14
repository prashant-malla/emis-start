<?php

namespace App\Repositories;

use App\Models\NonCredit;
use Illuminate\Support\Collection;
use App\Contracts\NonCreditInterface;
use App\Http\Requests\StoreNonCreditRequest;

class NonCreditRepository implements NonCreditInterface
{
    public function __construct(
        protected NonCredit $nonCredit
    ) {
    }

    public function getLatest() : Collection
    {
        return
            $this
                ->nonCredit
                ->latest('id')
                ->get();
    }

    public function create(StoreNonCreditRequest $request) : NonCredit
    {
        $nonCredit = NonCredit::query()
            ->create(
                $request->all()
            );

        if ($request->file('qr')) {
            $nonCredit->addMedia($request->file('qr'))->toMediaCollection();
        }

        return $nonCredit;
    }
}
