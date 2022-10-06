<?php

test('users can see profile page', function () {
    actingAsUser($user = user())
        ->get("/users/{$user->id}")
        ->assertOk();
});

test('users can see profile->comments page', function () {
    actingAsUser($user = user())
        ->get("/users/{$user->id}/comments")
        ->assertOk();
});

test('users can see profile->likes page', function () {
    actingAsUser($user = user())
        ->get("/users/{$user->id}/likes")
        ->assertOk();
});
