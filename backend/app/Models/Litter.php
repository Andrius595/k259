<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Litter extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'user_id',
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

    public function trashTypes(): BelongsToMany
    {
        return $this->belongsToMany(TrashType::class);
    }
}
