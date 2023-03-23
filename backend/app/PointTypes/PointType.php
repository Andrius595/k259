<?php

namespace App\PointTypes;

use App\Models\PointsTransactions;
use Illuminate\Database\Eloquent\Model;

abstract class PointType
{
    public function __construct(public Model $subject)
    {
        PointsTransactions::create([
            'user_id' => $subject->user?->id,
            'points' => $this->getPoints(),
            'action' => $this->action,
            'subject_id' => $subject->id,
            'subject_type' => $subject::class,
        ]);
    }
    public function getPoints(): int
    {
        return $this->points;
    }

    public function getSubject(): Model
    {
        return $this->subject;
    }

    public function givePoints(): bool
    {
        return $this->getSubject()->user?->givePoints($this->getPoints()) ?? false;
    }
}
