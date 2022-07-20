<?php

namespace App\Data;

use Spatie\LaravelData\Data;

final class UserData extends Data
{
    public function __construct(
        public readonly ?int $id,
        public readonly string $username,
        public readonly string $display_name,
        public readonly ?string $profile_picture_url,
        public readonly string $email,
    ) {
    }
}
