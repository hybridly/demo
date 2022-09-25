<?php

use App\Models\Chirp;

use function Pest\Laravel\post;

use Symfony\Component\HttpFoundation\Response;

test('a user can like a chirp they did not like beforehand', function () {
    actingAsUser($user = user());

    $chirp = Chirp::factory()->create();

    post("/chirps/{$chirp->id}/likes")->assertStatus(Response::HTTP_NO_CONTENT);

    expect($chirp->likes)
        ->count()->toBe(1)
        ->first()->user_id->toBe($user->id);
});

test('a user cannot like a chirp they already liked', function () {
    actingAsUser($user = user());

    $chirp = Chirp::factory()
        ->withLike($user)
        ->create();

    post("/chirps/{$chirp->id}/likes")->assertStatus(Response::HTTP_FORBIDDEN);

    expect($chirp->likes)->count()->toBe(1);
});

test('guests cannot like a chirp', function () {
    $chirp = Chirp::factory()->create();

    post("/chirps/{$chirp->id}/likes")->assertRedirect(route('login'));

    expect($chirp->likes)->count()->toBe(0);
});
