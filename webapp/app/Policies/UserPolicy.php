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

    public function respectiveUserOrAdmin($logged, User $user): bool
    {
        return ($logged->id === $user->id) || (Auth::guard('admin')->user() != null);
    }

    public function viewProfile(User $logged, User $user): bool
    {
        return $logged->id === $user->id;
    }

    public function editProfile(User $logged, User $user): bool
    {
        return $logged->id === $user->id;
    }

    public function deleteAccount(User $logged, User $user): bool
    {
        error_log($logged->id);
        error_log($user->id);
        return $logged->id === $user->id;
    }

    public function verifyNotAutenticated(User $logged, User $user): void
    {
        if (Auth::check() || Auth::guard('admin')->check())
            abort(403);
    }
}
