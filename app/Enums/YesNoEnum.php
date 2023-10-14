<?php

namespace App\Enums;

enum YesNoEnum: int
{
    case NO = 0;
    case YES = 1;

    public function title(): string
    {
        return match ($this) {
            self::NO => 'Hayır',
            self::YES => 'Evet',
        };
    }
}
