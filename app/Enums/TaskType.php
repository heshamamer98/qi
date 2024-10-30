<?php

namespace App\Enums;

enum TaskType: string
{
    case FEATURE = "feature";
    case BUG = "bug";

    public static function values(): array
    {
        $values = array_column(self::cases(), 'value');
        return array_combine($values, $values);
    }

    public function color(): string
    {
        return match($this)
        {
            self::FEATURE => 'primary',
            // self::MASK => 'success',
            // self::FIX => 'gray',
            self::BUG => 'danger',
        };
    }
}
