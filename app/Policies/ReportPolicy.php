<?php

namespace App\Policies;

use App\Models\Report;
use App\Models\User;

class ReportPolicy
{
    /**
     * Only admins can view reports.
     */
    public function view(User $user): bool
    {
        return $user->isAdmin();
    }

    /**
     * Only admins can manage reports.
     */
    public function update(User $user, Report $report): bool
    {
        return $user->isAdmin();
    }

    /**
     * Only admins can delete reports.
     */
    public function delete(User $user, Report $report): bool
    {
        return $user->isAdmin();
    }

    /**
     * Allow authenticated users to create reports.
     */
    public function create(User $user): bool
    {
        return $user->id !== null; // Any authenticated user
    }
}
