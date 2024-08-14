<?php

namespace App\Services;

use App\Contracts\HomeworkInterface;
use App\Repositories\HomeworkRepository;
use Illuminate\Database\Eloquent\Collection;

class HomeworkService implements HomeworkInterface
{
    public function __construct(
        protected HomeworkRepository $homework
    ) {
        //
    }

    public function getHomeworks($student): Collection
    {
        return $this->homework->getHomeworks($student);
    }

    public function getTotalHomeworks($student): int
    {
        return $this->homework->getTotalHomeworks($student);
    }
}
