<?php

namespace App\Models;

use App\Enums\FollowUpStatus;
use Database\Factories\FollowUpFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FollowUp extends Model
{
    /** @use HasFactory<FollowUpFactory> */
    use HasFactory;

    protected $fillable = [
        'enquiry_id',
        'staff_id',
        'notes',
        'follow_up_at',
        'status',
        'next_follow_up_at',
    ];

    protected function casts(): array
    {
        return [
            'status' => FollowUpStatus::class,
            'follow_up_at' => 'datetime',
            'next_follow_up_at' => 'datetime',
        ];
    }

    public function enquiry(): BelongsTo
    {
        return $this->belongsTo(Enquiry::class);
    }

    public function staff(): BelongsTo
    {
        return $this->belongsTo(Staff::class);
    }

    public function scopePending($query)
    {
        return $query->where('status', FollowUpStatus::Pending);
    }

    public function scopeDueToday($query)
    {
        return $query->whereDate('follow_up_at', today());
    }

    public function scopeOverdue($query)
    {
        return $query->where('status', FollowUpStatus::Pending)
            ->where('follow_up_at', '<', now());
    }
}
