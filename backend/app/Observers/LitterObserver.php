<?php

namespace App\Observers;

use App\Models\Litter;
use App\PointTypes\LitterCleaned;
use App\PointTypes\LitterCreated;

class LitterObserver
{
    /**
     * Handle the Litter "created" event.
     */
    public function created(Litter $litter): void
    {
        $litterCreated = new LitterCreated($litter);

        $litterCreated->givePoints();
    }

    public function updating(Litter $litter): void
    {
        if ($litter->isDirty('is_cleaned') && $litter->is_cleaned) {
            $litterCleaned = new LitterCleaned($litter);
            $litterCleaned->givePoints();
        }
    }

    /**
     * Handle the Litter "updated" event.
     *
     * @param  \App\Models\Litter  $litter
     * @return void
     */
    public function updated(Litter $litter)
    {
        //
    }

    /**
     * Handle the Litter "deleted" event.
     *
     * @param  \App\Models\Litter  $litter
     * @return void
     */
    public function deleted(Litter $litter)
    {
        //
    }

    /**
     * Handle the Litter "restored" event.
     *
     * @param  \App\Models\Litter  $litter
     * @return void
     */
    public function restored(Litter $litter)
    {
        //
    }

    /**
     * Handle the Litter "force deleted" event.
     *
     * @param  \App\Models\Litter  $litter
     * @return void
     */
    public function forceDeleted(Litter $litter)
    {
        //
    }
}
