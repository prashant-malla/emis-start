<?php

namespace App\Contracts;

use Illuminate\Support\Collection;

interface LevelInterface
{
  public function get(): Collection;
  public function getLevels(): Collection;
}
