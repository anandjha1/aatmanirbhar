<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Staff\StoreStaffRequest;
use App\Http\Requests\Staff\UpdateStaffRequest;
use App\Http\Resources\StaffResource;
use App\Models\Staff;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Gate;

class StaffController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        Gate::authorize('viewAny', Staff::class);

        $staff = Staff::orderByDesc('id')->get();

        return StaffResource::collection($staff);
    }

    public function store(StoreStaffRequest $request): StaffResource
    {
        Gate::authorize('create', Staff::class);

        $staff = Staff::create($request->validated());

        return StaffResource::make($staff);
    }

    public function show(Staff $staff): StaffResource
    {
        Gate::authorize('view', $staff);

        return StaffResource::make($staff);
    }

    public function update(UpdateStaffRequest $request, Staff $staff): StaffResource
    {
        Gate::authorize('update', $staff);

        $staff->update($request->validated());

        return StaffResource::make($staff->fresh());
    }

    public function toggleActive(Staff $staff): JsonResponse
    {
        Gate::authorize('update', $staff);

        $staff->update(['is_active' => ! $staff->is_active]);

        return response()->json([
            'message' => 'Staff status updated.',
            'is_active' => $staff->fresh()->is_active,
        ]);
    }
}
