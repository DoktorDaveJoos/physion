<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ExposeCreated implements ShouldBroadcastNow
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;


    /**
     * Create a new notification instance.
     * @param $teamId
     */
    public function __construct(
        private readonly int $teamId,
    ) {
    }

    public function broadcastAs(): string
    {
        return 'expose.created';
    }

    public function broadcastOn(): array
    {
        return [
            new Channel('team.'.$this->teamId),
        ];
    }
}
