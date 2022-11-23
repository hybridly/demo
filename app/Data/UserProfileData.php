<?php

namespace App\Data;

use App\Models\User;
use Carbon\Carbon;
use Hybridly\Support\Data\DataResource;
use Illuminate\Database\Eloquent\Model;

final class UserProfileData extends DataResource
{
    protected Model|string|null $model = User::class;
    protected static array $authorizations = ['update'];

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
