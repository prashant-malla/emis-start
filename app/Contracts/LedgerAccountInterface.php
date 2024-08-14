<?php

namespace App\Contracts;

use App\Http\Requests\LedgerAccountRequest;
use App\Models\LedgerAccount;
use Illuminate\Support\Collection;

interface LedgerAccountInterface
{
  public function get(string $orderBy, bool $latest = true): Collection;

  public function create(LedgerAccountRequest $request): LedgerAccount;

  public function updateById($id, LedgerAccountRequest $request): LedgerAccount;

  public function deleteById($id);
}
