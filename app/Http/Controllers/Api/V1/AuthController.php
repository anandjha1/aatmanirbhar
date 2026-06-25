<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\StaffResource;
use App\Models\Staff;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(LoginRequest $request): JsonResponse
    {
        $staff = Staff::where('email', $request->email)->first();

        if (! $staff || ! Hash::check($request->password, $staff->password)) {
            return response()->json(['message' => 'Invalid credentials.'], 401);
        }

        if (! $staff->is_active) {
            return response()->json(['message' => 'Account is deactivated.'], 403);
        }

        $token = $staff->createToken('api-token')->plainTextToken;

        return response()->json([
            'token' => $token,
            'staff' => StaffResource::make($staff),
        ]);
    }

    public function me(Request $request): StaffResource
    {
        return StaffResource::make($request->user());
    }

    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logged out successfully.']);
    }
}
