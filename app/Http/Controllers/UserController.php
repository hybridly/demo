<?php

namespace App\Http\Controllers;

use App\Data\ChirpData;
use App\Data\UserProfileData;
use App\Models\Chirp;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class UserController
{
    use AuthorizesRequests;

    public function show(User $user)
    {
        $user->loadCount(['chirps', 'likes']);
        $chirps = $user->chirps()
            ->isMain()
            ->orderByDesc('created_at')
            ->paginate();

        return hybridly('users.show', [
            'activeTab' => 'chirps',
            'canEditProfile' => $user->id === auth()->user()->id,
            'user' => UserProfileData::from($user),
            'chirps' => ChirpData::collection($chirps),
        ]);
    }

    public function showComments(User $user)
    {
        $user->loadCount(['chirps', 'likes']);
        $chirps = $user->chirps()
            ->isComment()
            ->orderByDesc('created_at')
            ->paginate();

        return hybridly('users.show-comments', [
            'activeTab' => 'comments',
            'canEditProfile' => $user->id === auth()->user()->id,
            'user' => UserProfileData::from($user),
            'chirps' => ChirpData::collection($chirps),
        ]);
    }

    public function showLikes(User $user)
    {
        $user->loadCount(['chirps', 'likes']);
        $chirps = Chirp::query()
            ->isLikedBy($user)
            ->orderByDesc('created_at')
            ->paginate();

        return hybridly('users.show-likes', [
            'activeTab' => 'likes',
            'canEditProfile' => $user->id === auth()->user()->id,
            'user' => UserProfileData::from($user),
            'chirps' => ChirpData::collection($chirps),
        ]);
    }
}
