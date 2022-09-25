<?php

use App\Http\Controllers\ChirpController;
use App\Models\Chirp;

use function Pest\Laravel\delete;
use function Pest\Laravel\get;
use function Pest\Laravel\post;

/*
|--------------------------------------------------------------------------
| Index method
|--------------------------------------------------------------------------
*/

it('can view chirps index page', function () {
    Chirp::factory()->count(3)->create();

    actingAsUser();

    get(action([ChirpController::class, 'index']))
        ->assertOk();
});

/*
|--------------------------------------------------------------------------
| Show method
|--------------------------------------------------------------------------
*/

it('can show chirp', function () {
    $chirp = Chirp::factory()->create();

    actingAsUser();

    get(action([ChirpController::class, 'show'], $chirp))
        ->assertOk();
});

/*
|--------------------------------------------------------------------------
| Store method
|--------------------------------------------------------------------------
*/

it('can store chirp', function () {
    actingAsUser($user = user());

    post(action([ChirpController::class, 'store'], [
        'body' => 'random-body-content',
    ]))
        ->assertRedirect();

    expect(Chirp::count())->toBe(1);
    expect(Chirp::first())
        ->body->toBe('random-body-content')
        ->author->id->toBe($user->id);

    // Validation check.
    post(action([ChirpController::class, 'store']))
        ->assertRedirect()
        ->assertSessionHasErrors([
            'body',
        ]);

    expect(Chirp::count())->toBe(1);
});

/*
|--------------------------------------------------------------------------
| Destroy method
|--------------------------------------------------------------------------
*/

it('can delete chirp', function () {
    actingAsUser($user = user());

    $chirp = Chirp::factory()
        ->fromUser($user)
        ->create();

    delete(action([ChirpController::class, 'destroy'], $chirp))
        ->assertRedirect();

    expect(Chirp::count())->toBe(0);
});
