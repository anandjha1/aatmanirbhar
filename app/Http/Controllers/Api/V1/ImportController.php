<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\CounsellingRecord;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Staff;
use App\Models\TestRegistration;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class ImportController extends Controller
{
    public function testRegistrations(Request $request): JsonResponse
    {
        Gate::authorize('create', Staff::class); // Simple admin check

        $request->validate(['file' => 'required|file|mimes:csv,txt']);

        $path = $request->file('file')->getRealPath();
        $data = array_map('str_getcsv', file($path));
        $header = array_shift($data);

        $count = 0;
        DB::transaction(function () use ($data, $header, &$count) {
            foreach ($data as $row) {
                if (count($row) < 5) {
                    continue;
                }
                $line = array_combine($header, $row);

                // Mapping based on Test Register Sheet: Temp ID, Timestamp, FullName, DOB, Mobile, Gender, Email, Qualification, Refferal, Test Date Selected
                TestRegistration::create([
                    'temp_id' => $line['Temp ID'] ?? null,
                    'full_name' => $line['FullName'] ?? $line['Full Name'] ?? 'Unknown',
                    'dob' => $this->parseDate($line['DOB'] ?? null),
                    'mobile' => $line['Mobile'] ?? '0000000000',
                    'gender' => strtolower($line['Gender'] ?? 'other'),
                    'email' => $line['Email'] ?? null,
                    'qualification' => $line['Qualification'] ?? null,
                    'referral' => $line['Refferal'] ?? $line['Referral'] ?? null,
                    'test_date' => $this->parseDate($line['Test Date Selected'] ?? null) ?? now(),
                ]);
                $count++;
            }
        });

        return response()->json(['message' => "$count test registrations imported."]);
    }

    public function counselling(Request $request): JsonResponse
    {
        Gate::authorize('create', Staff::class);

        $request->validate(['file' => 'required|file|mimes:csv,txt']);

        $path = $request->file('file')->getRealPath();
        $data = array_map('str_getcsv', file($path));
        $header = array_shift($data);

        $count = 0;
        DB::transaction(function () use ($data, $header, &$count) {
            foreach ($data as $row) {
                if (count($row) < 5) {
                    continue;
                }
                $line = array_combine($header, $row);

                CounsellingRecord::create([
                    'temp_id' => $line['TempID'] ?? $line['Temp ID'] ?? null,
                    'full_name' => $line['Full Name'] ?? 'Unknown',
                    'dob' => $this->parseDate($line['DOB'] ?? null),
                    'mobile' => $line['Mobile'] ?? '0000000000',
                    'email' => $line['Email'] ?? null,
                    'test_result' => $line['Test Result'] ?? null,
                    'batch_selected' => $line['Batch Selected'] ?? null,
                    'ref_no' => $line['Ref No'] ?? null,
                    'current_status' => $line['Current Status'] ?? null,
                    'year_of_completion' => $line['Year of Completion'] ?? null,
                    'father_occupation' => $line['Father/Husband Occupation'] ?? null,
                    'mother_occupation' => $line['Mother Occupation'] ?? null,
                    'first_aim' => $line['First Aim/Life Goal'] ?? null,
                    'second_aim' => $line['Second Aim/Life Goal (Optional)'] ?? null,
                    'purpose_of_training' => $line['Purpose of This Training'] ?? null,
                    'need_job' => strtolower($line['Need Job?'] ?? '') === 'yes',
                    'job_location_preference' => $line['Job Location preference'] ?? null,
                    'has_experience' => strtolower($line['Experience?'] ?? '') === 'yes',
                    'experience_details' => $line['Details of Job if yes'] ?? null,
                    'remarks' => $line['Remarks'] ?? null,
                    'counselled_with' => $line['Counselling With'] ?? null,
                ]);
                $count++;
            }
        });

        return response()->json(['message' => "$count counselling records imported."]);
    }

    public function enrollments(Request $request): JsonResponse
    {
        Gate::authorize('create', Staff::class);

        $request->validate(['file' => 'required|file|mimes:csv,txt']);

        $path = $request->file('file')->getRealPath();
        $data = array_map('str_getcsv', file($path));
        $header = array_shift($data);

        $count = 0;
        DB::transaction(function () use ($data, $header, &$count) {
            foreach ($data as $row) {
                if (count($row) < 5) {
                    continue;
                }
                $line = array_combine($header, $row);

                // Find or create course/batch if needed, but usually we expect them to exist
                $course = Course::where('name', 'like', '%'.($line['Course'] ?? '').'%')->first();

                Enrollment::create([
                    'temp_id' => $line['TempID'] ?? $line['Temp ID'] ?? null,
                    'candidate_id' => $line['CandidateId'] ?? $line['Candidate Id'] ?? null,
                    'full_name' => $line['Full Name'] ?? $line['FullName'] ?? 'Unknown',
                    'father_name' => $line['Father Name'] ?? null,
                    'mother_name' => $line['Mother Name'] ?? null,
                    'phone' => $line['Mobile'] ?? $line['Phone'] ?? '0000000000',
                    'email' => $line['Email'] ?? null,
                    'gender' => strtolower($line['Gender'] ?? 'other'),
                    'dob' => $this->parseDate($line['DOB'] ?? null),
                    'aadhaar_no' => $line['Aadhaar'] ?? $line['Aadhaar No'] ?? null,
                    'course_id' => $course?->id ?? 1, // Defaulting to first course if unknown
                    // ... add more mapping as needed from the 49 columns
                ]);
                $count++;
            }
        });

        return response()->json(['message' => "$count enrollments imported."]);
    }

    private function parseDate(?string $date): ?string
    {
        if (! $date) {
            return null;
        }
        try {
            return date('Y-m-d', strtotime($date));
        } catch (\Exception $e) {
            return null;
        }
    }
}
