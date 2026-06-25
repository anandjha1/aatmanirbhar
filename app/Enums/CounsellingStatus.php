<?php

namespace App\Enums;

enum CounsellingStatus: string
{
    case Pending = 'pending';
    case Called = 'called';
    case Visited = 'visited';
    case Enrolled = 'enrolled';
    case Dropped = 'dropped';

    public function label(): string
    {
        return match ($this) {
            self::Pending => 'Pending',
            self::Called => 'Called',
            self::Visited => 'Visited',
            self::Enrolled => 'Enrolled',
            self::Dropped => 'Dropped',
        };
    }
}
