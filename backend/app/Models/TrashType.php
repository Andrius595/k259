<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrashType extends Model
{
    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'title',
    ];

    /**
     * The attributes that should be hidden for serialization.
     */
    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'id' => 'integer',
    ];
}
