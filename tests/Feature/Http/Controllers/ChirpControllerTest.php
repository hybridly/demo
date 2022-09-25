<?php

use App\Http\Controllers\ChirpController;
use App\Models\Attachment;
use App\Models\Chirp;
use Illuminate\Http\UploadedFile;

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
    Storage::fake('attachments');

    actingAsUser($user = user());

    $uploadedFile = UploadedFile::fake()->image('photo.jpg', 100, 100)->size(100);

    post(action([ChirpController::class, 'store']), [
        'body' => 'random-body-content',
        'attachments' => [
            [
                'file' => $uploadedFile,
            ],
        ],
    ])
        ->assertRedirect();

    expect(Chirp::count())->toBe(1);
    expect(Chirp::first())
        ->body->toBe('random-body-content')
        ->author->id->toBe($user->id);
    Storage::disk('attachments')->assertExists(Attachment::first()->path);
    expect(Attachment::count())->toBe(1);

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
