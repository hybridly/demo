<?php

use App\Models\Attachment;
use App\Models\Chirp;

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
