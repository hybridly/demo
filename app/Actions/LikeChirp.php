<?php

namespace App\Actions;

use App\Models\Chirp;
use App\Models\Like;
use App\Models\User;

class LikeChirp
{
    public function __invoke(User $user, Chirp $chirp): void
    {
        if ($user->hasLiked($chirp)) {
            return;
        }

        Like::create([
            'chirp_id' => $chirp->id,
            'user_id' => $user->id,
        ]);
    }
}
