<?php

namespace App\Services;

use App\Contracts\YearSemesterInterface;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class YearSemesterService
{
    public function __construct(protected YearSemesterInterface $yearSemester)
    {
    }

    public function get(): Collection
    {
        return
            $this->yearSemester->get();
    }

    public function getByProgramId($programId, $filters = []): Collection
    {
        $filters = Arr::only($filters, ['academic_year_id', 'batch_id']);

        return
            $this->yearSemester
            ->getByProgramId($programId, $filters);
    }

    public function list(array $filters = []): Collection
    {
        $filters = Arr::only($filters, ['program_id', 'batch_id', 'academic_year_id']);

        return
            $this->yearSemester->list($filters);
    }

    public function filterBy($programId): Collection
    {
        return
            $this->yearSemester->filterBy($programId);
    }
}
