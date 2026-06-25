<?php

namespace App\Http\Requests\TestRegistration;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreTestRegistrationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'enquiry_id' => ['nullable', 'exists:enquiries,id'],
            'full_name' => ['required', 'string', 'max:255'],
            'dob' => ['nullable', 'date', 'before:today'],
            'mobile' => ['required', 'string', 'max:15'],
            'gender' => ['nullable', Rule::in(['male', 'female', 'other'])],
            'email' => ['nullable', 'email'],
            'qualification' => ['nullable', 'string', 'max:100'],
            'referral' => ['nullable', 'string', 'max:255'],
            'test_date' => ['required', 'date'],
            'course_id' => ['nullable', 'exists:courses,id'],
        ];
    }
}
