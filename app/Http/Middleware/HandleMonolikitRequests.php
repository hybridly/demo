<?php

namespace App\Http\Middleware;

use App\Data\Monolikit\SharedData;
use Monolikit\Http\Middleware;
use Spatie\LaravelData\Lazy;

class HandleMonolikitRequests extends Middleware
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
