<?php

use App\Models\Chirp;
use App\Models\Like;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

it('has a author relationship', function () {
    $chirp = Chirp::factory()
        ->fromUser(user())
        ->create();

    expect($chirp->author)->toBeInstanceOf(User::class);
});

it('has a likes relationship', function () {
    $chirp = Chirp::factory()
        ->fromUser($user = user())
        ->has(Like::factory()->byUser($user)->count(1))
        ->create();

    expect($chirp->likes)
        ->toBeInstanceOf(Collection::class)
        ->toHaveCount(1)
        ->contains($like = Like::first())->tobeTrue();

    expect($like->chirp->id)->toBe($chirp->id);
});

it('has a parent relationship', function () {
    $chirp = Chirp::factory()
        ->fromUser(user())
        ->withParent(Chirp::factory()->create())
        ->create();

    expect($chirp->parent)->toBeInstanceOf(Chirp::class);
});

it('has a comments relationship', function () {
    $chirp = Chirp::factory()
        ->fromUser(user())
        ->withParent($parent_chirp = Chirp::factory()->create())
        ->create();

    expect($parent_chirp->comments)
        ->toBeInstanceOf(Collection::class)
        ->toHaveCount(1)
        ->contains($chirp)->tobeTrue();

    expect($chirp->parent->id)->toBe($parent_chirp->id);
});

it('has a attachments relationship', function () {
    $chirp = Chirp::factory()
        ->fromUser(user())
        ->create();

    expect($chirp->attachments)
        ->toBeInstanceOf(Collection::class)
        ->count()->toBe(0);
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
