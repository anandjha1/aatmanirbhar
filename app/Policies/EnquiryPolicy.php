<?php

namespace App\Policies;

use App\Models\Enquiry;
use App\Models\Staff;

class EnquiryPolicy
{
    public function viewAny(Staff $user): bool
    {
        return true;
    }

    public function view(Staff $user, Enquiry $enquiry): bool
    {
        return $user->isAdmin() || $user->id === $enquiry->assigned_to;
    }

    public function create(Staff $user): bool
    {
        return true;
    }

    public function update(Staff $user, Enquiry $enquiry): bool
    {
        return $user->isAdmin() || $user->id === $enquiry->assigned_to;
    }

    public function delete(Staff $user, Enquiry $enquiry): bool
    {
        return $user->isAdmin();
    }
}
