<?php

namespace App\Http\Requests\TestResponse;

use Illuminate\Foundation\Http\FormRequest;

class StoreTestResponseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'score' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'batch_selected' => ['nullable', 'string', 'max:100'],
            'time_taken_seconds' => ['nullable', 'integer', 'min:0'],
        ];
    }
}
