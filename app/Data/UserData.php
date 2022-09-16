<?php

namespace App\Data;

use Carbon\Carbon;
use Spatie\LaravelData\Data;

final class UserData extends Data
{
    public function __construct(
        public readonly ?int $id,
        public readonly string $username,
        public readonly string $display_name,
        public readonly ?string $profile_picture_url,
        public readonly ?Carbon $identity_verified_at,
        public readonly string $email,
    ) {
    }
}
