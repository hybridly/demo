<?php

use App\Models\Attachment;
use App\Models\Chirp;
use App\Support\Disk;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

beforeEach(fn () => Storage::fake(Disk::Attachments));

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

it('deletes attached file after deletion', function () {
    $attachment = Attachment::factory()->create([
        'path' => $file = UploadedFile::fake()->image('fake.jpg')->store('', ['disk' => Disk::Attachments]),
    ]);

    Storage::disk(Disk::Attachments)->assertExists($file);

    $attachment->delete();

    Storage::disk(Disk::Attachments)->assertMissing($file);
});
