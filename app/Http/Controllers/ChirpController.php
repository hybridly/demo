<?php

namespace App\Http\Controllers;

use App\Actions\CreateChirp;
use App\Actions\DeleteChirp;
use App\Data\ChirpData;
use App\Data\CreateChirpData;
use App\Data\UpdateChirpData;
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

    public function edit(Chirp $chirp)
    {
        $this->authorize('edit', $chirp);

        return hybridly('chirps.edit', [
            'chirp' => ChirpData::from($chirp),
        ])->base('chirp.show', $chirp);
    }

    public function update(Chirp $chirp, UpdateChirpData $data)
    {
        $this->authorize('edit', $chirp);

        $chirp->update([
            'body' => $data->body,
        ]);

        return back()->with('success', 'Chirp has been updated.');
        // return to_route('chirp.show', $chirp)->with('success', 'Chirp has been updated.');
    }

    public function show(Chirp $chirp, Request $request)
    {
        $this->authorize('view', $chirp);

        $comments = $chirp->comments()->withLikeAndCommentCounts()->paginate();

        return hybridly('chirps.show', [
            'chirp' => ChirpData::from($chirp),
            'comments' => ChirpData::collection($comments),
            'highlight' => (string) $request->session()->get('chirp.highlight'),
        ]);
    }

    public function store(CreateChirpData $data)
    {
        $this->authorize('create', Chirp::class);

        $chirp = CreateChirp::run($data);

        return redirect()->to(match (true) {
            !!$chirp->parent_id => route('chirp.show', $chirp->parent_id),
            default => route('index')
        })->with('chirp.highlight', $chirp->id);
    }

    public function destroy(Chirp $chirp, Request $request)
    {
        $this->authorize('delete', $chirp);

        DeleteChirp::run($chirp);

        return redirect()->to(match (true) {
            !!$chirp->parent_id => route('chirp.show', $chirp->parent_id),
            default => route('index')
        });
    }
}
