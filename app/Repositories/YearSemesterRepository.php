<?php

namespace App\Repositories;

use App\Contracts\YearSemesterInterface;
use App\Models\YearSemester;
use Illuminate\Support\Collection;

class YearSemesterRepository implements YearSemesterInterface
{
    public function __construct(protected YearSemester $yearSemester)
    {
    }

    public function get(): Collection
    {
        return
            $this->yearSemester
            ->get();
    }

    public function getByProgramId($programId, $filters = []): Collection
    {
        return
            $this->yearSemester
            ->where('program_id', $programId)
            ->filterBy($filters)
            ->get();
    }

    public function list(array $filters = []): Collection
    {
        return
            $this->yearSemester
            ->filterBy($filters)
            ->get();
    }

    public function filterBy($programId = null): Collection
    {
        return
            $this->yearSemester
            ->when($programId, function ($query) use ($programId) {
                $query->where('program_id', $programId);
            })
            ->get()
            ->map(
                function ($yearSemester) {
                    return [
                        'id' => $yearSemester->id,
                        'name' => $yearSemester->name,
                        'type' => $yearSemester->type,
                    ];
                }
            );
    }
}
