<?php

use App\Models\Chirp;
use App\Models\Like;
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

test('the hasLiked method returns whether the user has liked the given chirp', function () {
    $chirp = Chirp::factory()
        ->fromUser($user = user())
        ->has(Like::factory()->byUser($user)->count(1))
        ->create();

    expect($user->hasLiked($chirp))
        ->toBeTrue();

    expect($user->hasLiked(Chirp::factory()->create()))
        ->toBeFalse();
});

test('the `display_name` attributes falls back to the username if not defined', function () {
    expect(user(['display_name' => 'John']))->display_name->toBe('John');
    expect($user = user(['display_name' => null]))->display_name->toBe($user->username);
});

test('the `profile_picture_url` is generated when `profile_picture_path` is defined', function () {
    expect(user(['profile_picture_path' => null]))->profile_picture_url->toBeNull();
    expect(user(['profile_picture_path' => 'yay.png']))->profile_picture_url->not->toBeNull();
});
