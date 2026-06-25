<?php

namespace App\Models;

use Database\Factories\TestRegistrationFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Str;

class TestRegistration extends Model
{
    /** @use HasFactory<TestRegistrationFactory> */
    use HasFactory;

    protected $fillable = [
        'enquiry_id',
        'temp_id',
        'full_name',
        'dob',
        'mobile',
        'gender',
        'email',
        'qualification',
        'referral',
        'test_date',
        'course_id',
    ];

    protected function casts(): array
    {
        return [
            'dob' => 'date',
            'test_date' => 'date',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (TestRegistration $registration) {
            if (empty($registration->temp_id)) {
                $registration->temp_id = self::generateTempId();
            }
        });
    }

    /**
     * Auto-generate a unique temp ID in the format ACE001, ACE002, ...
     */
    public static function generateTempId(): string
    {
        $prefix = config('training.temp_id_prefix', 'ACE');

        $latest = self::where('temp_id', 'like', $prefix.'%')
            ->orderByDesc('id')
            ->value('temp_id');

        if ($latest) {
            $number = (int) Str::after($latest, $prefix);
            $nextNumber = $number + 1;
        } else {
            $nextNumber = 1;
        }

        return $prefix.str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
    }

    public function enquiry(): BelongsTo
    {
        return $this->belongsTo(Enquiry::class);
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function testResponse(): HasOne
    {
        return $this->hasOne(TestResponse::class);
    }

    public function counsellingRecord(): HasOne
    {
        return $this->hasOne(CounsellingRecord::class);
    }
}
