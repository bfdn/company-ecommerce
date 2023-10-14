<?php

namespace App\Enums;

enum OrderStatusEnum: int
{
    case ONAYBEKLIYOR = 1;
    case ONAYLANDI = 2;
    case KARGOYAVERILDI = 3;
    case IPTALEDILDI = 4;
    case TESLIMEDILDI = 5;
    case TEDARIKSURECINDE = 6;
    case ODEMEBEKLENIYOR = 7;
    case HAZIRLANIYOR = 8;

    public function title(): string
    {
        return match ($this) {
            self::ONAYBEKLIYOR => 'Onay Bekliyor',
            self::ONAYLANDI => 'Onaylandı',
            self::KARGOYAVERILDI => 'Kargoya Verildi',
            self::IPTALEDILDI => 'İptal Edildi',
            self::TESLIMEDILDI => 'Teslim Edildi',
            self::TEDARIKSURECINDE => 'Tedarik Sürecinde',
            self::ODEMEBEKLENIYOR => 'Ödeme Bekleniyor',
            self::HAZIRLANIYOR => 'Hazırlanıyor',
        };
    }
}
