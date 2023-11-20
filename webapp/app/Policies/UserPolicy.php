<?php

namespace App\Policies;

use App\Models\User;

use Illuminate\Support\Facades\Auth;

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
        return ($logged->id === $user->id) || (Auth::guard('admin')->user() != null);
    }

    public function editProfile(User $logged, User $user) : bool {
        return $logged->id === $user->id;
    }
}
