<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'logo_path',
    ];

    protected $appends = [
        'logo_src',
    ];

    public function getLogoSrcAttribute()
    {
        // TODO return no-image if image_path is null
        if (str_starts_with($this->logo_path, 'http')) {
            return $this->logo_path;
        }

        return asset('storage/' . $this->logo_path, false);
    }
}
