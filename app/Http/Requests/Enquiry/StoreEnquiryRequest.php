<?php

namespace App\Http\Requests\Enquiry;

use App\Enums\EnquirySource;
use App\Enums\EnquiryStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreEnquiryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'full_name' => ['required', 'string', 'max:255'],
            'mobile' => ['required', 'string', 'max:15'],
            'email' => ['nullable', 'email'],
            'dob' => ['nullable', 'date', 'before:today'],
            'gender' => ['nullable', Rule::in(['male', 'female', 'other'])],
            'qualification' => ['nullable', 'string', 'max:100'],
            'source' => ['required', Rule::enum(EnquirySource::class)],
            'referral_enrollment_id' => ['nullable', 'exists:enrollments,id'],
            'referral_name' => ['nullable', 'string', 'max:255'],
            'interested_course_id' => ['nullable', 'exists:courses,id'],
            'status' => ['sometimes', Rule::enum(EnquiryStatus::class)],
            'assigned_to' => ['nullable', 'exists:staff,id'],
            'remarks' => ['nullable', 'string'],
        ];
    }
}
