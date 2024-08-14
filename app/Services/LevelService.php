<?php

namespace App\Services;

use App\Contracts\LevelInterface;
use Illuminate\Support\Collection;

class LevelService
{
    public function __construct(protected LevelInterface $level)
    {
    }

    public function get(): Collection
    {
        return
            $this->level->get();
    }

    public function getLevels(): Collection
    {
        return $this->level->getLevels();
    }
}
