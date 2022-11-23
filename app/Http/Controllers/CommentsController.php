<?php

namespace App\Http\Controllers;

use App\Data\ChirpData;
use App\Models\Chirp;
use Illuminate\Support\Str;

class CommentsController
{
    public function create(Chirp $chirp)
    {
        return hybridly('dialogs.comments.create', [
            'chirp' => ChirpData::from($chirp),
            'str' => Str::random(5),
        ])->base('chirp.show', $chirp);
    }
}
