<?php

namespace App\Http\Controllers\Security;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Symfony\Component\HttpFoundation\Response;

class BypassAuthenticationController
{
    public function __invoke(?User $user = null)
    {
        abort_unless(User::exists(), Response::HTTP_NOT_FOUND);

        if (auth()->check()) {
            auth()->logout();
        }

        auth()->login($user ?? User::first());

        return redirect(RouteServiceProvider::HOME);
    }
}
