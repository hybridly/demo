<?php

namespace App\Models;

use App\Support\Disk;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

/**
 * @mixin IdeHelperAttachment
 */
class Attachment extends Model
{
    use HasFactory;

    protected $appends = ['url'];

    /*
    |--------------------------------------------------------------------------
    | Configuration
    |--------------------------------------------------------------------------
    */

    public static function booted(): void
    {
        static::deleting(function (self $attachment) {
            Storage::disk(Disk::Attachments)->delete($attachment->path);
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Relations
    |--------------------------------------------------------------------------
    */

    public function chirp(): BelongsTo
    {
        return $this->belongsTo(Chirp::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Attributes
    |--------------------------------------------------------------------------
    */

    public function getUrlAttribute(): string
    {
        return Storage::disk(Disk::Attachments)->url($this->path);
    }
}
