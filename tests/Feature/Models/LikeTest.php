<?php

use App\Models\Chirp;
use App\Models\Like;
use App\Models\User;

it('has a user relationship', function () {
    $chirp = Chirp::factory()->create();
    $like = Like::factory()
        ->byUser($user = user())
        ->for($chirp)
        ->create();

    expect($like->user)->toBeInstanceOf(User::class);
    expect($like->user->id)->toBe($user->id);
});

it('has a chirp relationship', function () {
    $chirp = Chirp::factory()->create();
    $like = Like::factory()
        ->byUser(user())
        ->for($chirp)
        ->create();

    expect($like->chirp)->toBeInstanceOf(Chirp::class);
    expect($like->chirp->id)->toBe($chirp->id);
});
