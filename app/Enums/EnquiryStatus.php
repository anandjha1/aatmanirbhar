<?php

namespace App\Enums;

enum EnquiryStatus: string
{
    case New = 'new';
    case FollowUp = 'follow_up';
    case TestScheduled = 'test_scheduled';
    case TestDone = 'test_done';
    case CounsellingDone = 'counselling_done';
    case Enrolled = 'enrolled';
    case Dropped = 'dropped';

    public function label(): string
    {
        return match ($this) {
            self::New => 'New',
            self::FollowUp => 'Follow Up',
            self::TestScheduled => 'Test Scheduled',
            self::TestDone => 'Test Done',
            self::CounsellingDone => 'Counselling Done',
            self::Enrolled => 'Enrolled',
            self::Dropped => 'Dropped',
        };
    }
}
