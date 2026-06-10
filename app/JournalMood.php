<?php

declare(strict_types=1);

namespace App;

enum JournalMood: string
{
    case NEUTRAL = 'neutral';
    case GOOD = 'good';
    case BAD = 'bad';

    public function label(): string
    {
        return match ($this) {
            self::NEUTRAL => 'neutral',
            self::GOOD => 'good',
            self::BAD => 'bad',
        };
    }
}
