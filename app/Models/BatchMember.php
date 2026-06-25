<?php

namespace App\Models;

use App\Enums\BatchMemberStatus;
use Database\Factories\BatchMemberFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BatchMember extends Model
{
    /** @use HasFactory<BatchMemberFactory> */
    use HasFactory;

    protected $fillable = [
        'batch_id',
        'enrollment_id',
        'joined_at',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'status' => BatchMemberStatus::class,
            'joined_at' => 'date',
        ];
    }

    public function batch(): BelongsTo
    {
        return $this->belongsTo(Batch::class);
    }

    public function enrollment(): BelongsTo
    {
        return $this->belongsTo(Enrollment::class);
    }

    public function scopeActive($query)
    {
        return $query->where('status', BatchMemberStatus::Active);
    }
}
