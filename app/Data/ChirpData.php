<?php

namespace App\Data;

use Carbon\Carbon;
use Hybridly\Support\Data\DataResource;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\DataCollection;

final class ChirpData extends DataResource
{
    public static array $authorizations = ['comment', 'like', 'unlike', 'delete'];

    public function __construct(
        public readonly string $id,
        public readonly ?string $parent_id,
        public readonly ?string $body,
        #[DataCollectionOf(AttachmentData::class)]
        public readonly DataCollection $attachments,
        public readonly int $likes_count,
        public readonly int $comments_count,
        public readonly UserData $author,
        public readonly Carbon $created_at,
    ) {
    }
}
