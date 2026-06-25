<?php

namespace App\Http\Requests\Payment;

use App\Enums\PaymentMode;
use App\Enums\PaymentType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePaymentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'payment_type' => ['required', Rule::enum(PaymentType::class)],
            'amount' => ['required', 'integer', 'min:1'],
            'mode' => ['required', Rule::enum(PaymentMode::class)],
            'transaction_no' => ['nullable', 'string', 'max:100'],
            'payment_medium' => ['nullable', 'string', 'max:100'],
        ];
    }
}
