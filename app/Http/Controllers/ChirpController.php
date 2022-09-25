<?php

namespace App\Http\Controllers;

use App\Actions\CreateChirp;
use App\Actions\DeleteChirp;
use App\Data\ChirpData;
use App\Data\CreateChirpData;
use App\Models\Chirp;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class ChirpController
{
    use AuthorizesRequests;

    public function index()
    {
        $this->authorize('viewAny', Chirp::class);

        $chirps = Chirp::query()
            ->forHomePage()
            ->paginate();

        return hybridly('chirps.index', [
            'chirps' => ChirpData::collection($chirps),
        ]);
    }

    public function show(Chirp $chirp)
    {
        $this->authorize('view', $chirp);

        $comments = $chirp->comments()->withLikeAndCommentCounts()->paginate();

        return hybridly('chirps.show', [
            'chirp' => ChirpData::from($chirp),
            'comments' => ChirpData::collection($comments),
            'previous' => $chirp->parent_id
                ? url()->route('chirp.show', $chirp->parent_id)
                : url()->route('index'),
        ]);
    }

    public function store(CreateChirpData $data)
    {
        $this->authorize('create', Chirp::class);

        CreateChirp::run($data);

        return back();
    }

    public function destroy(Chirp $chirp, Request $request)
    {
        $this->authorize('delete', $chirp);

        DeleteChirp::run($chirp);

        return $request->filled('redirect_to')
            ? redirect($request->input('redirect_to'))
            : back();
    }
}
