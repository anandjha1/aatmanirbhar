<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TestRegistrationResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'temp_id' => $this->temp_id,
            'full_name' => $this->full_name,
            'dob' => $this->dob?->toDateString(),
            'mobile' => $this->mobile,
            'gender' => $this->gender,
            'email' => $this->email,
            'qualification' => $this->qualification,
            'referral' => $this->referral,
            'test_date' => $this->test_date?->toDateString(),
            'enquiry_id' => $this->enquiry_id,
            'enquiry' => EnquiryResource::make($this->whenLoaded('enquiry')),
            'course' => CourseResource::make($this->whenLoaded('course')),
            'test_response' => TestResponseResource::make($this->whenLoaded('testResponse')),
            'created_at' => $this->created_at?->toDateTimeString(),
        ];
    }
}
