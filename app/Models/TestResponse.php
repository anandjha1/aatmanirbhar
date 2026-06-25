<?php

namespace App\Models;

use Database\Factories\TestResponseFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TestResponse extends Model
{
    /** @use HasFactory<TestResponseFactory> */
    use HasFactory;

    protected $fillable = [
        'test_registration_id',
        'temp_id',
        'score',
        'batch_selected',
        'time_taken_seconds',
    ];

    protected function casts(): array
    {
        return [
            'score' => 'decimal:2',
            'time_taken_seconds' => 'integer',
        ];
    }

    public function testRegistration(): BelongsTo
    {
        return $this->belongsTo(TestRegistration::class);
    }
}
