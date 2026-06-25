<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TestResponseResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'temp_id' => $this->temp_id,
            'score' => $this->score,
            'batch_selected' => $this->batch_selected,
            'time_taken_seconds' => $this->time_taken_seconds,
            'test_registration' => TestRegistrationResource::make($this->whenLoaded('testRegistration')),
            'created_at' => $this->created_at?->toDateTimeString(),
        ];
    }
}
