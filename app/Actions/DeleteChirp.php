<?php

namespace App\Actions;

use App\Models\Attachment;
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
        // Instead of relying on the cascade to delete attachments,
        // delete them manually so their files are clean up too.
        $chirp->attachments?->each(function (Attachment $attachment) {
            $attachment->delete();
        });

        $chirp->delete();
    }
}
