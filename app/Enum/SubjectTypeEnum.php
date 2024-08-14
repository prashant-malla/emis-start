<?php

namespace App\Enum;

enum SubjectTypeEnum: string
{
    case THEORY_AND_PRACTICAL = 'has_theory_practical';
    case THEORY_ONLY = 'is_theory';
    case PRACTICAL_ONLY = 'is_practical';
}
