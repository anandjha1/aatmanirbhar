<?php

namespace App\Policies;

use App\Enums\StaffRole;
use App\Models\Enrollment;
use App\Models\Staff;

class EnrollmentPolicy
{
    public function viewAny(Staff $user): bool
    {
        return true;
    }

    public function view(Staff $user, Enrollment $enrollment): bool
    {
        return true;
    }

    public function create(Staff $user): bool
    {
        return $user->isAdmin() || $user->role === StaffRole::Counsellor;
    }

    public function update(Staff $user, Enrollment $enrollment): bool
    {
        return $user->isAdmin() || $user->role === StaffRole::Counsellor;
    }

    public function delete(Staff $user, Enrollment $enrollment): bool
    {
        return $user->isAdmin();
    }
}
