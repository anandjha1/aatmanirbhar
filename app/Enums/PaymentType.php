<?php

namespace App\Enums;

enum PaymentType: string
{
    case CourseFee = 'course_fee';
    case SecurityDeposit = 'security_deposit';

    public function label(): string
    {
        return match ($this) {
            self::CourseFee => 'Course Fee',
            self::SecurityDeposit => 'Security Deposit',
        };
    }
}
