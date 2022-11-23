<?php

use App\Models\Attachment;
use App\Models\Chirp;
use App\Support\Disk;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

use function Pest\Laravel\delete;
use function Pest\Laravel\get;
use function Pest\Laravel\post;

beforeEach(fn () => Storage::fake(Disk::Attachments));

test('users can see the index page', function () {
    Chirp::factory()->count(3)->create();

    $response = actingAsUser()
        ->get('/')
        ->assertOk()
        ->assertHybridView('chirps.index')
        ->assertHasHybridProperty('chirps', 3);

    expect($response->getHybridProperty('chirps.data'))
        ->toHaveCount(3);
});

test('guests cannot see the index page', function () {
    Chirp::factory()->count(3)->create();

    get('/')->assertRedirect(route('login'));
});

test('users can see a specific chirp', function () {
    $chirp = Chirp::factory()->create();

    $response = actingAsUser()
        ->get("/chirps/{$chirp->id}")
        ->assertOk()
        ->assertHybridView('chirps.show')
        ->assertHybridProperties([
            'chirp',
            'comments',
            'previous' => url()->route('index'),
        ]);

    expect($response->getHybridProperty('chirp'))
        ->toHaveKey('id', $chirp->id)
        ->toHaveKey('body', $chirp->body);

    expect($response->getHybridProperty('comments'))
        ->data->toBeEmpty();
});

test('a chirp with a parent redirects to the parent when going back', function () {
    $child = Chirp::factory()
        ->withParent($parent = Chirp::factory()->create())
        ->create();

    actingAsUser()
        ->get("/chirps/{$child->id}")
        ->assertHybridView('chirps.show')
        ->assertHybridProperties([
            'previous' => url()->route('chirp.show', $parent->id),
        ]);
});

test('guests cannot see a specific chirp', function () {
    $chirp = Chirp::factory()->create();

    get("/chirps/{$chirp->id}")->assertRedirect(route('login'));
});

test('users can delete their chirps', function () {
    $chirp = Chirp::factory()
        ->fromUser($user = user())
        ->create();

    actingAsUser($user)
        ->delete("/chirps/{$chirp->id}")
        ->assertRedirect();

    expect(Chirp::count())->toBe(0);
});

test('users are redirected back after deleting a chirp', function () {
    $chirp = Chirp::factory()
        ->fromUser($user = user())
        ->create();

    actingAsUser($user)
        ->from("/chirps/{$chirp->id}")
        ->delete("/chirps/{$chirp->id}")
        ->assertRedirect("/chirps/{$chirp->id}");
});

test('users are redirected to the specified `redirect_to` after deleting a chirp', function () {
    $chirp = Chirp::factory()
        ->fromUser($user = user())
        ->create();

    actingAsUser($user)
        ->from("/chirps/{$chirp->id}")
        ->delete("/chirps/{$chirp->id}", ['redirect_to' => '/'])
        ->assertRedirect('/');
});

test('guests cannot delete a chirp', function () {
    $chirp = Chirp::factory()->create();

    delete("/chirps/{$chirp->id}")->assertRedirect(route('login'));

    expect(Chirp::count())->toBe(1);
});

test('users can create a chirp with just a body', function () {
    actingAsUser($user = user())
        ->post('/chirps', [
            'body' => 'random-body-content',
        ])
        ->assertRedirect();

    expect(Chirp::count())->toBe(1);
    expect(Chirp::first())
        ->body->toBe('random-body-content')
        ->author->id->toBe($user->id)
        ->attachments->count()->toBe(0);
});

test('users can create a chirp with just an attachment', function () {
    actingAsUser($user = user())
        ->post('/chirps', [
            'attachments' => [
                ['file' => UploadedFile::fake()->image('photo.jpg', 100, 100)->size(100)],
            ],
        ])
        ->assertRedirect();

    expect(Chirp::count())->toBe(1);
    expect(Attachment::count())->toBe(1);

    expect($chirp = Chirp::first())
        ->author->id->toBe($user->id)
        ->body->toBeNull()
        ->attachments->count()->toBe(1);

    Storage::disk(Disk::Attachments)->assertExists($chirp->attachments->first()->path);
});

test('users can create a chirp with a body and an attachment', function () {
    actingAsUser($user = user())
        ->post('/chirps', [
            'body' => 'random-body-content',
            'attachments' => [
                ['file' => UploadedFile::fake()->image('photo.jpg', 100, 100)->size(100)],
            ],
        ])
        ->assertRedirect();

    expect(Chirp::count())->toBe(1);
    expect(Attachment::count())->toBe(1);

    expect($chirp = Chirp::first())
        ->body->toBe('random-body-content')
        ->author->id->toBe($user->id)
        ->attachments->count()->toBe(1);

    Storage::disk(Disk::Attachments)->assertExists($chirp->attachments->first()->path);
});

test('users cannot create a chirp with more than 3 attachments', function () {
    actingAsUser()
        ->post('/chirps', [
            'body' => 'random-body-content',
            'attachments' => array_fill(start_index: 0, count: 4, value: [
                'file' => UploadedFile::fake()->image('image.jpg', 100, 100)->size(100),
            ]),
        ])
        ->assertSessionHasErrors(['attachments']);

    expect(Chirp::count())->toBe(0);
    expect(Attachment::count())->toBe(0);

    Storage::disk(Disk::Attachments)->assertDirectoryEmpty('');
});

test('users cannot create a chirp with no body nor attachment', function () {
    actingAsUser(user())
        ->post('/chirps')
        ->assertSessionHasErrors(['body']);

    expect(Chirp::count())->toBe(0);
});

test('users cannot create a chirp with more than three attachments', function () {
    actingAsUser()
        ->post('/chirps', [
            'body' => 'random-body-content',
            'attachments' => [
                ['file' => UploadedFile::fake()->image('photo1.jpg', 100, 100)->size(100)],
                ['file' => UploadedFile::fake()->image('photo2.jpg', 100, 100)->size(100)],
                ['file' => UploadedFile::fake()->image('photo3.jpg', 100, 100)->size(100)],
                ['file' => UploadedFile::fake()->image('photo4.jpg', 100, 100)->size(100)],
            ],
        ])
        ->assertSessionHasErrors(['attachments']);
});

test('guests cannot create a chirp', function () {
    post('/chirps', [
        'body' => 'random-body-content',
    ])->assertRedirect();

    expect(Chirp::count())->toBe(0);
});
