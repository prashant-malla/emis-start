<?php

namespace App\Contracts;

interface NoticeInterface
{
    public function getTotalNotices($student): int;
}
