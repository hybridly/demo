<?php

namespace App\Data\Hybridly;

use App\Data\UserData;
use Spatie\LaravelData\Data;

class SecurityData extends Data
{
    public function __construct(
        public readonly ?UserData $user,
        public readonly int $characters,
    ) {
    }
}
