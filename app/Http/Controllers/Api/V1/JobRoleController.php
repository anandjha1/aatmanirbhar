<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\JobRoleResource;
use App\Models\JobRole;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class JobRoleController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        return JobRoleResource::collection(JobRole::active()->orderBy('name')->get());
    }

    public function store(Request $request): JobRoleResource
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:job_roles,name'],
        ]);

        return JobRoleResource::make(JobRole::create($data));
    }

    public function show(JobRole $jobRole): JobRoleResource
    {
        return JobRoleResource::make($jobRole);
    }

    public function update(Request $request, JobRole $jobRole): JobRoleResource
    {
        $data = $request->validate([
            'name' => ['sometimes', 'string', 'max:255', 'unique:job_roles,name,'.$jobRole->id],
            'is_active' => ['sometimes', 'boolean'],
        ]);
        $jobRole->update($data);

        return JobRoleResource::make($jobRole->fresh());
    }

    public function destroy(JobRole $jobRole): JsonResponse
    {
        $jobRole->delete();

        return response()->json(['message' => 'Job role deleted.']);
    }
}
