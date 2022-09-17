<?php

use App\Models\Chirp;
use App\Models\Like;

test('a chirp can have a comment', function () {
    $chirp = Chirp::factory()->create();
    $comment = Chirp::factory()->create([
        'parent_id' => $chirp->id,
    ]);

    expect($chirp->comments)->toHaveCount(1);
    expect($comment->parent->id)->toBe($chirp->id);
});

test('a chirp can have a like', function () {
    $chirp = Chirp::factory()->create();
    $like = Like::factory()->create([
        'chirp_id' => $chirp->id,
    ]);

    expect($chirp->likes)->toHaveCount(1);
    expect($like->chirp->id)->toBe($chirp->id);
});

test('comment and like counts are always loaded with a chirp', function () {
    $chirp = Chirp::factory()
        ->has(Like::factory()->count(1))
        ->has(Chirp::factory()->count(2), 'comments')
        ->create();

    expect(Chirp::find($chirp->id))
        ->comments_count->toBe(2)
        ->likes_count->toBe(1);
});

test('chirps without parents can be queried', function () {
    Chirp::factory()
        ->state(['body' => 'uwu'])
        ->has(Chirp::factory()->count(2), 'comments')
        ->create();

    expect(Chirp::query()->isMain()->get())
        ->toHaveCount(1)
        ->first()->body->toBe('uwu')
        ->first()->comments_count->toBe(2);
});
