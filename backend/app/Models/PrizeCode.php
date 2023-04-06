<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class PrizeCode extends Model
{
    use HasFactory;

    protected $fillable = [
        'prize_id',
        'code',
        'is_redeemed',
    ];

    public function prize(): BelongsTo
    {
        return $this->belongsTo(Prize::class);
    }
}
