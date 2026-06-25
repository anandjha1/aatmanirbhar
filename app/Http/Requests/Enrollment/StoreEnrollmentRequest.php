<?php

namespace App\Http\Requests\Enrollment;

use App\Enums\EnrollmentStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreEnrollmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'temp_id' => ['nullable', 'string', 'max:20'],
            'batch_id' => ['required', 'exists:batches,id'],
            'course_id' => ['required', 'exists:courses,id'],
            'counselling_record_id' => ['nullable', 'exists:counselling_records,id'],

            // Personal
            'full_name' => ['required', 'string', 'max:255'],
            'father_name' => ['nullable', 'string', 'max:255'],
            'mother_name' => ['nullable', 'string', 'max:255'],
            'gender' => ['nullable', Rule::in(['male', 'female', 'other'])],
            'dob' => ['nullable', 'date'],
            'category' => ['nullable', 'string', 'max:50'],
            'religion' => ['nullable', 'string', 'max:50'],
            'aadhaar_no' => ['nullable', 'string', 'size:12', 'regex:/^[0-9]{12}$/'],
            'phone' => ['required', 'string', 'max:15'],
            'email' => ['nullable', 'email'],

            // Address
            'house_no' => ['nullable', 'string', 'max:100'],
            'area' => ['nullable', 'string', 'max:200'],
            'district' => ['nullable', 'string', 'max:100'],
            'state' => ['nullable', 'string', 'max:100'],
            'pin_code' => ['nullable', 'string', 'max:10'],

            // Education
            'class10_year' => ['nullable', 'integer', 'min:1990', 'max:'.date('Y')],
            'class10_board' => ['nullable', 'string', 'max:100'],
            'class10_percentage' => ['nullable', 'string', 'max:20'],
            'class12_year' => ['nullable', 'integer', 'min:1990', 'max:'.date('Y')],
            'class12_board' => ['nullable', 'string', 'max:100'],
            'class12_percentage' => ['nullable', 'string', 'max:20'],

            // Work experience
            'company_name' => ['nullable', 'string', 'max:255'],
            'months_worked' => ['nullable', 'integer', 'min:0'],
            'company_location' => ['nullable', 'string', 'max:255'],
            'company2_name' => ['nullable', 'string', 'max:255'],
            'company2_months' => ['nullable', 'integer', 'min:0'],
            'company2_location' => ['nullable', 'string', 'max:255'],

            // Health
            'hospitalized_last_5_years' => ['sometimes', 'boolean'],
            'has_ailment' => ['sometimes', 'boolean'],
            'ailment_details' => ['nullable', 'string'],
            'on_medication' => ['sometimes', 'boolean'],
            'medical_notes' => ['nullable', 'string'],

            // Placement
            'interested_in_placement' => ['sometimes', 'boolean'],
            'interested_sector' => ['nullable', 'string', 'max:200'],

            // SIDH & Emergency
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
