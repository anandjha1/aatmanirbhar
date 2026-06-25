<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\TestResponse\StoreTestResponseRequest;
use App\Http\Resources\TestResponseResource;
use App\Models\TestRegistration;
use App\Models\TestResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class TestResponseController extends Controller
{
    public function store(StoreTestResponseRequest $request, TestRegistration $testRegistration): TestResponseResource
    {
        $data = $request->validated();
        $data['temp_id'] = $testRegistration->temp_id;

        $response = $testRegistration->testResponse()->updateOrCreate(
            ['test_registration_id' => $testRegistration->id],
            $data
        );

        return TestResponseResource::make($response->load('testRegistration'));
    }

    public function show(TestRegistration $testRegistration): TestResponseResource
    {
        $response = $testRegistration->testResponse()->firstOrFail();

        return TestResponseResource::make($response->load('testRegistration'));
    }

    public function index(): AnonymousResourceCollection
    {
        $responses = TestResponse::query()
            ->with('testRegistration')
            ->orderByDesc('id')
            ->paginate(25);

        return TestResponseResource::collection($responses);
    }
}
