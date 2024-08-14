<?php

namespace App\Contracts;

use Illuminate\Support\Collection;

interface ProgramInterface
{
    public function getAll(): Collection;
    public function filterBy($levelId): Collection;
}
