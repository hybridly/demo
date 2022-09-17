<?php

namespace App\Data;

use Spatie\LaravelData\Data;

/**
 * Represents the data needed to create a new chirp.
 */
final class CreateChirpData extends Data
{
    public function __construct(
        public readonly string $body,
        public readonly ?string $parent_id,
    ) {
    }

    public static function rules(): array
    {
        return [
            'body' => 'max:' . config('chirp.characters'),
            'parent_id' => ['nullable', 'exists:chirps,id'],
        ];
    }

    public static function messages(): array
    {
        return [
            'body.max' => 'Spare your words, fool.',
            'parent_id.exists' => 'The chirp you are commenting on does not exists.',
        ];
    }
}
