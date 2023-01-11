<?php

namespace App\Http\Controllers;

use App\Data\ChirpData;
use App\Models\Chirp;

class CommentsController
{
    public function create(Chirp $chirp)
    {
        return hybridly('dialogs.comments.create', [
            'chirp' => ChirpData::from($chirp),
            'str' => str()->random(5),
        ])->base('chirp.show', $chirp);
    }
}
