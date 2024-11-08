<?php

namespace App\Observers;

use App\Models\MasterWip;
use Illuminate\Support\Facades\Session;

class MasterWipObserver
{
    /**
     * Handle the Flooring "created" event.
     */
    public function created(MasterWip $ticket): void
    {
        //
    }

    /**
     * Handle the Flooring "updated" event.
     */
    public function updated(MasterWip $ticket): void
    {
        //
    }

    /**
     * Handle the Flooring "deleted" event.
     */
    public function deleted(MasterWip $ticket): void
    {
        //
    }

    /**
     * Handle the Flooring "restored" event.
     */
    public function restored(MasterWip $ticket): void
    {
        //
    }

    /**
     * Handle the Flooring "force deleted" event.
     */
    public function forceDeleted(MasterWip $ticket): void
    {
        //
    }

    public function retrieved(MasterWip $model)
    {
        Session::put('master_wips_id', $model->id);
    }
}
