<?php

namespace App\Data\Monolikit;

use App\Data\UserData;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Lazy;

class SecurityData extends Data
{
    public function __construct(
        public readonly Lazy|UserData $user,
        public readonly int $characters,
    ) {
    }
}
