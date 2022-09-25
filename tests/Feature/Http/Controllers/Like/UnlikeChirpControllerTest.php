<?php

use App\Http\Controllers\Like\UnlikeChirpController;
use App\Models\Chirp;
use App\Models\Like;

use function Pest\Laravel\delete;

use Symfony\Component\HttpFoundation\Response;

it('can delete a like', function () {
    actingAsUser($user = user());

    $chirp = Chirp::factory()
        ->fromUser($user)
        ->has(Like::factory()->byUser($user)->count(1))
        ->create();

    expect(Like::count())->toBe(1);

    delete(action(UnlikeChirpController::class, $chirp))
        ->assertStatus(Response::HTTP_NO_CONTENT);

    expect(Like::count())->toBe(0);
    expect($chirp->likes->count())->toBe(0);
});
