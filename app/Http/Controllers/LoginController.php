<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;

class LoginController
{
    public function index()
    {
        return monolikit('security.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (auth()->attempt($credentials)) {
            $request->session()->regenerate();

            return redirect('/');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function logout()
    {
        auth()->logout();

        request()->session()->invalidate();

        request()->session()->regenerateToken();

        return redirect('/login');
    }

    public function quick_login($id = null)
    {
        if (auth()->check()) {
            auth()->logout();
        }

        $has_any_users = User::count() === 0;

        abort_if($has_any_users, 404, 'There are no users in the database');

        auth()->login(User::find($id) ?? User::first());

        return redirect(RouteServiceProvider::HOME);
    }
}
