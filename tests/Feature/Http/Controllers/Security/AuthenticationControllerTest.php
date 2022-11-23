<?php

use function Pest\Laravel\get;

test('the login page can be rendered', function () {
    get('/login')
        ->assertOk()
        ->assertHybridView('security.login');
});

test('logged in users cannot see the login page', function () {
    actingAsUser()
        ->get('/login')
        ->assertRedirect('/');
});

test('a guest cannot login with incorrect credentials', function () {
    $user = user([
        'password' => bcrypt('secret'),
    ]);

    this()
        ->from('/login')
        ->post('login', [
            'email' => $user->email,
            'password' => 'some-secret',
        ])
        ->assertRedirect('/login')
        ->assertSessionHasErrors('email');

    expect(session()->hasOldInput('email'))->toBeTrue();
    expect(session()->hasOldInput('password'))->toBeFalse();

    this()->assertGuest();
});

test('a guest can login with correct credentials', function () {
    $user = user([
        'password' => bcrypt($password = 'secret'),
    ]);

    this()
        ->from('/login')
        ->post('login', [
            'email' => $user->email,
            'password' => $password,
        ])
        ->assertRedirect('/');

    this()->assertAuthenticatedAs($user);
});

test('a logged in user can logout', function () {
    actingAsUser()
        ->post('/logout')
        ->assertRedirect('/login');

    this()->assertGuest();
});
