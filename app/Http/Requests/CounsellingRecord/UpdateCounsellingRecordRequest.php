<?php

namespace App\Http\Requests\CounsellingRecord;

use App\Enums\CounsellingStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCounsellingRecordRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'status' => ['sometimes', Rule::enum(CounsellingStatus::class)],
            'full_name' => ['sometimes', 'string', 'max:255'],
            'mobile' => ['sometimes', 'string', 'max:15'],
            'email' => ['nullable', 'email'],
            'dob' => ['nullable', 'date'],
            'test_result' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'batch_selected' => ['nullable', 'string', 'max:100'],
            'ref_no' => ['nullable', 'string', 'max:50'],
            'current_status' => ['nullable', 'string', 'max:100'],
            'year_of_completion' => ['nullable', 'integer', 'min:1990', 'max:'.date('Y')],
            'father_occupation' => ['nullable', 'string', 'max:100'],
            'mother_occupation' => ['nullable', 'string', 'max:100'],
            'first_aim' => ['nullable', 'string', 'max:200'],
            'second_aim' => ['nullable', 'string', 'max:200'],
            'purpose_of_training' => ['nullable', 'string'],
            'need_job' => ['sometimes', 'boolean'],
            'job_location_preference' => ['nullable', 'string', 'max:200'],
            'has_experience' => ['sometimes', 'boolean'],
            'experience_details' => ['nullable', 'string'],
            'remarks' => ['nullable', 'string'],
            'counselled_by_id' => ['nullable', 'exists:staff,id'],
            'counselled_with' => ['nullable', 'string', 'max:255'],
        ];
    }
}
