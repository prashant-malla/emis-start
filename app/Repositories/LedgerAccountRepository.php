<?php

namespace App\Repositories;

use App\Contracts\LedgerAccountInterface;
use App\Http\Requests\LedgerAccountRequest;
use App\Models\LedgerAccount;
use Illuminate\Support\Collection;

class LedgerAccountRepository implements LedgerAccountInterface
{
  public function __construct(
    protected LedgerAccount $ledgerAccount
  ) {
  }

  public function get(string $orderBy = 'id', bool $latest = true): Collection
  {
    return $this->ledgerAccount->orderBy($orderBy, $latest ? 'desc' : 'asc')->get();
  }

  public function create(LedgerAccountRequest $request): LedgerAccount
  {
    $ledgerAccount = LedgerAccount::query()
      ->create(
        $request->all()
      );

    return $ledgerAccount;
  }

  public function updateById($id, LedgerAccountRequest $request): LedgerAccount
  {
    $ledgerAccount = LedgerAccount::find($id);
    $ledgerAccount->fill($request->all());
    $ledgerAccount->update();

    return $ledgerAccount;
  }

  public function deleteById($id)
  {
    LedgerAccount::find($id)->delete();
  }
}
