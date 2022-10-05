<?php

namespace App\Http\Controllers;

use App\Data\ChirpData;
use App\Data\UserProfileData;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class UserController
{
    use AuthorizesRequests;

    public function show(User $user)
    {
        $user->loadCount(['chirps', 'likes']);
        $chirps = $user->chirps()->forHomePage()->paginate();

        return hybridly('users.show', [
            'user' => UserProfileData::from($user),
            'chirps' => ChirpData::collection($chirps),
        ]);
    }
}
