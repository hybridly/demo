<?php

use App\Models\Chirp;
use App\Models\Like;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

it('has a chirps relationship', function () {
    $chirp = Chirp::factory()
        ->fromUser($user = user())
        ->create();

    expect($user->chirps)
        ->toBeInstanceOf(Collection::class)
        ->toHaveCount(1)
        ->contains($chirp)->tobeTrue();
});

it('has a likes relationship', function () {
    Chirp::factory()
        ->fromUser($user = user())
        ->has(Like::factory()->byUser($user)->count(1))
        ->create();

    expect($user->likes)
        ->toBeInstanceOf(Collection::class)
        ->toHaveCount(1)
        ->contains(Like::first())->tobeTrue();
});

it('has a hasLiked function to check if user has liked the given chirp', function () {
    $chirp = Chirp::factory()
        ->fromUser($user = user())
        ->has(Like::factory()->byUser($user)->count(1))
        ->create();

    expect($user->hasLiked($chirp))
        ->toBeTrue();

    expect($user->hasLiked(Chirp::factory()->create()))
        ->toBeFalse();
});

it('has a displayName attribute', function () {
    $user = User::factory()->create([
        'display_name' => 'John',
    ]);
    expect($user->refresh())
        ->display_name->toBe('John');

    $user = User::factory()->create([
        'display_name' => null,
    ]);
    expect($user->refresh())
        ->display_name->toBe($user->username);
});

it('has a profilePictureUrl attribute', function () {
    expect(user())
        ->profile_picture_path->toBeNull();
});
