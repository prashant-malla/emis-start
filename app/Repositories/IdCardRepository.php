<?php

namespace App\Repositories;

use App\Contracts\IdCardInterface;
use App\Http\Requests\StoreIdCardRequest;
use App\Models\IdCard;
use Illuminate\Support\Collection;

class IdCardRepository implements IdCardInterface
{
  public function __construct(
    protected IdCard $idcard
  ) {
  }

  public function getById($id): IdCard
  {
    return
      $this->idcard->find($id);
  }

  public function getLatest(): Collection
  {
    return
      $this
      ->idcard
      ->latest('id')
      ->get();
  }

  public function create(StoreIdCardRequest $request): IdCard
  {
    $idcard = new IdCard($request->all());
    $idcard->save();

    if ($request->file('background_image')) {
      $idcard->addMedia($request->file('background_image'))->toMediaCollection();
    }

    if ($request->file('logo')) {
      $idcard->addMedia($request->file('logo'))->toMediaCollection('logo');
    }

    if ($request->file('signature')) {
      $idcard->addMedia($request->file('signature'))->toMediaCollection('signature');
    }

    if ($request->file('seal_image')) {
      $idcard->addMedia($request->file('seal_image'))->toMediaCollection('seal_image');
    }

    return $idcard;
  }

  public function updateById($id, StoreIdCardRequest $request): IdCard
  {
    $idcard = IdCard::find($id);
    $idcard->fill($request->all());
    $idcard->update();

    if ($request->file('background_image')) {
      $idcard->clearMediaCollection();
      $idcard->addMedia($request->file('background_image'))->toMediaCollection();
    }

    if ($request->file('logo')) {
      $idcard->clearMediaCollection('logo');
      $idcard->addMedia($request->file('logo'))->toMediaCollection('logo');
    }

    if ($request->file('signature')) {
      $idcard->clearMediaCollection('signature');
      $idcard->addMedia($request->file('signature'))->toMediaCollection('signature');
    }

    if ($request->file('seal_image')) {
      $idcard->clearMediaCollection('seal_image');
      $idcard->addMedia($request->file('seal_image'))->toMediaCollection('seal_image');
    }

    return $idcard;
  }

  public function deleteById($id)
  {
    IdCard::find($id)->delete();
  }
}
