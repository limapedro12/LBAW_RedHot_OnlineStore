<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function respectiveUserOrAdmin($logged, User $user) : bool {
        return ($logged->id === $user->id) || $logged->isAdmin;
    }

    public function onlyAdmin($logged) : bool {
        return $logged->isAdmin;
    }

    public function notAdmin($logged) : bool {
        return !$logged->isAdmin;
    }
}
