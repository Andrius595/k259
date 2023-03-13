<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}