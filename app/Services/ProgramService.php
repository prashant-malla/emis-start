<?php

namespace App\Services;

use App\Contracts\ProgramInterface;
use App\Models\Program;
use Illuminate\Support\Collection;

class ProgramService
{
    public function __construct(protected ProgramInterface $program)
    {
    }

    public function getAll(): Collection
    {
        return $this->program->getAll();
    }

    public function filterBy($levelId): Collection
    {
        return
            $this->program->filterBy($levelId);
    }
}
