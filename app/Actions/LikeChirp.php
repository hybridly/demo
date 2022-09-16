<?php

namespace App\Actions;

use App\Models\Chirp;
use App\Models\Like;
use App\Models\User;
use Lorisleiva\Actions\Concerns\AsAction;

class LikeChirp
{
    use AsAction;

    public function handle(User $user, Chirp $chirp): void
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
