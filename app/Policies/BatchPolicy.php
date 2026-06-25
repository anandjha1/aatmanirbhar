<?php

namespace App\Policies;

use App\Enums\StaffRole;
use App\Models\Batch;
use App\Models\Staff;

class BatchPolicy
{
    public function viewAny(Staff $user): bool
    {
        return true;
    }

    public function view(Staff $user, Batch $batch): bool
    {
        return true;
    }

    public function create(Staff $user): bool
    {
        return $user->isAdmin();
    }

    public function update(Staff $user, Batch $batch): bool
    {
        return $user->isAdmin() || $user->role === StaffRole::Trainer;
    }

    public function delete(Staff $user, Batch $batch): bool
    {
        return $user->isAdmin();
    }
}
