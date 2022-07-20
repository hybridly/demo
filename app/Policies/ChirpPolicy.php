<?php

namespace App\Policies;

use App\Models\Chirp;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ChirpPolicy
{
    use HandlesAuthorization;

    public function create(User $user)
    {
        return true;
    }

    public function update(User $user, Chirp $chirp)
    {
        return false;
    }

    public function delete(User $user, Chirp $chirp)
    {
        return $chirp->author()->is($user);
    }

    public function restore(User $user, Chirp $chirp)
    {
        return $chirp->author()->is($user);
    }

    public function forceDelete(User $user, Chirp $chirp)
    {
        return false;
    }
}
