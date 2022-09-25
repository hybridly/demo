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

    public $with = ['author', 'attachments'];

    /*
    |--------------------------------------------------------------------------
    | Configuration
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

    protected static function booted()
    {
        // https://github.com/laravel/framework/issues/32964
        static::addGlobalScope('withCounts', function (ChirpBuilder $builder) {
            $builder->withLikeAndCommentCounts();
        });
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

    public function parent(): BelongsTo
    {
        return $this->belongsTo(static::class, foreignKey: 'parent_id');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(static::class, foreignKey: 'parent_id')
            ->withoutGlobalScope('withCounts')
            ->sortedForComments();
    }

    public function attachments(): HasMany
    {
        return $this->hasMany(Attachment::class);
    }
}
