<?php

namespace App\Repositories;

use App\Contracts\LevelInterface;
use App\Models\Level;
use Illuminate\Support\Collection;

class LevelRepository implements LevelInterface
{
    public function __construct(protected Level $level)
    {
    }

    public function get(): Collection
    {
        return
            $this->level
            ->get()
            ->map(
                function ($level) {
                    return [
                        'id' => $level->id,
                        'name' => $level->name
                    ];
                }
            );
    }

    public function getLevels(): Collection
    {
        return Level::query()
            ->with('programs.yearSemesters.students')
            ->get();
    }
}
