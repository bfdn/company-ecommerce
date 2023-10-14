<?php

namespace App\Enums;

enum StatusEnum: int
{
    case ACTIVE = 1;
    case PASSIVE = 0;

    public function title(): string
    {
        return match ($this) {
            self::ACTIVE => 'Aktif',
            self::PASSIVE => 'Pasif',
        };
    }
}
