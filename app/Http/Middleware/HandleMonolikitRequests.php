<?php

namespace App\Http\Middleware;

use App\Data\UserData;
use Illuminate\Http\Request;
use Monolikit\Http\Middleware;

class HandleMonolikitRequests extends Middleware
{
    protected array $persistent = ['user'];

    /**
     * Defines the properties that are shared to all requests.
     */
    public function share(Request $request): array
    {
        return [
            'security' => [
                'user' => UserData::optional(auth()->user()),
                'characters' => config('chirp.characters'),
            ],
        ];
    }
}
