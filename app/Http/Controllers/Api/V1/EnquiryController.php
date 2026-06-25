<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Enquiry\StoreEnquiryRequest;
use App\Http\Requests\Enquiry\UpdateEnquiryRequest;
use App\Http\Resources\EnquiryResource;
use App\Http\Resources\FollowUpResource;
use App\Models\Enquiry;
use App\Services\NotificationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class EnquiryController extends Controller
{
    public function __construct(protected NotificationService $notifications) {}

    public function index(Request $request): AnonymousResourceCollection
    {
        $enquiries = Enquiry::query()
            ->with(['assignedStaff', 'interestedCourse'])
            ->when($request->filled('status'), fn ($q) => $q->where('status', $request->status))
            ->when($request->filled('source'), fn ($q) => $q->where('source', $request->source))
            ->when($request->filled('assigned_to'), fn ($q) => $q->where('assigned_to', $request->assigned_to))
            ->when($request->filled('search'), function ($q) use ($request) {
                $q->where(function ($q2) use ($request) {
                    $q2->where('full_name', 'like', "%{$request->search}%")
                        ->orWhere('mobile', 'like', "%{$request->search}%");
                });
            })
            ->orderByDesc('id')
            ->paginate(25);

        return EnquiryResource::collection($enquiries);
    }

    public function store(StoreEnquiryRequest $request): EnquiryResource
    {
        $enquiry = Enquiry::create($request->validated());

        $this->notifications->notifyNewEnquiry($enquiry);

        return EnquiryResource::make($enquiry->load(['assignedStaff', 'interestedCourse']));
    }

    public function show(Enquiry $enquiry): EnquiryResource
    {
        return EnquiryResource::make(
            $enquiry->load(['assignedStaff', 'interestedCourse', 'followUps.staff', 'testRegistration'])
        );
    }

    public function update(UpdateEnquiryRequest $request, Enquiry $enquiry): EnquiryResource
    {
        $enquiry->update($request->validated());

        return EnquiryResource::make($enquiry->fresh()->load(['assignedStaff', 'interestedCourse']));
    }

    public function destroy(Enquiry $enquiry): JsonResponse
    {
        $enquiry->delete();

        return response()->json(['message' => 'Enquiry deleted.']);
    }

    public function followUps(Enquiry $enquiry): AnonymousResourceCollection
    {
        $followUps = $enquiry->followUps()
            ->with('staff')
            ->orderByDesc('follow_up_at')
            ->get();

        return FollowUpResource::collection($followUps);
    }
}
