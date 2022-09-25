<?php

use App\Http\Controllers\ChirpController;
use App\Http\Controllers\Like\LikeChirpController;
use App\Http\Controllers\Like\UnlikeChirpController;
use App\Models\Chirp;
use App\Models\Like;
use Illuminate\Testing\TestResponse;

use function Pest\Laravel\delete;
use function Pest\Laravel\get;
use function Pest\Laravel\post;

use Symfony\Component\HttpFoundation\Response;

/*
|--------------------------------------------------------------------------
| Creating chirps
|--------------------------------------------------------------------------
*/

test('any user can create chirps', function () {
    actingAsUser();

    $storeRequest = post(action([ChirpController::class, 'store'], [
        'body' => 'random-body',
    ]));
    expect($storeRequest)->isSuccessfulOrRedirect();
});

/*
|--------------------------------------------------------------------------
| Deleting chirps
|--------------------------------------------------------------------------
*/

it('will not allow user to delete a chirp they dont own', function () {
    actingAsUser();
    $chirp = Chirp::factory()->create();

    $deleteRequest = delete(action([ChirpController::class, 'destroy'], $chirp));

    expect($deleteRequest)->isForbidden();
});

/*
|--------------------------------------------------------------------------
| Liking chirps
|--------------------------------------------------------------------------
*/

it('will not allow user to like a chirp twice', function () {
    actingAsUser($user = user());
    $chirp = Chirp::factory()
        ->fromUser($user)
        ->has(Like::factory()->byUser($user)->count(1))
        ->create();

    post(action(LikeChirpController::class, $chirp))
        ->assertForbidden();
});

it('will allow user to like a chirp they have not yet liked before', function () {
    actingAsUser($user = user());
    $chirp = Chirp::factory()
        ->fromUser($user)
        ->create();

    post(action(LikeChirpController::class, $chirp))
        ->assertStatus(Response::HTTP_NO_CONTENT);
});

/*
|--------------------------------------------------------------------------
| Unliking chirps
|--------------------------------------------------------------------------
*/

it('will allow user to unlike a chirp they liked before', function () {
    actingAsUser($user = user());
    $chirp = Chirp::factory()
        ->fromUser($user)
        ->has(Like::factory()->byUser($user)->count(1))
        ->create();

    delete(action(UnlikeChirpController::class, $chirp))
        ->assertStatus(Response::HTTP_NO_CONTENT);
});

it('will not allow user to unlike a chirp they have not liked before', function () {
    actingAsUser($user = user());
    $chirp = Chirp::factory()
        ->fromUser($user)
        ->create();

    delete(action(UnlikeChirpController::class, $chirp))
        ->assertForbidden();
});

/*
|--------------------------------------------------------------------------
| Guest users
|--------------------------------------------------------------------------
*/

it('will not allow guest users to manage chirps', function (Closure $request) {
    $chirp = Chirp::factory()->create();

    expect($request($chirp))->isRedirectedToLogin();
})->with([
    'index' => fn () => fn (Chirp $chirp): TestResponse => get(action([ChirpController::class, 'index'])),
    'show' => fn () => fn (Chirp $chirp): TestResponse => get(action([ChirpController::class, 'show'], $chirp)),
    'store' => fn () => function (Chirp $chirp): TestResponse {
        return post(action([ChirpController::class, 'store']));
    },
    'destroy' => fn () => function (Chirp $chirp): TestResponse {
        return delete(action([ChirpController::class, 'destroy'], $chirp));
    },
]);
