<?php

namespace App\Enums;

enum PaymentMode: string
{
    case Upi = 'upi';
    case Cash = 'cash';

    public function label(): string
    {
        return match ($this) {
            self::Upi => 'UPI',
            self::Cash => 'Cash',
        };
    }
}
