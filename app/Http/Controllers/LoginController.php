<?php

namespace App\Http\Controllers;

class LoginController
{
    public function index()
    {
        return monolikit('security.login');
    }

    public function login()
    {
        auth()->loginUsingId(1);

        return redirect('/');
    }

    public function logout()
    {
        auth()->logout();

        request()->session()->invalidate();

        request()->session()->regenerateToken();

        return redirect('/login');
    }
}
