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
    ) {
    }

    public static function rules(): array
    {
        return [
            'body' => 'max:' . config('chirp.characters'),
        ];
    }
}
