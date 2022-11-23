<?php

namespace App\Http\Controllers\Profile;

use App\Data\ChirpData;
use App\Data\UserProfileData;
use App\Models\Chirp;
use App\Models\User;
use Hybridly\Contracts\HybridResponse;

class ShowLikesController
{
    public function __invoke(User $user): HybridResponse
    {
        $user->loadCount(['chirps', 'likes']);
        $chirps = Chirp::query()
            ->isLikedBy($user)
            ->orderByDesc('created_at')
            ->paginate();

        return hybridly('users.show-likes', [
            'active_tab' => 'likes',
            'user' => UserProfileData::from($user),
            'chirps' => ChirpData::collection($chirps),
        ]);
    }
}
