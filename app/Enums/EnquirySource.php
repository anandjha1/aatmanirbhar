<?php

namespace App\Enums;

enum EnquirySource: string
{
    case WalkIn = 'walk_in';
    case Website = 'website';
    case OnCall = 'on_call';
    case Whatsapp = 'whatsapp';
    case Instagram = 'instagram';
    case Facebook = 'facebook';
    case StudentReferral = 'student_referral';
    case RelativeReferral = 'relative_referral';
    case Other = 'other';

    public function label(): string
    {
        return match ($this) {
            self::WalkIn => 'Walk-In',
            self::Website => 'Website',
            self::OnCall => 'On Call',
            self::Whatsapp => 'WhatsApp',
            self::Instagram => 'Instagram',
            self::Facebook => 'Facebook',
            self::StudentReferral => 'Student Referral',
            self::RelativeReferral => 'Relative Referral',
            self::Other => 'Other',
        };
    }
}
