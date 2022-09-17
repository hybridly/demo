<?php

namespace App\Data;

use Carbon\Carbon;
use Spatie\LaravelData\Data;

class AttachmentData extends Data
{
    public function __construct(
        public readonly string $id,
        public readonly string $url,
        public readonly string $alt,
        public readonly Carbon $created_at,
    ) {
    }
}
