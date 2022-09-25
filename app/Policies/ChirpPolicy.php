<?php

namespace App\Policies;

use App\Models\Chirp;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ChirpPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return true;
    }

    public function view(User $user, Chirp $chirp)
    {
        return true;
    }

    public function create(User $user)
    {
        return true;
    }

    public function delete(User $user, Chirp $chirp)
    {
        return $chirp->author->is($user);
    }

    public function like(User $user, Chirp $chirp): bool
    {
        return !$user->hasLiked($chirp);
    }

    public function unlike(User $user, Chirp $chirp): bool
    {
        return $user->hasLiked($chirp);
    }
}
