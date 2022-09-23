<?php

use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Foundation\Testing\TestCase;
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

---------------------------------------------------------------------------
:: Helpers
---------------------------------------------------------------------------

*/

/**
 * A helper to create user
 *
 * @return User
 */
function user(User $user = null): User
{
    return $user ?? User::factory()->create();
}

/**
 * A helper to wrap $this and provide IDE autocompletion.
 *
 * @return TestCase
 */
function using($test): TestCase
{
    return $test;
}

/**
 * Set the currently logged in user for the application.
 *
 * @return TestCase
 */
function actingAs(\Illuminate\Foundation\Auth\User $user, string $driver = null): TestCase
{
    return test()->actingAs($user, $driver);
}
