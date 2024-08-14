<?php

namespace App\Contracts;

use App\Http\Requests\VoucherRequest;
use App\Models\Voucher;
use Illuminate\Support\Collection;

interface VoucherInterface
{
  public function getLatest(array $filters): Collection;

  public function create(VoucherRequest $request): Voucher;

  public function updateById($id, VoucherRequest $request): Voucher;

  public function approve(int $id): Voucher;

  public function disapprove(int $id): Voucher;
}
