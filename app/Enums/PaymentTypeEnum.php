<?php

namespace App\Enums;

enum PaymentTypeEnum: int
{
    case KAPIDAODEME = 1;
    case KREDIKARTI = 2;

    public function title(): string
    {
        return match ($this) {
            self::KAPIDAODEME => 'Kapıda Ödeme',
            self::KREDIKARTI => 'Kredi Kartı',
        };
    }
}
