<?php

namespace App\Events;

use App\Models\Relay;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class RelayStatusUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $relay;

    public function __construct(Relay $relay)
    {
        $this->relay = $relay;
    }

    public function broadcastOn()
    {
        return new Channel('relay-status-channel');
    }

    public function broadcastWith()
    {
        return [
            'relay_number' => $this->relay->relay_number,
            'status' => $this->relay->status,
        ];
    }
}
