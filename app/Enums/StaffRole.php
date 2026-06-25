<?php

namespace App\Enums;

enum StaffRole: string
{
    case Admin = 'admin';
    case Trainer = 'trainer';
    case Counsellor = 'counsellor';
    case Mobiliser = 'mobiliser';

    public function label(): string
    {
        return match ($this) {
            self::Admin => 'Admin',
            self::Trainer => 'Trainer',
            self::Counsellor => 'Counsellor',
            self::Mobiliser => 'Mobiliser',
        };
    }
}
