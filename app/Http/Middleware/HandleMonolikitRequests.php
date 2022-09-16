<?php

namespace App\Http\Middleware;

use App\Data\Monolikit\SharedData;
use App\Data\UserData;
use Monolikit\Http\Middleware;

class HandleMonolikitRequests extends Middleware
{
    /**
     * Defines the properties that are shared to all requests.
     */
    public function share()
    {
        return SharedData::from([
            'security' => [
                'user' => UserData::from(auth()->user()),
                'characters' => config('chirp.characters'),
            ],
        ]);
    }
}
