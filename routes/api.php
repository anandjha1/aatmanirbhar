<?php

use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\BatchController;
use App\Http\Controllers\Api\V1\CounsellingRecordController;
use App\Http\Controllers\Api\V1\CourseController;
use App\Http\Controllers\Api\V1\DashboardController;
use App\Http\Controllers\Api\V1\EnquiryController;
use App\Http\Controllers\Api\V1\EnrollmentController;
use App\Http\Controllers\Api\V1\FollowUpController;
use App\Http\Controllers\Api\V1\ImportController;
use App\Http\Controllers\Api\V1\JobRoleController;
use App\Http\Controllers\Api\V1\PaymentController;
use App\Http\Controllers\Api\V1\StaffController;
use App\Http\Controllers\Api\V1\TestRegistrationController;
use App\Http\Controllers\Api\V1\TestResponseController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {

    // Health check
    Route::get('/', fn () => ['msg' => 'Training Center API v1 — server is up and running.']);

    /*
    |--------------------------------------------------------------------------
    | Authentication (public)
    |--------------------------------------------------------------------------
    */
    Route::prefix('auth')->group(function () {
        Route::post('login', [AuthController::class, 'login']);
    });

    /*
    |--------------------------------------------------------------------------
    | Protected Routes (require Sanctum token)
    |--------------------------------------------------------------------------
    */
    Route::middleware('auth:sanctum')->group(function () {

        // Auth
        Route::prefix('auth')->group(function () {
            Route::get('me', [AuthController::class, 'me']);
            Route::post('logout', [AuthController::class, 'logout']);
        });

        // Dashboard
        Route::get('dashboard/summary', [DashboardController::class, 'summary']);

        // Staff management (admin only — enforce in policy/controller)
        Route::apiResource('staff', StaffController::class);
        Route::put('staff/{staff}/toggle-active', [StaffController::class, 'toggleActive']);

        // Courses & Batches
        Route::apiResource('courses', CourseController::class);
        Route::apiResource('batches', BatchController::class);
        Route::get('batches/{batch}/members', [BatchController::class, 'members']);

        // Job Roles (lookup)
        Route::apiResource('job-roles', JobRoleController::class);

        // CRM — Enquiries & Follow-ups
        Route::apiResource('enquiries', EnquiryController::class);
        Route::get('enquiries/{enquiry}/follow-ups', [EnquiryController::class, 'followUps']);
        Route::post('enquiries/{enquiry}/follow-ups', [FollowUpController::class, 'store']);
        Route::apiResource('follow-ups', FollowUpController::class)->except(['store']);

        // Test Management
        Route::apiResource('test-registrations', TestRegistrationController::class);
        Route::get('test-registrations/{testRegistration}/response', [TestResponseController::class, 'show']);
        Route::post('test-registrations/{testRegistration}/response', [TestResponseController::class, 'store']);
        Route::get('test-responses', [TestResponseController::class, 'index']);

        // Counselling
        Route::apiResource('counselling', CounsellingRecordController::class);

        // Enrollment
        Route::apiResource('enrollments', EnrollmentController::class);
        Route::get('enrollments/{enrollment}/payments', [EnrollmentController::class, 'payments']);
        Route::post('enrollments/{enrollment}/payments', [PaymentController::class, 'store']);
        Route::get('payments/{payment}', [PaymentController::class, 'show']);
        Route::post('payments/{payment}/refund', [PaymentController::class, 'refund']);

        // Data Import (Admin only)
        Route::prefix('import')->group(function () {
            Route::post('test-registrations', [ImportController::class, 'testRegistrations']);
            Route::post('counselling', [ImportController::class, 'counselling']);
            Route::post('enrollments', [ImportController::class, 'enrollments']);
        });
    });
});
