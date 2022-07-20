<?php

namespace App\Http\Controllers;

use App\Actions\CreateChirp;
use App\Actions\DeleteChirp;
use App\Actions\GetChirps;
use App\Data\ChirpData;
use App\Data\CreateChirpData;
use App\Models\Chirp;

class ChirpController extends Controller
{
    public function index(GetChirps $chirps)
    {
        return hybridly('chirps.index', [
            'chirps' => ChirpData::collection($chirps->run()),
        ]);
    }

    public function store(CreateChirpData $data)
    {
        $this->authorize('create', Chirp::class);

        CreateChirp::run($data);

        return back();
    }

    public function destroy(Chirp $chirp)
    {
        $this->authorize('delete', $chirp);

        DeleteChirp::run($chirp);

        return back();
    }
}
