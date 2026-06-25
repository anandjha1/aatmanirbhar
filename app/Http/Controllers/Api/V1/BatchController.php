<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Batch\StoreBatchRequest;
use App\Http\Requests\Batch\UpdateBatchRequest;
use App\Http\Resources\BatchResource;
use App\Http\Resources\EnrollmentResource;
use App\Models\Batch;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class BatchController extends Controller
{
    public function index(Request $request): AnonymousResourceCollection
    {
        $batches = Batch::query()
            ->with('course')
            ->when($request->filled('status'), fn ($q) => $q->where('status', $request->status))
            ->when($request->filled('course_id'), fn ($q) => $q->where('course_id', $request->course_id))
            ->orderByDesc('start_date')
            ->get();

        return BatchResource::collection($batches);
    }

    public function store(StoreBatchRequest $request): BatchResource
    {
        $batch = Batch::create($request->validated());

        return BatchResource::make($batch->load('course'));
    }

    public function show(Batch $batch): BatchResource
    {
        return BatchResource::make($batch->load(['course', 'members.enrollment']));
    }

    public function update(UpdateBatchRequest $request, Batch $batch): BatchResource
    {
        $batch->update($request->validated());

        return BatchResource::make($batch->fresh()->load('course'));
    }

    public function destroy(Batch $batch): JsonResponse
    {
        $batch->delete();

        return response()->json(['message' => 'Batch deleted.']);
    }

    public function members(Batch $batch): AnonymousResourceCollection
    {
        $enrollments = $batch->enrollments()
            ->with(['course', 'batchMember'])
            ->orderBy('full_name')
            ->get();

        return EnrollmentResource::collection($enrollments);
    }
}
