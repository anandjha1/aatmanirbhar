<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Enrollment\StoreEnrollmentRequest;
use App\Http\Requests\Enrollment\UpdateEnrollmentRequest;
use App\Http\Resources\EnrollmentResource;
use App\Http\Resources\PaymentResource;
use App\Models\Enrollment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class EnrollmentController extends Controller
{
    public function index(Request $request): AnonymousResourceCollection
    {
        $enrollments = Enrollment::query()
            ->with(['batch.course', 'detailsFilledBy'])
            ->when($request->filled('batch_id'), fn ($q) => $q->where('batch_id', $request->batch_id))
            ->when($request->filled('status'), fn ($q) => $q->where('status', $request->status))
            ->when($request->filled('search'), function ($q) use ($request) {
                $q->where(function ($q2) use ($request) {
                    $q2->where('full_name', 'like', "%{$request->search}%")
                        ->orWhere('phone', 'like', "%{$request->search}%")
                        ->orWhere('temp_id', 'like', "%{$request->search}%")
                        ->orWhere('candidate_id', 'like', "%{$request->search}%");
                });
            })
            ->orderByDesc('id')
            ->paginate(25);

        return EnrollmentResource::collection($enrollments);
    }

    public function store(StoreEnrollmentRequest $request): EnrollmentResource
    {
        $enrollment = Enrollment::create([
            ...$request->validated(),
            'details_filled_by_id' => $request->user()->id,
        ]);

        // Auto-create batch member record
        $enrollment->batchMember()->create([
            'batch_id' => $enrollment->batch_id,
            'joined_at' => now()->toDateString(),
        ]);

        return EnrollmentResource::make($enrollment->load(['batch.course', 'payments', 'batchMember']));
    }

    public function show(Enrollment $enrollment): EnrollmentResource
    {
        return EnrollmentResource::make(
            $enrollment->load(['batch.course', 'counsellingRecord', 'payments', 'batchMember', 'detailsFilledBy'])
        );
    }

    public function update(UpdateEnrollmentRequest $request, Enrollment $enrollment): EnrollmentResource
    {
        $enrollment->update($request->validated());

        return EnrollmentResource::make($enrollment->fresh()->load(['batch.course']));
    }

    public function destroy(Enrollment $enrollment): JsonResponse
    {
        $enrollment->delete();

        return response()->json(['message' => 'Enrollment deleted.']);
    }

    public function payments(Enrollment $enrollment): AnonymousResourceCollection
    {
        return PaymentResource::collection($enrollment->payments()->with('collectedBy')->get());
    }
}
