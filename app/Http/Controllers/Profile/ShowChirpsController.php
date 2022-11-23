<?php

namespace App\Http\Controllers\Profile;

use App\Data\ChirpData;
use App\Data\UserProfileData;
use App\Models\User;
use Hybridly\Contracts\HybridResponse;

class ShowChirpsController
{
    public function __invoke(User $user): HybridResponse
    {
        $user->loadCount(['chirps', 'likes']);
        $chirps = $user->chirps()
            ->isMain()
            ->orderByDesc('created_at')
            ->paginate();

        return hybridly('users.show', [
            'active_tab' => 'chirps',
            'user' => UserProfileData::from($user),
            'chirps' => ChirpData::collection($chirps),
        ]);
    }
}
