<?php

namespace App\Http\Controllers\Like;

use App\Actions\UnlikeChirp;
use App\Models\Chirp;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class UnlikeChirpController
{
    use AuthorizesRequests;

    public function __invoke(Chirp $chirp)
    {
        $this->authorize('unlike', $chirp);

        UnlikeChirp::run(auth()->user(), $chirp);

        return response()->noContent();
    }
}
