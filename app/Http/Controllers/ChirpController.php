<?php

namespace App\Http\Controllers;

use App\Actions\CreateChirp;
use App\Actions\DeleteChirp;
use App\Data\ChirpData;
use App\Data\CreateChirpData;
use App\Models\Chirp;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ChirpController
{
    use AuthorizesRequests;

    public function index()
    {
        $chirps = Chirp::query()
            ->forHomePage()
            ->paginate();

        return hybridly('chirps.index', [
            'chirps' => ChirpData::collection($chirps),
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
