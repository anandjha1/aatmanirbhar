<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\TestRegistration\StoreTestRegistrationRequest;
use App\Http\Requests\TestRegistration\UpdateTestRegistrationRequest;
use App\Http\Resources\TestRegistrationResource;
use App\Models\TestRegistration;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class TestRegistrationController extends Controller
{
    public function index(Request $request): AnonymousResourceCollection
    {
        $registrations = TestRegistration::query()
            ->with(['enquiry', 'course', 'testResponse'])
            ->when($request->filled('test_date'), fn ($q) => $q->whereDate('test_date', $request->test_date))
            ->when($request->filled('course_id'), fn ($q) => $q->where('course_id', $request->course_id))
            ->when($request->filled('search'), function ($q) use ($request) {
                $q->where(function ($q2) use ($request) {
                    $q2->where('full_name', 'like', "%{$request->search}%")
                        ->orWhere('mobile', 'like', "%{$request->search}%")
                        ->orWhere('temp_id', 'like', "%{$request->search}%");
                });
            })
            ->orderByDesc('test_date')
            ->paginate(25);

        return TestRegistrationResource::collection($registrations);
    }

    public function store(StoreTestRegistrationRequest $request): TestRegistrationResource
    {
        $registration = TestRegistration::create($request->validated());

        return TestRegistrationResource::make($registration->load(['enquiry', 'course', 'testResponse']));
    }

    public function show(TestRegistration $testRegistration): TestRegistrationResource
    {
        return TestRegistrationResource::make(
            $testRegistration->load(['enquiry', 'course', 'testResponse', 'counsellingRecord'])
        );
    }

    public function update(UpdateTestRegistrationRequest $request, TestRegistration $testRegistration): TestRegistrationResource
    {
        $testRegistration->update($request->validated());

        return TestRegistrationResource::make($testRegistration->fresh()->load(['enquiry', 'course']));
    }

    public function destroy(TestRegistration $testRegistration): JsonResponse
    {
        $testRegistration->delete();

        return response()->json(['message' => 'Test registration deleted.']);
    }
}
