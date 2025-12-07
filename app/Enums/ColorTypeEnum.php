<?php

declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

final class ColorTypeEnum extends Enum
{
    const DARK = 1;
    const LIGHT = 2;

    public static function getDescription($value): string
    {
        if ($value instanceof self) {
            $value = $value->value;
        }

        return match ($value) {
            self::DARK => 'Dark',
            self::LIGHT => 'Light',
            default => parent::getDescription($value),
        };
    }
}
