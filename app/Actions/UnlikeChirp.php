<?php

namespace App\Actions;

use App\Models\Chirp;
use App\Models\User;
use Illuminate\Contracts\Database\Eloquent\Builder;

class UnlikeChirp
{
    public function __invoke(User $user, Chirp $chirp): void
    {
        if (!$user->hasLiked($chirp)) {
            return;
        }

        $chirp
            ->likes()
            ->whereHas('user', fn (Builder $q) => $q->where('id', $user->id))
            ->delete();
    }
}
