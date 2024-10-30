<?php

namespace App\Enums;

use Filament\Support\Colors\Color;

enum StatusTitle: string
{
    case OPEN = "open";
    case IN_PROGRESS = "in progress";
    case FROZEN = "frozen";
    case REVIEW = "review";
    case DONE = "done";

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public function color(): string
    {
        return match($this)
        {
            self::OPEN => 'gray',
            self::IN_PROGRESS => 'primary',
            self::FROZEN => 'gray',
            self::REVIEW => 'danger',
            self::DONE => 'success',
        };
    }
}
