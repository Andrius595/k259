<?php

namespace App\PointTypes;

class LitterCleaned extends PointType
{
    public int $points = 5;

    public string $action = 'litter_cleaned';

    public function givePoints(): bool
    {
        return $this->getSubject()->cleaner?->givePoints($this->getPoints()) ?? false;
    }
}
