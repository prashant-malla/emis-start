<?php

namespace App\Services;

use App\Models\GeneralLedger;
use App\Repositories\GeneralLedgerRepository;
use Illuminate\Support\Collection;

class GeneralLedgerService
{
  public function __construct(
    protected GeneralLedgerRepository $generalLedger
  ) {
  }

  public function getLatest(): Collection
  {
    return $this->generalLedger->getLatest();
  }

  public function create(array $data): GeneralLedger
  {
    return $this->generalLedger->create($data);
  }
}
