<?php

namespace App\Repositories;

use App\Contracts\GeneralLedgerInterface;
use App\Models\GeneralLedger;
use Illuminate\Support\Collection;

class GeneralLedgerRepository implements GeneralLedgerInterface
{
  public function __construct(
    protected GeneralLedger $generalLedger
  ) {
  }

  public function getLatest(): Collection
  {
    return $this->generalLedger->latest('id')->get();
  }

  public function create(array $data): GeneralLedger
  {
    return $this->generalLedger->create($data);
  }
}
