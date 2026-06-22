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
            self::NEUTRAL => 'Neutral',
            self::GOOD => 'Good',
            self::BAD => 'Bad',
        };
    }

    public static function values(): array
    {
        return array_map(fn (JournalMood $mood) => $mood->value, self::cases());
    }
}
