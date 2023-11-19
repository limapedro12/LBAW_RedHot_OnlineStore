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

    public function viewProfile(User $logged, User $user) : bool {
        return $logged->id === $user->id;
    }
}
