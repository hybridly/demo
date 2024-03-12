<?php

namespace App\Actions;

use App\Data\CreateAttachmentData;
use App\Data\CreateChirpData;
use App\Models\Attachment;
use App\Models\Chirp;
use App\Support\Disk;

/**
 * Creates a new chirp.
 */
class CreateChirp
{
    public function __invoke(CreateChirpData $data): Chirp
    {
        $chirp = Chirp::create([
            'body' => $data->body,
            'author_id' => auth()->user()->id,
            'parent_id' => $data->parent_id,
        ]);

        $data->attachments?->each(function (CreateAttachmentData $attachment) use ($chirp) {
            Attachment::create([
                'chirp_id' => $chirp->id,
                'alt' => $attachment->alt,
                'path' => $attachment->file->store('', ['disk' => Disk::Attachments]),
            ]);
        });

        return $chirp;
    }
}
