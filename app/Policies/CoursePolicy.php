<?php

namespace App\Policies;

use App\Models\Course;
use App\Models\Staff;

class CoursePolicy
{
    public function viewAny(Staff $user): bool
    {
        return true;
    }

    public function view(Staff $user, Course $course): bool
    {
        return true;
    }

    public function create(Staff $user): bool
    {
        return $user->isAdmin();
    }

    public function update(Staff $user, Course $course): bool
    {
        return $user->isAdmin();
    }

    public function delete(Staff $user, Course $course): bool
    {
        return $user->isAdmin();
    }
}
