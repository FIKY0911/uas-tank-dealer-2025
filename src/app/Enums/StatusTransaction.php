<?php

namespace App\Enums;

enum StatusTransaction: string
{
    case PENDING = 'pending';
    case SUCCESS = 'success';
    case CANCELED = 'canceled';

    public function label(): string
    {
        return match ($this) {
            self::PENDING => 'Pending',
            self::SUCCESS => 'Success',
            self::CANCELED => 'Canceled',
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
