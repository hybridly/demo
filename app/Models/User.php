<?php

namespace App\Models;

use App\Support\Disk;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;

/**
 * @mixin IdeHelperUser
 */
class User extends Authenticatable
{
    use HasFactory;
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relations
    |--------------------------------------------------------------------------
    */

    public function chirps(): HasMany
    {
        return $this->hasMany(Chirp::class, foreignKey: 'author_id');
    }

    public function likes(): HasMany
    {
        return $this->hasMany(Like::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Attributes
    |--------------------------------------------------------------------------
    */

    public function displayName(): Attribute
    {
        return Attribute::make(
            get: fn ($display_name) => $display_name ?: $this->username,
        );
    }

    public function profilePictureUrl(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->profile_picture_path
                ? Storage::disk(Disk::ProfilePictures)->url($this->profile_picture_path)
                : null,
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Likes
    |--------------------------------------------------------------------------
    */

    /**
     * Checks if the user has liked the given chirp.
     */
    public function hasLiked(Chirp $chirp): bool
    {
        if (!$chirp->exists) {
            return false;
        }

        return $chirp
            ->likes()
            ->whereHas('user', fn (Builder $q) => $q->where('id', $this->id))
            ->exists();
    }
}
