<?php

namespace App\Http\Requests\Payment;

use App\Enums\PaymentMode;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RefundPaymentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'refund_date' => ['required', 'date'],
            'refund_mode' => ['required', Rule::enum(PaymentMode::class)],
            'refund_upi_id' => ['nullable', 'string', 'max:255'],
            'refund_account_name' => ['nullable', 'string', 'max:200'],
            'refund_notes' => ['nullable', 'string'],
        ];
    }
}
