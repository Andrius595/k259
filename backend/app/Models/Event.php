<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'starting_at',
        'latitude',
        'longitude',
        'image_path',
        'has_ended',
    ];

    protected $appends = [
        'has_user_joined',
        'joined_users_count',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function joinedUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    public function getHasUserJoinedAttribute(): bool
    {
        return $this->joinedUsers()->where('user_id', auth()->id())->exists();
    }

    public function getJoinedUsersCountAttribute(): int
    {
        return $this->joinedUsers()->count();
    }
}
