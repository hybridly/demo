<?php

namespace App\Data;

use Carbon\Carbon;
use Spatie\LaravelData\Data;

final class UserProfileData extends Data
{
    public function __construct(
        public readonly int $id,
        public readonly string $username,
        public readonly string $display_name,
        public readonly ?string $about,
        public readonly ?string $profile_picture_url,
        public readonly ?Carbon $identity_verified_at,
        public readonly Carbon $created_at,
        public readonly int $chirps_count,
        public readonly int $likes_count,
    ) {
    }
}
