<?php

namespace Database\Factories;

use App\Models\Chirp;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Chirp>
 */
class ChirpFactory extends Factory
{
    public function definition()
    {
        return [
            'body' => $this->faker->paragraph(1),
            'author_id' => fn () => User::factory(),
        ];
    }

    public function fromUser(User $user)
    {
        return $this->state([
            'author_id' => $user->id,
        ]);
    }

    public function withParent(Chirp $chirp)
    {
        return $this->state([
            'parent_id' => $chirp->id,
        ]);
    }
}
