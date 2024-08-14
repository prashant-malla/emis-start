<?php

namespace App\Contracts;

use App\Http\Requests\StoreIdCardRequest;
use App\Models\IdCard;
use Illuminate\Support\Collection;

interface IdCardInterface
{
  public function getById($id): IdCard;
  public function getLatest(): Collection;
  public function create(StoreIdCardRequest $request): IdCard;
  public function updateById($id, StoreIdCardRequest $request): IdCard;
  public function deleteById($id);
}
