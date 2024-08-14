<?php

namespace App\Services;

// use App\Contracts\BatchServiceInterface;
use App\Models\Batch;
use Illuminate\Support\Collection;

class BatchService
{
    public function getAll(): Collection
    {
        return Batch::latest('id')->get();
    }
}
