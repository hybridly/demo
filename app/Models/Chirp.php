<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @mixin IdeHelperChirp
 */
class Chirp extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, foreignKey: 'author_id');
    }
}
