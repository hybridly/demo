<?php

namespace App\Builders;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

class ChirpBuilder extends Builder
{
    public function forHomePage(): static
    {
        // Insert some cutting-edge cringe social network algorithm here
        return $this->isMain()->orderByDesc('created_at');
    }

    public function withLikesAndComments(): static
    {
        return $this->withCount('likes')->withCount('comments');
    }

    public function isMain(): static
    {
        return $this->whereNull('parent_id');
    }

    public function isLikedBy(User $user): static
    {
        return $this->whereHas('likes', function (Builder $query) use ($user) {
            $query->where('user_id', $user->id);
        });
    }
}
