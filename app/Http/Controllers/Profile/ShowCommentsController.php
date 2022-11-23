<?php

namespace App\Http\Controllers\Profile;

use App\Data\ChirpData;
use App\Data\UserProfileData;
use App\Models\User;
use Hybridly\Contracts\HybridResponse;

class ShowCommentsController
{
    public function __invoke(User $user): HybridResponse
    {
        $user->loadCount(['chirps', 'likes']);
        $chirps = $user->chirps()
            ->isComment()
            ->orderByDesc('created_at')
            ->paginate();

        return hybridly('users.show-comments', [
            'active_tab' => 'comments',
            'user' => UserProfileData::from($user),
            'chirps' => ChirpData::collection($chirps),
        ]);
    }
}
