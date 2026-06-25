<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FollowUpResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'enquiry_id' => $this->enquiry_id,
            'notes' => $this->notes,
            'follow_up_at' => $this->follow_up_at?->toDateTimeString(),
            'status' => $this->status->value,
            'status_label' => $this->status->label(),
            'next_follow_up_at' => $this->next_follow_up_at?->toDateTimeString(),
            'staff' => StaffResource::make($this->whenLoaded('staff')),
            'enquiry' => EnquiryResource::make($this->whenLoaded('enquiry')),
            'created_at' => $this->created_at?->toDateTimeString(),
        ];
    }
}
