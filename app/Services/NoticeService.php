<?php

namespace App\Services;

use App\Contracts\NoticeInterface;
use App\Repositories\NoticeRepository;

class NoticeService implements NoticeInterface
{
    public function __construct(
        protected NoticeRepository $notice
    ) {
    }

    public function getTotalNotices($student): int
    {
        return $this->notice->getTotalNotices($student);
    }
}
