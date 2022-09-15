<?php

namespace App\Http\Middleware;

use App\Data\Hybridly\SharedData;
use Hybridly\Http\Middleware;
use Spatie\LaravelData\Lazy;

class HandleHybridlyRequests extends Middleware
{
    /**
     * Defines the properties that are shared to all requests.
     */
    public function share(): SharedData
    {
        return SharedData::from([
            'security' => [
                'user' => Lazy::create(fn () => auth()->user())->defaultIncluded(),
                'characters' => config('chirp.characters'),
            ],
        ]);
    }
}
