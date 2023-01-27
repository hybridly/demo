<?php

namespace App\Data;

use Spatie\LaravelData\Data;

class UpdateChirpData extends Data
{
    public function __construct(
        public readonly string $body,
    ) {
    }

    public static function rules(): array
    {
        return [
            'body' => [
                'required',
                'max:' . config('chirp.characters'),
            ],
        ];
    }
}
