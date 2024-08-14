<?php

namespace App\Enum;

enum StudentInquiryStatusEnum: string
{
    case IN_PROGRESS = 'in_progress';
    case COMPLETED = 'completed';
    case REJECTED = 'rejected';
}
