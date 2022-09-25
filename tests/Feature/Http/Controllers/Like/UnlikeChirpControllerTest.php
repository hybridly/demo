<?php

use App\Models\Chirp;

use function Pest\Laravel\delete;

use Symfony\Component\HttpFoundation\Response;

test('users can unlike a chirp they liked beforehand', function () {
    actingAsUser($user = user());

    $chirp = Chirp::factory()
        ->withLike($user)
        ->create();

    expect($chirp->fresh()->likes)
        ->count()->toBe(1)
        ->first()->user_id->toBe($user->id);

    delete("/chirps/{$chirp->id}/likes")->assertStatus(Response::HTTP_NO_CONTENT);

    expect($chirp->likes)->count()->toBe(0);
});

test('guests cannot unlike a chirp they did not like beforehand', function () {
    actingAsUser($user = user());

    $chirp = Chirp::factory()
        ->withLike()
        ->create();

    expect($chirp->fresh()->likes)
        ->count()->toBe(1)
        ->first()->user_id->not->toBe($user->id);

    delete("/chirps/{$chirp->id}/likes")->assertStatus(Response::HTTP_FORBIDDEN);

    expect($chirp->likes)->count()->toBe(1);
});
