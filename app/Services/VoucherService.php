<?php

namespace App\Services;

use App\Http\Requests\VoucherRequest;
use App\Models\Voucher;
use App\Repositories\VoucherRepository;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class VoucherService
{
  public function __construct(
    protected VoucherRepository $voucher
  ) {
  }

  public function generateVoucherNumber($prefix)
  {
    $latestVoucher = $this->voucher->getLatest(['voucher_number_like' => $prefix . '%'])->first();

    $sequenceNumber = $latestVoucher ? intval(substr($latestVoucher->voucher_number, 2)) + 1 : 1;

    $newVoucherNumber = $prefix . str_pad($sequenceNumber, 7, '0', STR_PAD_LEFT);

    return $newVoucherNumber;
  }

  public function getLatest(array $filters): Collection
  {
    return $this->voucher->getLatest($filters);
  }

  public function create(VoucherRequest $request): Voucher
  {
    $prefix = strtoupper(substr($request->type, 0, 1)) . 'V';

    $request->merge([
      'voucher_number' => $this->generateVoucherNumber($prefix)
    ]);

    $voucher =  $this->voucher->create($request);

    foreach ($request->ledger_account_id as $idx => $accountId) {
      $voucher->generalLedgers()->create([
        'ledger_account_id' => $accountId,
        'debit_amount' => $request->debit_amount[$idx] ?? 0,
        'credit_amount' => $request->credit_amount[$idx] ?? 0,
        'remark' => $request->remark[$idx],
      ]);
    }

    return $voucher;
  }

  public function update(Voucher $voucher, VoucherRequest $request): Voucher
  {
    if(!$voucher->voucher_number){      
      $prefix = strtoupper(substr($request->type, 0, 1)) . 'V';

      $request->merge([
        'voucher_number' => $this->generateVoucherNumber($prefix)
      ]);
    }

    $voucher = $this->voucher->updateById($voucher->id, $request);

    $voucher->generalLedgers()->delete();

    foreach ($request->ledger_account_id as $idx => $accountId) {
      $voucher->generalLedgers()->create([
        'ledger_account_id' => $accountId,
        'debit_amount' => $request->debit_amount[$idx] ?? 0,
        'credit_amount' => $request->credit_amount[$idx] ?? 0,
        'remark' => $request->remark[$idx],
      ]);
    }

    return $voucher;
  }

  public function delete(Voucher $voucher)
  {
    $voucher->generalLedgers()->delete();

    return $this->voucher->deleteById($voucher->id);
  }

  public function approve(int $id): Voucher
  {
    return $this->voucher->approve($id);
  }

  public function disapprove(int $id): Voucher
  {
    return $this->voucher->disapprove($id);
  }
}
