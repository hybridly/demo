<?php

test('anyone can bypass logging in as the first user', function () {
    $user = user();

    this()
        ->get('/bypass-login')
        ->assertRedirect('/');

    this()->assertAuthenticatedAs($user);
});

test('anyone can bypass logging as any user', function () {
    $user = user(count: 2)->last();

    this()
        ->get('/bypass-login/' . $user->id)
        ->assertRedirect('/');

    this()->assertAuthenticatedAs($user);
});
