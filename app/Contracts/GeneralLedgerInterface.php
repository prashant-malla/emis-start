<?php

namespace App\Contracts;

use App\Models\GeneralLedger;
use Illuminate\Support\Collection;

interface GeneralLedgerInterface
{
  public function getLatest(): Collection;

  public function create(array $data): GeneralLedger;
}
