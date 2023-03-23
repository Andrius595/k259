<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PointsTransactions extends Model
{
    protected $fillable = [
        'user_id',
        'points',
        'action',
        'subject_id',
        'subject_type',
        'meta',
    ];
}
