<?php

namespace App\Actions;

use App\Models\Chirp;
use Lorisleiva\Actions\Concerns\AsAction;

/**
 * Deletes a given chirp.
 */
class DeleteChirp
{
    use AsAction;

    public function handle(Chirp $chirp): void
    {
        $chirp->delete();
    }
}
