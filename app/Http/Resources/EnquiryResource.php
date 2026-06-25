<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EnquiryResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'full_name' => $this->full_name,
            'mobile' => $this->mobile,
            'email' => $this->email,
            'dob' => $this->dob?->toDateString(),
            'gender' => $this->gender,
            'qualification' => $this->qualification,
            'source' => $this->source->value,
            'source_label' => $this->source->label(),
            'referral_enrollment_id' => $this->referral_enrollment_id,
            'referral_name' => $this->referral_name,
            'status' => $this->status->value,
            'status_label' => $this->status->label(),
            'remarks' => $this->remarks,
            'assigned_staff' => StaffResource::make($this->whenLoaded('assignedStaff')),
            'interested_course' => CourseResource::make($this->whenLoaded('interestedCourse')),
            'follow_ups' => FollowUpResource::collection($this->whenLoaded('followUps')),
            'test_registration' => TestRegistrationResource::make($this->whenLoaded('testRegistration')),
            'created_at' => $this->created_at?->toDateTimeString(),
            'updated_at' => $this->updated_at?->toDateTimeString(),
        ];
    }
}
