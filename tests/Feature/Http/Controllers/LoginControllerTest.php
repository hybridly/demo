<?php

test('login page can be rendered')
    ->get('/login')
    ->assertOk()
    ->assertSee('login');

it('cannot view login page when authenticated', function () {
    actingAs(user())->get('/login')->assertRedirect('/');
});

it('can login', function () {
    using($this)
        ->from('/login')
        ->post('login')
        ->assertRedirect('/');
});
