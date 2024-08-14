<?php

namespace App\Repositories;

use App\Contracts\CertificateInterface;
use App\Http\Requests\StoreCertificateRequest;
use App\Models\Certificate;
use Illuminate\Support\Collection;

class CertificateRepository implements CertificateInterface
{
    public function __construct(
        protected Certificate $certificate
    ) {
    }

    public function getById($id): Certificate
    {
        return
            $this->certificate->find($id);
    }

    public function getLatest(): Collection
    {
        return
            $this
            ->certificate
            ->latest('id')
            ->get();
    }

    public function create(StoreCertificateRequest $request): Certificate
    {
        $certificate = Certificate::query()
            ->create(
                $request->all()
            );

        if ($request->file('background_image')) {
            $certificate->addMedia($request->file('background_image'))->toMediaCollection();
        }

        return $certificate;
    }

    public function updateById($id, StoreCertificateRequest $request): Certificate
    {
        $certificate = Certificate::find($id);
        $certificate->update($request->all());

        if ($request->file('background_image')) {
            $certificate->clearMediaCollection();
            $certificate->addMedia($request->file('background_image'))->toMediaCollection();
        }

        return $certificate;
    }

    public function deleteById($id)
    {
        Certificate::find($id)->delete();
    }
}
