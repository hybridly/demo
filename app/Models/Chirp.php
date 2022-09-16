<?php

namespace App\Models;

use App\Builders\ChirpBuilder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @mixin IdeHelperChirp
 */
class Chirp extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $with = ['author'];
    public $withCount = ['likes'];

    /*
    |--------------------------------------------------------------------------
    | Builder
    |--------------------------------------------------------------------------
    */

    public static function query(): ChirpBuilder
    {
        return parent::query();
    }

    public function newEloquentBuilder($query)
    {
        return new ChirpBuilder($query);
    }

    /*
    |--------------------------------------------------------------------------
    | Relations
    |--------------------------------------------------------------------------
    */

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, foreignKey: 'author_id');
    }

    public function likes(): HasMany
    {
        return $this->hasMany(Like::class);
    }
}
