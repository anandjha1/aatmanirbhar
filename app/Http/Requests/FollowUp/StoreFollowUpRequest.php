<?php

namespace App\Http\Requests\FollowUp;

use App\Enums\FollowUpStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreFollowUpRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'notes' => ['nullable', 'string'],
            'follow_up_at' => ['required', 'date'],
            'status' => ['sometimes', Rule::enum(FollowUpStatus::class)],
            'next_follow_up_at' => ['nullable', 'date', 'after:follow_up_at'],
        ];
    }
}
