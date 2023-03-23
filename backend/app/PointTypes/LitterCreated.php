<?php

namespace App\PointTypes;

use App\Models\Litter;

class LitterCreated extends PointType
{
    public int $points = 2;

    public string $action = 'litter_created';

}
