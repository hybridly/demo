<?php

use App\Models\Attachment;
use App\Models\Chirp;
use Illuminate\Http\UploadedFile;

it('has a chirp relationship', function () {
    $chirp = Chirp::factory()->create();
    $attachment = Attachment::factory()
        ->for($chirp)
        ->create();

    expect($attachment->chirp)->toBeInstanceOf(Chirp::class);
    expect($attachment->chirp->id)->toBe($chirp->id);
});

it('has a url attribute', function () {
    $attachment = Attachment::factory()->create();

    expect($attachment->url)
        ->toBeString()
        ->not->toBeEmpty();
});

it('deletes attachment file after model is deleted', function () {
    Storage::fake('attachments');

    $file = UploadedFile::fake()->image('fake.jpg')->store('', ['disk' => 'attachments']);

    $attachment = Attachment::factory()->create([
        'path' => $file,
    ]);

    Storage::disk('attachments')->assertExists($file);

    $attachment->delete();

    Storage::disk('attachments')->assertMissing($file);
});
