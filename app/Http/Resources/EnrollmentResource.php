<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EnrollmentResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'temp_id' => $this->temp_id,
            'status' => $this->status->value,
            'status_label' => $this->status->label(),
            'full_name' => $this->full_name,
            'father_name' => $this->father_name,
            'mother_name' => $this->mother_name,
            'gender' => $this->gender,
            'dob' => $this->dob?->toDateString(),
            'category' => $this->category,
            'religion' => $this->religion,
            'phone' => $this->phone,
            'email' => $this->email,
            'address' => [
                'house_no' => $this->house_no,
                'area' => $this->area,
                'district' => $this->district,
                'state' => $this->state,
                'pin_code' => $this->pin_code,
            ],
            'education' => [
                'class10_year' => $this->class10_year,
                'class10_board' => $this->class10_board,
                'class10_percentage' => $this->class10_percentage,
                'class12_year' => $this->class12_year,
                'class12_board' => $this->class12_board,
                'class12_percentage' => $this->class12_percentage,
            ],
            'work_experience' => [
                'company_name' => $this->company_name,
                'months_worked' => $this->months_worked,
                'company_location' => $this->company_location,
                'company2_name' => $this->company2_name,
                'company2_months' => $this->company2_months,
                'company2_location' => $this->company2_location,
            ],
            'health' => [
                'hospitalized_last_5_years' => $this->hospitalized_last_5_years,
                'has_ailment' => $this->has_ailment,
                'ailment_details' => $this->ailment_details,
                'on_medication' => $this->on_medication,
                'medical_notes' => $this->medical_notes,
            ],
            'placement' => [
                'interested_in_placement' => $this->interested_in_placement,
                'interested_sector' => $this->interested_sector,
            ],
            'sidh' => [
                'candidate_id' => $this->candidate_id,
                'sidh_profile_link' => $this->sidh_profile_link,
                'sidh_mobile' => $this->sidh_mobile,
                'sidh_name' => $this->sidh_name,
                'sidh_ekyc_done' => $this->sidh_ekyc_done,
            ],
            'emergency_contact' => $this->emergency_contact,
            'batch' => BatchResource::make($this->whenLoaded('batch')),
            'course' => CourseResource::make($this->whenLoaded('course')),
            'payments' => PaymentResource::collection($this->whenLoaded('payments')),
            'batch_member' => $this->whenLoaded('batchMember'),
            'details_filled_by' => StaffResource::make($this->whenLoaded('detailsFilledBy')),
            'created_at' => $this->created_at?->toDateTimeString(),
            'updated_at' => $this->updated_at?->toDateTimeString(),
        ];
    }
}
