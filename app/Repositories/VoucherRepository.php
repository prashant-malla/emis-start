<?php

namespace App\Repositories;

use App\Contracts\VoucherInterface;
use App\Http\Requests\VoucherRequest;
use App\Models\Voucher;
use Illuminate\Support\Collection;

class VoucherRepository implements VoucherInterface
{
  public function __construct(
    protected Voucher $voucher
  ) {
  }
  public function getLatest(array $filters): Collection
  {
    return $this
      ->voucher
      ->filter($filters)
      ->latest('id')
      ->get();
  }

  public function create(VoucherRequest $request): Voucher
  {
    $voucher = Voucher::query()
      ->create(
        $request->all()
      );

    return $voucher;
  }

  public function updateById($id, VoucherRequest $request): Voucher
  {
    $voucher = Voucher::find($id);
    $voucher->fill($request->all());
    $voucher->update();

    return $voucher;
  }

  public function deleteById($id)
  {
    Voucher::find($id)->delete();
  }

  public function approve(int $id): Voucher
  {
    $voucher = Voucher::find($id);
    $voucher->approval_status = 1;
    $voucher->update();

    return $voucher;
  }

  public function disapprove(int $id): Voucher
  {
    $voucher = Voucher::find($id);
    $voucher->approval_status = 2;
    $voucher->update();

    return $voucher;
  }
}
