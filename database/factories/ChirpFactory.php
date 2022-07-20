<?php

namespace Database\Factories;

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
}
