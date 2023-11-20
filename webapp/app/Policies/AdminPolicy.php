<?php

namespace App\Policies;

use App\Models\Admin;

class AdminPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function onlyAdmin($logged, Admin $user) : bool {
        return $user->isAdmin;
    }

    public function notAdmin($logged, Admin $user) : bool {
        return !$user->isAdmin;
    }
}
