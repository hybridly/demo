<?php

namespace App\Actions;

use App\Models\Chirp;
use App\Models\User;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Lorisleiva\Actions\Concerns\AsAction;

class UnlikeChirp
{
    use AsAction;

    public function handle(User $user, Chirp $chirp): void
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
