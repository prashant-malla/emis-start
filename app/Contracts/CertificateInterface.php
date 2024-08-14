<?php

namespace App\Contracts;

use App\Http\Requests\StoreCertificateRequest;
use App\Models\Certificate;
use Illuminate\Support\Collection;

interface CertificateInterface
{
    public function getById($id): Certificate;
    public function getLatest(): Collection;
    public function create(StoreCertificateRequest $request): Certificate;
    public function updateById($id, StoreCertificateRequest $request): Certificate;
    public function deleteById($id);
}
