<?php

namespace App\Services;

use App\Contracts\EventInterface;
use App\Repositories\EventRepository;

class EventService implements EventInterface
{
    public function __construct(
        protected EventRepository $event
    ) {

    }

    public function getTotalEvents($student): int
    {
        return $this->event->getTotalEvents($student);
    }
}
