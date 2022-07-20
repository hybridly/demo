<?php

namespace App\Data;

use Carbon\Carbon;
use Spatie\LaravelData\Data;

final class ChirpData extends Data
{
    public function __construct(
        public readonly string $id,
        public readonly string $body,
        public readonly UserData $author,
        public readonly Carbon $created_at,
    ) {
    }
}
