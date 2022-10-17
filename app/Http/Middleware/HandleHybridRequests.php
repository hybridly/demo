<?php

namespace App\Http\Middleware;

use App\Data\Hybridly\SharedData;
use App\Data\UserData;
use Hybridly\Http\Middleware;

class HandleHybridRequests extends Middleware
{
    /**
     * Defines the properties that are shared to all requests.
     */
    public function share()
    {
        return SharedData::from([
            'security' => [
                'user' => UserData::optional(auth()->user()),
                'characters' => config('chirp.characters'),
            ],
        ]);
    }
}
