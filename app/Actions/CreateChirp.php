<?php

namespace App\Actions;

use App\Data\CreateChirpData;
use App\Models\Chirp;
use Lorisleiva\Actions\Concerns\AsAction;

/**
 * Creates a new chirp.
 */
class CreateChirp
{
    use AsAction;

    public function handle(CreateChirpData $data): Chirp
    {
        return Chirp::create([
            'body' => $data->body,
            'author_id' => auth()->user()->id,
            'parent_id' => $data->parent_id,
        ]);
    }
}
