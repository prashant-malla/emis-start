<?php

namespace App\Repositories;

use App\Contracts\ProgramInterface;
use App\Models\Program;
use Illuminate\Support\Collection;

class ProgramRepository implements ProgramInterface
{
    public function __construct(protected Program $program)
    {
    }

    public function getAll(): Collection
    {
        return
            $this->program
            ->get();
    }

    public function filterBy($levelId = null): Collection
    {
        return
            $this->program
            ->when($levelId, function ($query) use ($levelId) {
                $query->where('level_id', $levelId);
            })
            ->get()
            ->map(
                function ($program) {
                    return [
                        'id' => $program->id,
                        'name' => $program->name,
                        'type' => $program->type,
                        'admissionFee' => $program->admission_fee
                    ];
                }
            );
    }
}
