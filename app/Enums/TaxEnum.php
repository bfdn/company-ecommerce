<?php

namespace App\Enums;

enum TaxEnum: int
{
    case ZERO = 0;
    case ONE = 1;
    case EIGHT = 8;
    case EIGHTEEN = 18;

    public function title(): string
    {
        return match ($this) {
            self::ZERO => 0,
            self::ONE => 1,
            self::EIGHT => 8,
            self::EIGHTEEN => 18,
        };
    }
}
