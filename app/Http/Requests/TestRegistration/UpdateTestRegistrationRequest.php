<?php

namespace App\Http\Requests\TestRegistration;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTestRegistrationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'enquiry_id' => ['nullable', 'exists:enquiries,id'],
            'full_name' => ['sometimes', 'string', 'max:255'],
            'dob' => ['nullable', 'date', 'before:today'],
            'mobile' => ['sometimes', 'string', 'max:15'],
            'gender' => ['nullable', Rule::in(['male', 'female', 'other'])],
            'email' => ['nullable', 'email'],
            'qualification' => ['nullable', 'string', 'max:100'],
            'referral' => ['nullable', 'string', 'max:255'],
            'test_date' => ['sometimes', 'date'],
            'course_id' => ['nullable', 'exists:courses,id'],
        ];
    }
}
