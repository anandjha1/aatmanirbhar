<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Batch;
use App\Models\CounsellingRecord;
use App\Models\Enquiry;
use App\Models\Enrollment;
use App\Models\FollowUp;
use App\Models\Payment;
use App\Models\TestRegistration;
use Illuminate\Http\JsonResponse;

class DashboardController extends Controller
{
    public function summary(): JsonResponse
    {
        return response()->json([
            'enquiries' => [
                'total' => Enquiry::count(),
                'new' => Enquiry::where('status', 'new')->count(),
                'follow_up' => Enquiry::where('status', 'follow_up')->count(),
                'test_scheduled' => Enquiry::where('status', 'test_scheduled')->count(),
                'enrolled' => Enquiry::where('status', 'enrolled')->count(),
                'dropped' => Enquiry::where('status', 'dropped')->count(),
            ],
            'follow_ups' => [
                'due_today' => FollowUp::dueToday()->pending()->count(),
                'overdue' => FollowUp::overdue()->count(),
            ],
            'tests' => [
                'total_registered' => TestRegistration::count(),
                'today' => TestRegistration::whereDate('test_date', today())->count(),
            ],
            'counselling' => [
                'pending' => CounsellingRecord::where('status', 'pending')->count(),
                'visited' => CounsellingRecord::where('status', 'visited')->count(),
            ],
            'enrollments' => [
                'total' => Enrollment::count(),
                'active' => Enrollment::where('status', 'active')->count(),
            ],
            'batches' => Batch::query()
                ->with('course')
                ->active()
                ->withCount(['members' => fn ($q) => $q->where('status', 'active')])
                ->get()
                ->map(fn ($b) => [
                    'id' => $b->id,
                    'name' => $b->name,
                    'course' => $b->course->name,
                    'timing' => $b->timing,
                    'capacity' => $b->capacity,
                    'enrolled' => $b->members_count,
                    'remaining' => $b->capacity - $b->members_count,
                ]),
            'payments' => [
                'pending_security_refunds' => Payment::pendingRefunds()->count(),
            ],
        ]);
    }
}
