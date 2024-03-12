<?php

namespace App\Http\Controllers\Like;

use App\Actions\LikeChirp;
use App\Models\Chirp;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class LikeChirpController
{
    use AuthorizesRequests;

    public function __invoke(Chirp $chirp, LikeChirp $likeChirp)
    {
        $this->authorize('like', $chirp);

        $likeChirp(auth()->user(), $chirp);

        return response()->noContent();
    }
}
