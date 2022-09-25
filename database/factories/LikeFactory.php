<?php

namespace Database\Factories;

use App\Models\Chirp;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Like>
 */
class LikeFactory extends Factory
{
    public function definition()
    {
        return [
            'user_id' => fn () => User::factory(),
            'chirp_id' => fn () => Chirp::factory(),
        ];
    }

    public function byUser(User $user)
    {
        return $this->state([
            'user_id' => $user->id,
        ]);
    }

    public function forChirp(Chirp $chirp)
    {
        return $this->state([
            'chirp_id' => $chirp->id,
        ]);
    }
}
