<?php

namespace App\Contracts;

interface EventInterface
{
    public function getTotalEvents($student): int;
}
