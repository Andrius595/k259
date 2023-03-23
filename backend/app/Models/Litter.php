<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Litter extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'cleaner_id',
        'size',
        'latitude',
        'longitude',
        'image_path',
        'description',
        'is_accessible_by_car',
        'is_located_in_hole',
        'is_under_water',
        'is_on_the_waterside',
        'is_hard_to_reach',
        'is_cleaned',
    ];

    protected $appends = [
        'image_src',
    ];

    public function trashTypes(): BelongsToMany
    {
        return $this->belongsToMany(TrashType::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function cleaner(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getImageSrcAttribute()
    {
        // TODO return no-image if image_path is null
        if (str_starts_with($this->image_path, 'http')) {
            return $this->image_path;
        }

        return asset('storage/' . $this->image_path);
    }
}
