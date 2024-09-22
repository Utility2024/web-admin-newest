<?php

namespace App\Observers;

use App\Models\Ticket;
use Illuminate\Support\Facades\Session;

class TicketObserver
{
    /**
     * Handle the Flooring "created" event.
     */
    public function created(Ticket $ticket): void
    {
        //
    }

    /**
     * Handle the Flooring "updated" event.
     */
    public function updated(Ticket $ticket): void
    {
        //
    }

    /**
     * Handle the Flooring "deleted" event.
     */
    public function deleted(Ticket $ticket): void
    {
        //
    }

    /**
     * Handle the Flooring "restored" event.
     */
    public function restored(Ticket $ticket): void
    {
        //
    }

    /**
     * Handle the Flooring "force deleted" event.
     */
    public function forceDeleted(Ticket $ticket): void
    {
        //
    }

    public function retrieved(Ticket $model)
    {
        Session::put('ticket_id', $model->id);
    }
}
