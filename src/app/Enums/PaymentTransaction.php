<?php

namespace App\Enums;

enum PaymentTransaction: string
{
    case BCA = 'bca';
    case BRI = 'bri';
    case MANDIRI = 'mandiri';
    case CASH = 'cash';

    public function label(): string
    {
        return match ($this) {
            self::BCA => 'BCA',
            self::BRI => 'BRI',
            self::MANDIRI => 'Mandiri',
            self::CASH => 'Cash',
        };
    }

    // public static function labels(): array
    // {
    //     return array_map(
    //         fn($case) => $case->label(),
    //         self::cases()
    //     );
    // }
    public static function labels(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn($case) => [$case->value => $case->label()])
            ->toArray();
    }
}
