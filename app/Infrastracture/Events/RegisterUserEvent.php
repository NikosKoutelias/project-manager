<?php

namespace App\Infrastracture\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class RegisterUserEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $queue = 'low';

    /**
     * Create a new event instance.
     *
     * @return void
     *
     * @throws \Exception
     */
    public function __construct(
        public object $user,

    ) {}

    public function broadcastOn(): array
    {

        return [new PrivateChannel('site.private.'.$this->user)];
    }

    public function broadCastWith()
    {
        return ['user' => $this->user];
    }
}
