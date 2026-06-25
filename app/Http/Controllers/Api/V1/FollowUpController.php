<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\FollowUp\StoreFollowUpRequest;
use App\Http\Requests\FollowUp\UpdateFollowUpRequest;
use App\Http\Resources\FollowUpResource;
use App\Models\Enquiry;
use App\Models\FollowUp;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class FollowUpController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $followUps = FollowUp::query()
            ->with(['enquiry', 'staff'])
            ->orderByDesc('follow_up_at')
            ->paginate(25);

        return FollowUpResource::collection($followUps);
    }

    public function store(StoreFollowUpRequest $request, Enquiry $enquiry): FollowUpResource
    {
        $followUp = $enquiry->followUps()->create([
            ...$request->validated(),
            'staff_id' => $request->user()->id,
        ]);

        return FollowUpResource::make($followUp->load(['enquiry', 'staff']));
    }

    public function show(FollowUp $followUp): FollowUpResource
    {
        return FollowUpResource::make($followUp->load(['enquiry', 'staff']));
    }

    public function update(UpdateFollowUpRequest $request, FollowUp $followUp): FollowUpResource
    {
        $followUp->update($request->validated());

        return FollowUpResource::make($followUp->fresh()->load(['enquiry', 'staff']));
    }

    public function destroy(FollowUp $followUp): JsonResponse
    {
        $followUp->delete();

        return response()->json(['message' => 'Follow-up deleted.']);
    }
}
