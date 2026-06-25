<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Course\StoreCourseRequest;
use App\Http\Requests\Course\UpdateCourseRequest;
use App\Http\Resources\CourseResource;
use App\Models\Course;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Gate;

class CourseController extends Controller
{
    public function index(Request $request): AnonymousResourceCollection
    {
        $courses = Course::query()
            ->when($request->boolean('active'), fn ($q) => $q->active())
            ->orderByDesc('id')
            ->get();

        return CourseResource::collection($courses);
    }

    public function store(StoreCourseRequest $request): CourseResource
    {
        Gate::authorize('create', Course::class);

        $course = Course::create($request->validated());

        return CourseResource::make($course);
    }

    public function show(Course $course): CourseResource
    {
        return CourseResource::make($course->load('batches'));
    }

    public function update(UpdateCourseRequest $request, Course $course): CourseResource
    {
        Gate::authorize('update', $course);

        $course->update($request->validated());

        return CourseResource::make($course->fresh());
    }

    public function destroy(Course $course): JsonResponse
    {
        $course->update(['is_active' => false]);

        return response()->json(['message' => 'Course deactivated.']);
    }
}
