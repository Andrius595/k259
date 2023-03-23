<?php

namespace App\Traits;

trait InteractsWithPoints
{
    public function givePoints(int $points): bool
    {
        return (bool)$this->increment('points', $points);
    }

    public function takePoints(int $points): bool
    {
        return (bool)$this->decrement('points', $points);
    }
}
