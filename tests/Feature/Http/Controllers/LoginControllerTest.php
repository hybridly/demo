<?php

use App\Models\User;

/*

---------------------------------------------------------------------------
:: Index
---------------------------------------------------------------------------

*/
test('login page can be rendered')
    ->get('/login')
    ->assertOk()
    ->assertSee('login');

it('cannot view login page when authenticated', function () {
    actingAs(user())
        ->get('/login')
        ->assertRedirect('/');
});

/*

---------------------------------------------------------------------------
:: Login
---------------------------------------------------------------------------

*/

it('cannot login with incorrect credentials', function () {
    $user = User::factory()->create([
        'password' => bcrypt('secret'),
    ]);

    using($this)
        ->from('/login')
        ->post('login', [
            'email' => $user->email,
            'password' => 'some-secret',
        ])
        ->assertRedirect('/login')
        ->assertSessionHasErrors('email');

    expect(session()->hasOldInput('email'))->toBeTrue();
    expect(session()->hasOldInput('password'))->toBeFalse();

    using($this)
        ->assertGuest();
});

it('can login', function () {
    $user = User::factory()->create([
        'password' => bcrypt($password = 'secret'),
    ]);

    using($this)
        ->from('/login')
        ->post('login', [
            'email' => $user->email,
            'password' => $password,
        ])->assertRedirect('/');

    using($this)
        ->assertAuthenticatedAs($user);
});

/*

---------------------------------------------------------------------------
:: Logout
---------------------------------------------------------------------------

*/

it('can logout', function () {
    actingAs(user())
        ->post('/logout')
        ->assertRedirect('/login');

    using($this)
        ->assertGuest();
});

/*

---------------------------------------------------------------------------
:: Quick login
---------------------------------------------------------------------------

*/

it('can quick login via secret link', function () {
    $user = User::factory()->create();

    using($this)
        ->get('/dev/login/1')
        ->assertRedirect('/');

    using($this)
        ->assertAuthenticatedAs($user);
});
