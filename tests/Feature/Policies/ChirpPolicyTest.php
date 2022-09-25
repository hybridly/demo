<?php

use App\Models\Chirp;

it('allows users to view any chirp', function () {
    actingAsUser();
    expect(Gate::allows('viewAny', Chirp::class))->toBeTrue();
});

it('forbids guests to view any chirp', function () {
    expect(Gate::allows('viewAny', Chirp::class))->toBeFalse();
});

it('allows users to view a chirp', function () {
    actingAsUser();

    $chirp = Chirp::factory()->create();

    expect(Gate::allows('view', $chirp))->toBeTrue();
});

it('forbids guests to view a chirp', function () {
    $chirp = Chirp::factory()->create();

    expect(Gate::allows('view', $chirp))->toBeFalse();
});

it('allows users to create chirps', function () {
    actingAsUser();
    expect(Gate::allows('create', Chirp::class))->toBeTrue();
});

it('forbids guests from creating chirps', function () {
    expect(Gate::allows('create', Chirp::class))->toBeFalse();
});

it('forbids a user to delete a chirp they dont own', function () {
    actingAsUser();

    $user = user();
    $chirp = Chirp::factory()->fromUser($user)->create();

    expect(Gate::allows('delete', $chirp))->toBeFalse();
});

it('allows a user to delete a chirp they own', function () {
    actingAsUser($user = user());

    $chirp = Chirp::factory()->fromUser($user)->create();

    expect(Gate::allows('delete', $chirp))->toBeTrue();
});

it('forbids guests to delete a chirp', function () {
    $chirp = Chirp::factory()->create();

    expect(Gate::allows('delete', $chirp))->toBeFalse();
});

it('allows users to like a chirp', function () {
    actingAsUser();

    $chirp = Chirp::factory()->create();

    expect(Gate::allows('like', $chirp))->toBeTrue();
});

it('forbids guests to like a chirp', function () {
    $chirp = Chirp::factory()->create();

    expect(Gate::allows('like', $chirp))->toBeFalse();
});

it('forbids users to like a chirp twice', function () {
    actingAsUser($user = user());

    $chirp = Chirp::factory()
        ->fromUser($user)
        ->withLike($user)
        ->create();

    expect(Gate::allows('like', $chirp))->toBeFalse();
});

it('allows users to unlike a chirp they liked before', function () {
    actingAsUser($user = user());

    $chirp = Chirp::factory()
        ->fromUser($user)
        ->withLike($user)
        ->create();

    expect(Gate::allows('unlike', $chirp))->toBeTrue();
});

it('forbids users to unlike a chirp they did not like before', function () {
    actingAsUser($user = user());

    $chirp = Chirp::factory()
        ->fromUser($user)
        ->withLike()
        ->create();

    expect(Gate::allows('unlike', $chirp))->toBeFalse();
});
