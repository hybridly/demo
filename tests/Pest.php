<?php

use App\Models\User;
use Illuminate\Support\Collection;
use Tests\TestCase;

uses(TestCase::class)->in('Feature', 'Unit');

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
