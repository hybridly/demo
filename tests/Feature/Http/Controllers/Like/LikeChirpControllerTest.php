<?php

use App\Http\Controllers\Like\LikeChirpController;
use App\Models\Chirp;
use App\Models\Like;

use function Pest\Laravel\post;

use Symfony\Component\HttpFoundation\Response;

it('can store a like', function () {
    actingAsUser($user = user());

    $chirp = Chirp::factory()
        ->fromUser($user)
        ->create();

    post(action(LikeChirpController::class, $chirp))
        ->assertStatus(Response::HTTP_NO_CONTENT);

    expect(Like::count())->toBe(1);
    expect(Like::first())
        ->user->id->toBe($user->id)
        ->chirp->id->toBe($chirp->id);
    expect($chirp->likes)
        ->count()->toBe(1)
        ->contains(Like::first());
});
