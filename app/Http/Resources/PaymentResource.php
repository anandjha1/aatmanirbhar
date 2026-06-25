<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PaymentResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'enrollment_id' => $this->enrollment_id,
            'payment_type' => $this->payment_type->value,
            'payment_type_label' => $this->payment_type->label(),
            'amount' => $this->amount,
            'mode' => $this->mode->value,
            'mode_label' => $this->mode->label(),
            'transaction_no' => $this->transaction_no,
            'payment_medium' => $this->payment_medium,
            'collected_by' => StaffResource::make($this->whenLoaded('collectedBy')),
            'is_refunded' => $this->is_refunded,
            'refund' => $this->when($this->is_refunded, [
                'date' => $this->refund_date?->toDateString(),
                'mode' => $this->refund_mode?->value,
                'upi_id' => $this->refund_upi_id,
                'account_name' => $this->refund_account_name,
                'refunded_at' => $this->refunded_at?->toDateTimeString(),
                'refunded_by' => StaffResource::make($this->whenLoaded('refundedBy')),
                'notes' => $this->refund_notes,
            ]),
            'created_at' => $this->created_at?->toDateTimeString(),
        ];
    }
}
