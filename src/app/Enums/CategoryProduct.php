<?php

namespace App\Enums;

enum CategoryProduct: string
{
    case LIGHTTANK = 'Light Tank';
    case MEDIUMTANK = 'Medium Tank';
    case HEAVYTANK = 'Heavy Tank';
    case MAINBATTLETANK = 'Main Battle Tank';
    case AMPHIBIOUS = 'Amphibious Tank';

    public function label(): string
    {
        return match ($this) {
            self::LIGHTTANK => 'Light',
            self::MEDIUMTANK => 'Medium',
            self::HEAVYTANK => 'Heavy',
            self::MAINBATTLETANK => 'MBT',
            self::AMPHIBIOUS => 'Amphibious',
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
