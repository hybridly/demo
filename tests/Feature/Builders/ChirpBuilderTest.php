<?php

use App\Models\Chirp;
use Illuminate\Database\Eloquent\Collection;

it('has a forHomePage function', function () {
    $chirp = Chirp::factory()->create();

    Chirp::factory()
        ->withParent($chirp)
        ->create();

    /**
     * For now we only check whether the forHomePage() exists,
     * and it only returns main chirps.
     */
    expect(Chirp::forHomePage()->get())
        ->toBeInstanceOf(Collection::class)
        ->toHaveCount(1);
});

it('has a sortedForComments function', function () {
    Chirp::factory()->create();

    expect(Chirp::sortedForComments()->get())
        ->toBeInstanceOf(Collection::class)
        ->toHaveCount(1);
});

it('has a withLikesAndComments function', function () {
    Chirp::factory()->create();

    expect(Chirp::withLikesAndComments()->get())
        ->toBeInstanceOf(Collection::class)
        ->toHaveCount(1);
});

it('has a isMain function', function () {
    $chirp = Chirp::factory()->create();

    Chirp::factory()
        ->withParent($chirp)
        ->create();

    expect(Chirp::isMain()->get())
        ->toBeInstanceOf(Collection::class)
        ->toHaveCount(1);
});

it('has a isLikedBy function', function () {
    Chirp::factory()->create();

    expect(Chirp::isLikedBy(user())->get())
        ->toBeInstanceOf(Collection::class)
        ->toHaveCount(0);
});
