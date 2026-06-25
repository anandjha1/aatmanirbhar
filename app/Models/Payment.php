<?php

namespace App\Models;

use App\Enums\PaymentMode;
use App\Enums\PaymentType;
use Database\Factories\PaymentFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    /** @use HasFactory<PaymentFactory> */
    use HasFactory;

    protected $fillable = [
        'enrollment_id',
        'payment_type',
        'amount',
        'mode',
        'transaction_no',
        'payment_medium',
        'collected_by_id',
        'is_refunded',
        'refund_date',
        'refund_mode',
        'refund_upi_id',
        'refund_account_name',
        'refunded_at',
        'refunded_by_id',
        'refund_notes',
    ];

    protected function casts(): array
    {
        return [
            'payment_type' => PaymentType::class,
            'mode' => PaymentMode::class,
            'refund_mode' => PaymentMode::class,
            'is_refunded' => 'boolean',
            'amount' => 'integer',
            'refund_date' => 'date',
            'refunded_at' => 'datetime',
        ];
    }

    public function enrollment(): BelongsTo
    {
        return $this->belongsTo(Enrollment::class);
    }

    public function collectedBy(): BelongsTo
    {
        return $this->belongsTo(Staff::class, 'collected_by_id');
    }

    public function refundedBy(): BelongsTo
    {
        return $this->belongsTo(Staff::class, 'refunded_by_id');
    }

    public function scopeSecurityDeposits($query)
    {
        return $query->where('payment_type', PaymentType::SecurityDeposit);
    }

    public function scopePendingRefunds($query)
    {
        return $query->where('payment_type', PaymentType::SecurityDeposit)
            ->where('is_refunded', false);
    }

    public function isSecurityDeposit(): bool
    {
        return $this->payment_type === PaymentType::SecurityDeposit;
    }
}
