<?php

namespace App\Data;

use Illuminate\Http\UploadedFile;
use Illuminate\Validation\Rules\File;
use Spatie\LaravelData\Data;

class CreateAttachmentData extends Data
{
    public function __construct(
        public readonly ?UploadedFile $file,
        public readonly ?string $alt,
    ) {
    }

    public static function rules(): array
    {
        return [
            'file' => File::image()->max(12 * 1024),
            'alt' => 'max:255',
        ];
    }
}
