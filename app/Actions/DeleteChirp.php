<?php

namespace App\Actions;

use App\Models\Attachment;
use App\Models\Chirp;

/**
 * Deletes a given chirp.
 */
class DeleteChirp
{
    public function __invoke(Chirp $chirp): void
    {
        // Instead of relying on the cascade to delete attachments,
        // delete them manually so their files are clean up too.
        $chirp->attachments?->each(function (Attachment $attachment) {
            $attachment->delete();
        });

        $chirp->delete();
    }
}
