<?php

namespace App\Enum;

enum StudentStatusEnum: int
{
    case ACTIVE = 1;
    case DROPPED = 2;
    case TRANSFERRED = 3;
    case ALUMNI = 4;
    case OTHERS = 5;
    case ON_HOLD = 6;

    public static function toArray()
    {
        $values = [];

        foreach (self::cases() as $props) {
            array_push($values, $props->value);
        }

        return $values;
    }
}
