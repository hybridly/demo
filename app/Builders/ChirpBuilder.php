<?php

namespace App\Builders;

use Illuminate\Database\Eloquent\Builder;

class ChirpBuilder extends Builder
{
    public function forHomePage(): static
    {
        // Insert some cutting-edge cringe social network algorithm here
        $this->orderByDesc('created_at');

        return $this;
    }
}
