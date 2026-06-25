<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\CounsellingRecord\StoreCounsellingRecordRequest;
use App\Http\Requests\CounsellingRecord\UpdateCounsellingRecordRequest;
use App\Http\Resources\CounsellingRecordResource;
use App\Models\CounsellingRecord;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CounsellingRecordController extends Controller
{
    public function index(Request $request): AnonymousResourceCollection
    {
        $records = CounsellingRecord::query()
            ->with(['counselledBy', 'testRegistration'])
            ->when($request->filled('status'), fn ($q) => $q->where('status', $request->status))
            ->when($request->filled('search'), function ($q) use ($request) {
                $q->where(function ($q2) use ($request) {
                    $q2->where('full_name', 'like', "%{$request->search}%")
                        ->orWhere('mobile', 'like', "%{$request->search}%")
                        ->orWhere('temp_id', 'like', "%{$request->search}%");
                });
            })
            ->orderByDesc('id')
            ->paginate(25);

        return CounsellingRecordResource::collection($records);
    }

    public function store(StoreCounsellingRecordRequest $request): CounsellingRecordResource
    {
        $record = CounsellingRecord::create([
            ...$request->validated(),
            'counselled_by_id' => $request->validated()['counselled_by_id'] ?? $request->user()->id,
        ]);

        return CounsellingRecordResource::make($record->load(['counselledBy', 'testRegistration']));
    }

    public function show(CounsellingRecord $counsellingRecord): CounsellingRecordResource
    {
        return CounsellingRecordResource::make(
            $counsellingRecord->load(['counselledBy', 'testRegistration', 'enrollment'])
        );
    }

    public function update(UpdateCounsellingRecordRequest $request, CounsellingRecord $counsellingRecord): CounsellingRecordResource
    {
        $counsellingRecord->update($request->validated());

        return CounsellingRecordResource::make($counsellingRecord->fresh()->load(['counselledBy']));
    }

    public function destroy(CounsellingRecord $counsellingRecord): JsonResponse
    {
        $counsellingRecord->delete();

        return response()->json(['message' => 'Counselling record deleted.']);
    }
}
