<?php

namespace App\Http\Requests\Enrollment;

use App\Enums\EnrollmentStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateEnrollmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'batch_id' => ['sometimes', 'exists:batches,id'],
            'course_id' => ['sometimes', 'exists:courses,id'],
            'counselling_record_id' => ['nullable', 'exists:counselling_records,id'],
            'full_name' => ['sometimes', 'string', 'max:255'],
            'father_name' => ['nullable', 'string', 'max:255'],
            'mother_name' => ['nullable', 'string', 'max:255'],
            'gender' => ['nullable', Rule::in(['male', 'female', 'other'])],
            'dob' => ['nullable', 'date'],
            'category' => ['nullable', 'string', 'max:50'],
            'religion' => ['nullable', 'string', 'max:50'],
            'aadhaar_no' => ['nullable', 'string', 'size:12', 'regex:/^[0-9]{12}$/'],
            'phone' => ['sometimes', 'string', 'max:15'],
            'email' => ['nullable', 'email'],
            'house_no' => ['nullable', 'string', 'max:100'],
            'area' => ['nullable', 'string', 'max:200'],
            'district' => ['nullable', 'string', 'max:100'],
            'state' => ['nullable', 'string', 'max:100'],
            'pin_code' => ['nullable', 'string', 'max:10'],
            'class10_year' => ['nullable', 'integer'],
            'class10_board' => ['nullable', 'string', 'max:100'],
            'class10_percentage' => ['nullable', 'string', 'max:20'],
            'class12_year' => ['nullable', 'integer'],
            'class12_board' => ['nullable', 'string', 'max:100'],
            'class12_percentage' => ['nullable', 'string', 'max:20'],
            'company_name' => ['nullable', 'string', 'max:255'],
            'months_worked' => ['nullable', 'integer', 'min:0'],
            'company_location' => ['nullable', 'string', 'max:255'],
            'company2_name' => ['nullable', 'string', 'max:255'],
            'company2_months' => ['nullable', 'integer', 'min:0'],
            'company2_location' => ['nullable', 'string', 'max:255'],
            'hospitalized_last_5_years' => ['sometimes', 'boolean'],
            'has_ailment' => ['sometimes', 'boolean'],
            'ailment_details' => ['nullable', 'string'],
            'on_medication' => ['sometimes', 'boolean'],
            'medical_notes' => ['nullable', 'string'],
            'interested_in_placement' => ['sometimes', 'boolean'],
            'interested_sector' => ['nullable', 'string', 'max:200'],
            'emergency_contact' => ['nullable', 'string', 'max:15'],
            'sidh_profile_link' => ['nullable', 'url'],
            'candidate_id' => ['nullable', 'string', 'max:50'],
            'sidh_mobile' => ['nullable', 'string', 'max:15'],
            'sidh_name' => ['nullable', 'string', 'max:255'],
            'sidh_ekyc_done' => ['sometimes', 'boolean'],
            'status' => ['sometimes', Rule::enum(EnrollmentStatus::class)],
        ];
    }
}
