<?php

namespace App\Models;

use App\Enums\StaffRole;
use Database\Factories\StaffFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Staff extends Authenticatable
{
    /** @use HasFactory<StaffFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'staff';

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
        'is_active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'role' => StaffRole::class,
            'is_active' => 'boolean',
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function enquiries(): HasMany
    {
        return $this->hasMany(Enquiry::class, 'assigned_to');
    }

    public function followUps(): HasMany
    {
        return $this->hasMany(FollowUp::class);
    }

    public function counsellingRecords(): HasMany
    {
        return $this->hasMany(CounsellingRecord::class, 'counselled_by_id');
    }

    public function paymentsCollected(): HasMany
    {
        return $this->hasMany(Payment::class, 'collected_by_id');
    }

    public function paymentsRefunded(): HasMany
    {
        return $this->hasMany(Payment::class, 'refunded_by_id');
    }

    public function isAdmin(): bool
    {
        return $this->role === StaffRole::Admin;
    }

    public function isCounsellor(): bool
    {
        return $this->role === StaffRole::Counsellor;
    }
}
