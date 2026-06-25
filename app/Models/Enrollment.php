<?php

namespace App\Models;

use App\Enums\EnrollmentStatus;
use Database\Factories\EnrollmentFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Enrollment extends Model
{
    /** @use HasFactory<EnrollmentFactory> */
    use HasFactory;

    protected $fillable = [
        'temp_id',
        'batch_id',
        'course_id',
        'counselling_record_id',
        'details_filled_by_id',
        'full_name',
        'father_name',
        'mother_name',
        'gender',
        'dob',
        'category',
        'religion',
        'aadhaar_no',
        'phone',
        'email',
        'house_no',
        'area',
        'district',
        'state',
        'pin_code',
        'class10_year',
        'class10_board',
        'class10_percentage',
        'class12_year',
        'class12_board',
        'class12_percentage',
        'company_name',
        'months_worked',
        'company_location',
        'company2_name',
        'company2_months',
        'company2_location',
        'hospitalized_last_5_years',
        'has_ailment',
        'ailment_details',
        'on_medication',
        'medical_notes',
        'interested_in_placement',
        'interested_sector',
        'emergency_contact',
        'sidh_profile_link',
        'candidate_id',
        'sidh_mobile',
        'sidh_name',
        'sidh_ekyc_done',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'status' => EnrollmentStatus::class,
            'dob' => 'date',
            'hospitalized_last_5_years' => 'boolean',
            'has_ailment' => 'boolean',
            'on_medication' => 'boolean',
            'interested_in_placement' => 'boolean',
            'sidh_ekyc_done' => 'boolean',
            'class10_year' => 'integer',
            'class12_year' => 'integer',
            'months_worked' => 'integer',
            'company2_months' => 'integer',
        ];
    }

    public function batch(): BelongsTo
    {
        return $this->belongsTo(Batch::class);
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function counsellingRecord(): BelongsTo
    {
        return $this->belongsTo(CounsellingRecord::class);
    }

    public function detailsFilledBy(): BelongsTo
    {
        return $this->belongsTo(Staff::class, 'details_filled_by_id');
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function batchMember(): HasOne
    {
        return $this->hasOne(BatchMember::class);
    }

    public function referringEnquiries(): HasMany
    {
        return $this->hasMany(Enquiry::class, 'referral_enrollment_id');
    }

    public function scopeActive($query)
    {
        return $query->where('status', EnrollmentStatus::Active);
    }

    public function scopeByBatch($query, int $batchId)
    {
        return $query->where('batch_id', $batchId);
    }
}
