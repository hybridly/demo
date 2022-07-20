<?php

namespace App\Actions;

use App\Models\Chirp;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Lorisleiva\Actions\Concerns\AsAction;

class GetChirps
{
    use AsAction;

    public function handle(): LengthAwarePaginator
    {
        // <Insert some next-gen social network algorithm here>
        return Chirp::with('author')
            ->orderByDesc('created_at')
            ->paginate();
    }
}
