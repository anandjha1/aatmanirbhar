<?php

namespace App\Models;

use App\Enums\EnquirySource;
use App\Enums\EnquiryStatus;
use Database\Factories\EnquiryFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Enquiry extends Model
{
    /** @use HasFactory<EnquiryFactory> */
    use HasFactory;

    protected $fillable = [
        'full_name',
        'mobile',
        'email',
        'dob',
        'gender',
        'qualification',
        'source',
        'referral_enrollment_id',
        'referral_name',
        'interested_course_id',
        'status',
        'assigned_to',
        'remarks',
    ];

    protected function casts(): array
    {
        return [
            'source' => EnquirySource::class,
            'status' => EnquiryStatus::class,
            'dob' => 'date',
        ];
    }

    public function assignedStaff(): BelongsTo
    {
        return $this->belongsTo(Staff::class, 'assigned_to');
    }

    public function interestedCourse(): BelongsTo
    {
        return $this->belongsTo(Course::class, 'interested_course_id');
    }

    public function referralEnrollment(): BelongsTo
    {
        return $this->belongsTo(Enrollment::class, 'referral_enrollment_id');
    }

    public function followUps(): HasMany
    {
        return $this->hasMany(FollowUp::class);
    }

    public function testRegistration(): HasOne
    {
        return $this->hasOne(TestRegistration::class);
    }

    public function scopeAssignedTo($query, int $staffId)
    {
        return $query->where('assigned_to', $staffId);
    }

    public function scopeByStatus($query, EnquiryStatus $status)
    {
        return $query->where('status', $status);
    }

    public function scopeBySource($query, EnquirySource $source)
    {
        return $query->where('source', $source);
    }
}
