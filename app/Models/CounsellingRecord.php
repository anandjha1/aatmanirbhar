<?php

namespace App\Models;

use App\Enums\CounsellingStatus;
use Database\Factories\CounsellingRecordFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class CounsellingRecord extends Model
{
    /** @use HasFactory<CounsellingRecordFactory> */
    use HasFactory;

    protected $fillable = [
        'test_registration_id',
        'enquiry_id',
        'temp_id',
        'status',
        'full_name',
        'mobile',
        'email',
        'dob',
        'test_result',
        'batch_selected',
        'ref_no',
        'current_status',
        'year_of_completion',
        'father_occupation',
        'mother_occupation',
        'first_aim',
        'second_aim',
        'purpose_of_training',
        'need_job',
        'job_location_preference',
        'has_experience',
        'experience_details',
        'remarks',
        'counselled_by_id',
        'counselled_with',
    ];

    protected function casts(): array
    {
        return [
            'status' => CounsellingStatus::class,
            'dob' => 'date',
            'test_result' => 'decimal:2',
            'need_job' => 'boolean',
            'has_experience' => 'boolean',
            'year_of_completion' => 'integer',
        ];
    }

    public function testRegistration(): BelongsTo
    {
        return $this->belongsTo(TestRegistration::class);
    }

    public function enquiry(): BelongsTo
    {
        return $this->belongsTo(Enquiry::class);
    }

    public function counselledBy(): BelongsTo
    {
        return $this->belongsTo(Staff::class, 'counselled_by_id');
    }

    public function enrollment(): HasOne
    {
        return $this->hasOne(Enrollment::class);
    }
}
