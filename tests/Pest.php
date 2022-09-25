<?php

use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Foundation\Testing\TestCase;
use Illuminate\Support\Collection;
use Tests\CreatesApplication;

/*
|--------------------------------------------------------------------------
| Test Case
|--------------------------------------------------------------------------
|
| The closure you provide to your test functions is always bound to a specific PHPUnit test
| case class. By default, that class is "PHPUnit\Framework\TestCase". Of course, you may
| need to change it using the "uses()" function to bind a different classes or traits.
|
*/

uses(TestCase::class, CreatesApplication::class, LazilyRefreshDatabase::class)
    ->in('Feature', 'Unit');

/*
|--------------------------------------------------------------------------
| Helpers
|--------------------------------------------------------------------------
*/

/**
 * Returns the current test case.
 */
function this(): TestCase
{
    return test()->target;
}

/**
 * Creates a new user.
 */
function user(array $attributes = [], ?int $count = null): User|Collection
{
    return User::factory($count)->create($attributes);
}

/**
 * Acts as a new user or the given one.
 */
function actingAsUser(?User $user = null, array $attributes = []): TestCase
{
    return test()->actingAs($user ??= user($attributes));
}
