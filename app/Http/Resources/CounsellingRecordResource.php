<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CounsellingRecordResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'temp_id' => $this->temp_id,
            'status' => $this->status->value,
            'status_label' => $this->status->label(),
            'full_name' => $this->full_name,
            'mobile' => $this->mobile,
            'email' => $this->email,
            'dob' => $this->dob?->toDateString(),
            'test_result' => $this->test_result,
            'batch_selected' => $this->batch_selected,
            'ref_no' => $this->ref_no,
            'current_status' => $this->current_status,
            'year_of_completion' => $this->year_of_completion,
            'father_occupation' => $this->father_occupation,
            'mother_occupation' => $this->mother_occupation,
            'first_aim' => $this->first_aim,
            'second_aim' => $this->second_aim,
            'purpose_of_training' => $this->purpose_of_training,
            'need_job' => $this->need_job,
            'job_location_preference' => $this->job_location_preference,
            'has_experience' => $this->has_experience,
            'experience_details' => $this->experience_details,
            'remarks' => $this->remarks,
            'counselled_with' => $this->counselled_with,
            'counselled_by' => StaffResource::make($this->whenLoaded('counselledBy')),
            'test_registration' => TestRegistrationResource::make($this->whenLoaded('testRegistration')),
            'enrollment' => EnrollmentResource::make($this->whenLoaded('enrollment')),
            'created_at' => $this->created_at?->toDateTimeString(),
            'updated_at' => $this->updated_at?->toDateTimeString(),
        ];
    }
}
