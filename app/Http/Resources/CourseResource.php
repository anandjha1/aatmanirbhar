<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CourseResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'code' => $this->code,
            'duration_months' => $this->duration_months,
            'fee' => $this->fee,
            'security_deposit_amount' => $this->security_deposit_amount,
            'description' => $this->description,
            'is_active' => $this->is_active,
            'batches' => BatchResource::collection($this->whenLoaded('batches')),
            'created_at' => $this->created_at?->toDateString(),
        ];
    }
}
