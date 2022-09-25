<?php

namespace Database\Factories;

use App\Models\Chirp;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Attachment>
 */
class AttachmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'chirp_id' => fn () => Chirp::factory(),
            'path' => fake()->imageUrl(),
        ];
    }
}
