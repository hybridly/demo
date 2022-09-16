<?php

namespace App\Builders;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

class ChirpBuilder extends Builder
{
    public function forHomePage(): static
    {
        // Insert some cutting-edge cringe social network algorithm here
        $this->orderByDesc('created_at');

        return $this;
    }

    public function isLikedBy(User $user): static
    {
        $this->whereHas('likes', function (Builder $query) use ($user) {
            $query->where('user_id', $user->id);
        });

        return $this;
    }
}
