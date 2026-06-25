<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Payment\RefundPaymentRequest;
use App\Http\Requests\Payment\StorePaymentRequest;
use App\Http\Resources\PaymentResource;
use App\Models\Enrollment;
use App\Models\Payment;

class PaymentController extends Controller
{
    public function store(StorePaymentRequest $request, Enrollment $enrollment): PaymentResource
    {
        $payment = $enrollment->payments()->create([
            ...$request->validated(),
            'collected_by_id' => $request->user()->id,
        ]);

        return PaymentResource::make($payment->load(['collectedBy']));
    }

    public function show(Payment $payment): PaymentResource
    {
        return PaymentResource::make($payment->load(['collectedBy', 'refundedBy', 'enrollment']));
    }

    public function refund(RefundPaymentRequest $request, Payment $payment): PaymentResource
    {
        abort_unless($request->user()->isAdmin(), 403, 'Only admins can process refunds.');

        abort_if($payment->is_refunded, 409, 'Payment has already been refunded.');
        abort_unless($payment->isSecurityDeposit(), 422, 'Only security deposits can be refunded.');

        $payment->update([
            ...$request->validated(),
            'is_refunded' => true,
            'refunded_at' => now(),
            'refunded_by_id' => $request->user()->id,
        ]);

        return PaymentResource::make($payment->fresh()->load(['refundedBy']));
    }
}
