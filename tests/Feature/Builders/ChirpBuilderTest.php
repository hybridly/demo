<?php

use App\Actions\LikeChirp;
use App\Models\Chirp;
use Illuminate\Database\Eloquent\Collection;
use Pest\Expectation;

use function Pest\Laravel\assertDatabaseCount;

test('the forHomePage method returns main tweets sorted by creation date', function () {
    Chirp::factory()->withComment()->create(['created_at' => now()->subMinutes(2), 'body' => 'first']);
    Chirp::factory()->withComment()->create(['created_at' => now()->subMinutes(1), 'body' => 'second']);

    expect(Chirp::forHomePage()->get())
        ->toHaveCount(2)
        ->sequence(
            fn (Expectation $chirp) => $chirp->body->toBe('second'),
            fn (Expectation $chirp) => $chirp->body->toBe('first'),
        );
});

test('the sortedForComments method returns tweets sorted by creation date', function () {
    $main = Chirp::factory()->create();

    Chirp::factory()->withParent($main)->create(['created_at' => now()->subMinutes(2), 'body' => 'first']);
    Chirp::factory()->withParent($main)->create(['created_at' => now()->subMinutes(1), 'body' => 'second']);

    expect($main->comments()->sortedForComments()->get())
        ->toHaveCount(2)
        ->sequence(
            fn (Expectation $chirp) => $chirp->body->toBe('second'),
            fn (Expectation $chirp) => $chirp->body->toBe('first'),
        );
});

test('the sortedForComments method displays comments from current user first', function () {
    actingAsUser($user = user());

    $main = Chirp::factory()->create();

    Chirp::factory()->fromUser($user)->withParent($main)->create(['created_at' => now()->subMinutes(3), 'body' => 'first, from current user']);
    Chirp::factory()->withParent($main)->create(['created_at' => now()->subMinutes(2), 'body' => 'second']);
    Chirp::factory()->withParent($main)->create(['created_at' => now()->subMinutes(1), 'body' => 'third']);

    expect($main->comments()->sortedForComments()->get())
        ->toHaveCount(3)
        ->sequence(
            fn (Expectation $chirp) => $chirp
                ->body->toBe('first, from current user')
                ->author_id->toBe($user->id),
            fn (Expectation $chirp) => $chirp->body->toBe('third'),
            fn (Expectation $chirp) => $chirp->body->toBe('second'),
        );
});

test('the withLikeAndCommentCounts method returns chirps with likes and comments count', function () {
    Chirp::factory()->withComment()->withLike()->create();

    expect(Chirp::withLikeAndCommentCounts()->first())
        ->comments_count->toBe(1)
        ->likes_count->toBe(1);
});

test('the isMain method returns only tweets without parents', function () {
    Chirp::factory()->withComment(4)->create();

    expect(Chirp::isMain()->get())
        ->toBeInstanceOf(Collection::class)
        ->toHaveCount(1);

    assertDatabaseCount('chirps', 5);
});

test('the isComment method returns only tweets with parents', function () {
    Chirp::factory()->withComment(4)->create();

    expect(Chirp::isComment()->get())
        ->toBeInstanceOf(Collection::class)
        ->toHaveCount(4);

    assertDatabaseCount('chirps', 5);
});

test('the isLikedBy methods returns only chirps liked by the given user', function () {
    $chirp = Chirp::factory()->create();
    $users = user(count: 2);

    LikeChirp::run($users->get(1), $chirp);

    expect(Chirp::isLikedBy($users->get(0))->get())->toHaveCount(0);
    expect(Chirp::isLikedBy($users->get(1))->get())->toHaveCount(1);
});
