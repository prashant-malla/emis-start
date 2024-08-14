<?php

namespace App\Services;

use App\Contracts\LedgerAccountInterface;
use App\Http\Requests\LedgerAccountRequest;
use App\Models\LedgerAccount;
use App\Repositories\LedgerAccountRepository;
use Illuminate\Support\Collection;

class LedgerAccountService
{
  public function __construct(
    protected LedgerAccountRepository $ledgerAccount
  ) {
  }

  public function getLatest(): Collection
  {
    return $this->ledgerAccount->get();
  }

  public function getOldest(): Collection
  {
    return $this->ledgerAccount->get(latest: false);
  }

  public function create(LedgerAccountRequest $request): LedgerAccount
  {
    return $this->ledgerAccount->create($request);
  }

  public function updateById($id, LedgerAccountRequest $request): LedgerAccount
  {
    return $this->ledgerAccount->updateById($id, $request);
  }

  public function deleteById($id)
  {
    return $this->ledgerAccount->deleteById($id);
  }
}
