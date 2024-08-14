<?php

namespace App\Contracts;

use Illuminate\Database\Eloquent\Collection;

interface HomeworkInterface
{
    public function getHomeworks($student): Collection;
    public function getTotalHomeworks($student): int;
}
