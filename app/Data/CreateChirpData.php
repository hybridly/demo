<?php

namespace App\Data;

use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;

/**
 * Represents the data needed to create a new chirp.
 */
final class CreateChirpData extends Data
{
    public function __construct(
        public readonly ?string $body,
        public readonly ?string $parent_id,
        #[DataCollectionOf(CreateAttachmentData::class)]
        public readonly ?DataCollection $attachments,
    ) {
    }

    public static function rules(): array
    {
        return [
            'body' => [
                'required_without:attachments',
                'max:' . config('chirp.characters'),
            ],
            'parent_id' => ['nullable', 'exists:chirps,id'],
            'attachments' => ['max:3'],
        ];
    }

    public static function messages(): array
    {
        return [
            'body.max' => 'Spare your words, fool.',
            'body.required_without' => "If there is not attachment nor text, what's the content? Huh?",
            'parent_id.exists' => 'The chirp you are commenting on does not exists.',
            'attachments.*.file' => 'Attachments must be images.',
            'attachments.max' => 'You can only add :max attachments at once.',
        ];
    }
}
