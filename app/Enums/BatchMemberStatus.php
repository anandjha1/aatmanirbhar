<?php

namespace App\Enums;

enum BatchMemberStatus: string
{
    case Active = 'active';
    case Completed = 'completed';
    case Dropped = 'dropped';

    public function label(): string
    {
        return match ($this) {
            self::Active => 'Active',
            self::Completed => 'Completed',
            self::Dropped => 'Dropped',
        };
    }
}
