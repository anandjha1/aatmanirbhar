<?php

namespace App\Http\Requests\Batch;

use App\Enums\BatchStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateBatchRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'course_id' => ['sometimes', 'exists:courses,id'],
            'name' => ['sometimes', 'string', 'max:255'],
            'timing' => ['nullable', 'string', 'max:50'],
            'start_date' => ['sometimes', 'date'],
            'end_date' => ['nullable', 'date', 'after:start_date'],
            'capacity' => ['sometimes', 'integer', 'min:1', 'max:500'],
            'status' => ['sometimes', Rule::enum(BatchStatus::class)],
        ];
    }
}
