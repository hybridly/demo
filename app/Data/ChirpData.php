<?php

namespace App\Data;

use Carbon\Carbon;
use Hybridly\Support\Data\DataResource;

final class ChirpData extends DataResource
{
    public static array $authorizations = ['comment', 'like', 'unlike'];

    public function __construct(
        public readonly string $id,
        public readonly string $body,
        public readonly int $likes_count,
        public readonly int $comments_count,
        public readonly UserData $author,
        public readonly Carbon $created_at,
    ) {
    }
}
