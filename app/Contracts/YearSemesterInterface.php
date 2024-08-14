<?php

namespace App\Contracts;

use Illuminate\Support\Collection;

interface YearSemesterInterface
{
    public function get(): Collection;
    public function getByProgramId(int $programId, array $filters = []): Collection;
    public function list(array $filters): Collection;
    public function filterBy($programId): Collection;
}
